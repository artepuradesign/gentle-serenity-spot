<?php
/**
 * NU Bank Virtual - API de Conta do Usuário
 * GET /api/conta.php?usuario_id=X - Dados da conta, saldo e últimas transações
 */
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit();
}

$pdo = getConnection();
$usuarioId = intval($_GET['usuario_id'] ?? 0);

if (!$usuarioId) {
    http_response_code(400);
    echo json_encode(['error' => 'usuario_id é obrigatório']);
    exit();
}

try {
    // Dados da conta e titular
    $stmt = $pdo->prepare("
        SELECT c.id as conta_id, c.agencia, c.numero_conta, c.saldo, c.limite_credito, c.status as conta_status,
            u.email, u.tipo_conta,
            COALESCE(pf.nome_completo, pj.razao_social) as titular,
            COALESCE(pf.cpf, pj.cnpj) as documento,
            pf.telefone as telefone
        FROM contas c
        JOIN usuarios u ON u.id = c.usuario_id
        LEFT JOIN pessoas_fisicas pf ON pf.usuario_id = u.id
        LEFT JOIN pessoas_juridicas pj ON pj.usuario_id = u.id
        WHERE c.usuario_id = ?
        LIMIT 1
    ");
    $stmt->execute([$usuarioId]);
    $conta = $stmt->fetch();

    if (!$conta) {
        http_response_code(404);
        echo json_encode(['error' => 'Conta não encontrada']);
        exit();
    }

    // Últimas 20 transações
    $stmt = $pdo->prepare("
        SELECT id, tipo, categoria, descricao, valor, saldo_anterior, saldo_posterior, 
            data_transacao, beneficiario_nome, codigo_autenticacao
        FROM transacoes
        WHERE conta_id = ?
        ORDER BY data_transacao DESC
        LIMIT 20
    ");
    $stmt->execute([$conta['conta_id']]);
    $transacoes = $stmt->fetchAll();

    // Fatura do cartão (soma saídas do mês atual com categoria cartão)
    $stmt = $pdo->prepare("
        SELECT COALESCE(SUM(valor), 0) as fatura_atual
        FROM transacoes
        WHERE conta_id = ? AND tipo = 'saida' AND categoria = 'CARTAO'
        AND MONTH(data_transacao) = MONTH(CURRENT_DATE())
        AND YEAR(data_transacao) = YEAR(CURRENT_DATE())
    ");
    $stmt->execute([$conta['conta_id']]);
    $fatura = $stmt->fetch();

    echo json_encode([
        'conta' => [
            'conta_id' => intval($conta['conta_id']),
            'titular' => $conta['titular'],
            'documento' => $conta['documento'],
            'email' => $conta['email'],
            'telefone' => $conta['telefone'],
            'tipo_conta' => $conta['tipo_conta'],
            'agencia' => $conta['agencia'],
            'numero_conta' => $conta['numero_conta'],
            'saldo' => floatval($conta['saldo']),
            'limite_credito' => floatval($conta['limite_credito']),
            'conta_status' => $conta['conta_status'],
        ],
        'fatura_atual' => floatval($fatura['fatura_atual']),
        'transacoes' => $transacoes,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar dados da conta: ' . $e->getMessage()]);
}
