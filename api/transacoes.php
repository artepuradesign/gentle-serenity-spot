<?php
/**
 * NU Bank Virtual - API de Transações
 * GET /api/transacoes.php?conta_id=X - Listar transações
 * POST /api/transacoes.php - Criar transação (admin)
 */
require_once 'config.php';

$pdo = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $contaId = intval($_GET['conta_id'] ?? 0);
    $dataInicio = $_GET['data_inicio'] ?? date('Y-m-d', strtotime('-1 year'));
    $dataFim = $_GET['data_fim'] ?? date('Y-m-d');

    $stmt = $pdo->prepare("
        SELECT t.*, c.numero_conta, c.agencia
        FROM transacoes t
        JOIN contas c ON c.id = t.conta_id
        WHERE t.conta_id = ? AND DATE(t.data_transacao) BETWEEN ? AND ?
        ORDER BY t.data_transacao ASC
    ");
    $stmt->execute([$contaId, $dataInicio, $dataFim]);
    $transacoes = $stmt->fetchAll();

    // Resumo
    $stmt = $pdo->prepare("SELECT saldo FROM contas WHERE id = ?");
    $stmt->execute([$contaId]);
    $conta = $stmt->fetch();

    echo json_encode([
        'transacoes' => $transacoes,
        'saldo_atual' => $conta['saldo'] ?? 0,
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    try {
        $pdo->beginTransaction();

        $contaId = intval($data['conta_id']);
        $tipo = $data['tipo']; // entrada ou saida
        $valor = floatval($data['valor']);

        // Obter saldo atual
        $stmt = $pdo->prepare("SELECT saldo FROM contas WHERE id = ? FOR UPDATE");
        $stmt->execute([$contaId]);
        $conta = $stmt->fetch();
        $saldoAnterior = floatval($conta['saldo']);
        $saldoPosterior = $tipo === 'entrada' ? $saldoAnterior + $valor : $saldoAnterior - $valor;

        // Inserir transação
        $stmt = $pdo->prepare("
            INSERT INTO transacoes (conta_id, tipo, categoria, descricao, valor, saldo_anterior, saldo_posterior, data_transacao,
                beneficiario_nome, beneficiario_documento, beneficiario_banco, beneficiario_banco_codigo, beneficiario_agencia, beneficiario_conta,
                codigo_autenticacao, admin_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $contaId, $tipo, $data['categoria'], $data['descricao'], $valor,
            $saldoAnterior, $saldoPosterior, $data['data_transacao'],
            $data['beneficiario_nome'] ?? null, $data['beneficiario_documento'] ?? null,
            $data['beneficiario_banco'] ?? null, $data['beneficiario_banco_codigo'] ?? null,
            $data['beneficiario_agencia'] ?? null, $data['beneficiario_conta'] ?? null,
            bin2hex(random_bytes(16)), $data['admin_id'] ?? null,
        ]);

        // Atualizar saldo
        $stmt = $pdo->prepare("UPDATE contas SET saldo = ? WHERE id = ?");
        $stmt->execute([$saldoPosterior, $contaId]);

        $pdo->commit();
        echo json_encode(['success' => true, 'saldo' => $saldoPosterior]);
    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
