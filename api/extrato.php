<?php
/**
 * NU Bank Virtual - API de Extrato
 * GET /api/extrato.php?conta_id=X&data_inicio=YYYY-MM-DD&data_fim=YYYY-MM-DD
 */
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit();
}

$pdo = getConnection();

$contaId = intval($_GET['conta_id'] ?? 0);
$dataInicio = $_GET['data_inicio'] ?? date('Y-m-d', strtotime('-1 year'));
$dataFim = $_GET['data_fim'] ?? date('Y-m-d');

try {
    // Dados da conta e titular
    $stmt = $pdo->prepare("
        SELECT c.*, u.tipo_conta, u.email,
            COALESCE(pf.nome_completo, pj.razao_social) as titular,
            COALESCE(pf.cpf, pj.cnpj) as documento
        FROM contas c
        JOIN usuarios u ON u.id = c.usuario_id
        LEFT JOIN pessoas_fisicas pf ON pf.usuario_id = u.id
        LEFT JOIN pessoas_juridicas pj ON pj.usuario_id = u.id
        WHERE c.id = ?
    ");
    $stmt->execute([$contaId]);
    $conta = $stmt->fetch();

    if (!$conta) {
        http_response_code(404);
        echo json_encode(['error' => 'Conta não encontrada']);
        exit();
    }

    // Saldo inicial (saldo anterior à primeira transação do período)
    $stmt = $pdo->prepare("
        SELECT saldo_anterior FROM transacoes
        WHERE conta_id = ? AND DATE(data_transacao) >= ?
        ORDER BY data_transacao ASC LIMIT 1
    ");
    $stmt->execute([$contaId, $dataInicio]);
    $primeira = $stmt->fetch();
    $saldoInicial = $primeira ? floatval($primeira['saldo_anterior']) : floatval($conta['saldo']);

    // Transações do período
    $stmt = $pdo->prepare("
        SELECT * FROM transacoes
        WHERE conta_id = ? AND DATE(data_transacao) BETWEEN ? AND ?
        ORDER BY data_transacao ASC
    ");
    $stmt->execute([$contaId, $dataInicio, $dataFim]);
    $transacoes = $stmt->fetchAll();

    // Totais
    $totalEntradas = 0;
    $totalSaidas = 0;
    $rendimentoLiquido = 0;

    foreach ($transacoes as $t) {
        if ($t['tipo'] === 'entrada') {
            $totalEntradas += floatval($t['valor']);
            if ($t['categoria'] === 'RENDIMENTO') {
                $rendimentoLiquido += floatval($t['valor']);
            }
        } else {
            $totalSaidas += floatval($t['valor']);
        }
    }

    $saldoFinal = $saldoInicial + $totalEntradas - $totalSaidas;

    // Agrupar por dia
    $porDia = [];
    foreach ($transacoes as $t) {
        $dia = date('Y-m-d', strtotime($t['data_transacao']));
        if (!isset($porDia[$dia])) $porDia[$dia] = [];
        $porDia[$dia][] = $t;
    }

    echo json_encode([
        'conta' => [
            'titular' => $conta['titular'],
            'documento' => $conta['documento'],
            'tipo_conta' => $conta['tipo_conta'],
            'agencia' => $conta['agencia'],
            'numero_conta' => $conta['numero_conta'],
        ],
        'periodo' => [
            'inicio' => $dataInicio,
            'fim' => $dataFim,
        ],
        'resumo' => [
            'saldo_inicial' => $saldoInicial,
            'total_entradas' => $totalEntradas,
            'total_saidas' => $totalSaidas,
            'rendimento_liquido' => $rendimentoLiquido,
            'saldo_final' => $saldoFinal,
        ],
        'movimentacoes' => $porDia,
        'gerado_em' => date('Y-m-d H:i:s'),
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao gerar extrato']);
}
