<?php
/**
 * NU Bank Virtual - API Admin
 * GET  /api/admin.php?action=usuarios       - Listar todos os usuários
 * GET  /api/admin.php?action=contas          - Listar todas as contas
 * GET  /api/admin.php?action=transacoes&conta_id=X  - Transações de uma conta
 * POST /api/admin.php?action=ativar_usuario  - Ativar/bloquear usuário
 */
require_once 'config.php';

try {
    $pdo = getConnection();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro de conexão com o banco']);
    exit();
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if ($action === 'usuarios') {
        try {
            $stmt = $pdo->query("
                SELECT u.id, u.email, u.tipo_conta, u.status, u.is_admin, u.criado_em, u.ultimo_acesso,
                    COALESCE(pf.nome_completo, pj.razao_social) as nome,
                    COALESCE(pf.cpf, pj.cnpj) as documento,
                    pf.telefone as telefone_pf, pj.telefone as telefone_pj,
                    c.id as conta_id, c.numero_conta, c.agencia, c.saldo
                FROM usuarios u
                LEFT JOIN pessoas_fisicas pf ON pf.usuario_id = u.id
                LEFT JOIN pessoas_juridicas pj ON pj.usuario_id = u.id
                LEFT JOIN contas c ON c.usuario_id = u.id
                WHERE u.is_admin = 0
                ORDER BY u.criado_em DESC
            ");
            $usuarios = $stmt->fetchAll();
            echo json_encode(['usuarios' => $usuarios]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao buscar usuários: ' . $e->getMessage()]);
        }
        exit();
    }

    if ($action === 'contas') {
        try {
            $stmt = $pdo->query("
                SELECT c.*, u.tipo_conta, u.email, u.status,
                    COALESCE(pf.nome_completo, pj.razao_social) as titular,
                    COALESCE(pf.cpf, pj.cnpj) as documento
                FROM contas c
                JOIN usuarios u ON u.id = c.usuario_id
                LEFT JOIN pessoas_fisicas pf ON pf.usuario_id = u.id
                LEFT JOIN pessoas_juridicas pj ON pj.usuario_id = u.id
                WHERE u.is_admin = 0
                ORDER BY c.id DESC
            ");
            echo json_encode(['contas' => $stmt->fetchAll()]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao buscar contas: ' . $e->getMessage()]);
        }
        exit();
    }

    if ($action === 'transacoes') {
        $contaId = intval($_GET['conta_id'] ?? 0);
        $dataInicio = $_GET['data_inicio'] ?? date('Y-m-d', strtotime('-1 year'));
        $dataFim = $_GET['data_fim'] ?? date('Y-m-d');

        try {
            // Dados da conta
            $stmt = $pdo->prepare("
                SELECT c.*, u.tipo_conta,
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

            // Transações
            $stmt = $pdo->prepare("
                SELECT * FROM transacoes
                WHERE conta_id = ? AND DATE(data_transacao) BETWEEN ? AND ?
                ORDER BY data_transacao ASC
            ");
            $stmt->execute([$contaId, $dataInicio, $dataFim]);
            $transacoes = $stmt->fetchAll();

            // Saldo inicial
            $stmtSaldo = $pdo->prepare("SELECT saldo_anterior FROM transacoes WHERE conta_id = ? AND DATE(data_transacao) >= ? ORDER BY data_transacao ASC LIMIT 1");
            $stmtSaldo->execute([$contaId, $dataInicio]);
            $primeira = $stmtSaldo->fetch();
            $saldoInicial = $primeira ? floatval($primeira['saldo_anterior']) : floatval($conta['saldo']);

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
                'periodo' => ['inicio' => $dataInicio, 'fim' => $dataFim],
                'resumo' => [
                    'saldo_inicial' => $saldoInicial,
                    'total_entradas' => $totalEntradas,
                    'total_saidas' => $totalSaidas,
                    'rendimento_liquido' => $rendimentoLiquido,
                    'saldo_final' => $saldoFinal,
                ],
                'movimentacoes' => $porDia,
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao buscar transações: ' . $e->getMessage()]);
        }
        exit();
    }

    http_response_code(400);
    echo json_encode(['error' => 'Ação não reconhecida']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';

    if ($action === 'ativar_usuario') {
        try {
            $userId = intval($data['usuario_id']);
            $status = $data['status']; // 'ativo', 'bloqueado', 'pendente'
            $stmt = $pdo->prepare("UPDATE usuarios SET status = ? WHERE id = ? AND is_admin = 0");
            $stmt->execute([$status, $userId]);
            echo json_encode(['success' => true, 'message' => 'Status atualizado']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao atualizar status: ' . $e->getMessage()]);
        }
        exit();
    }

    if ($action === 'criar_transacao') {
        try {
            $pdo->beginTransaction();
            $contaId = intval($data['conta_id']);
            $tipo = $data['tipo'];
            $valor = floatval($data['valor']);

            $stmt = $pdo->prepare("SELECT saldo FROM contas WHERE id = ? FOR UPDATE");
            $stmt->execute([$contaId]);
            $conta = $stmt->fetch();
            $saldoAnterior = floatval($conta['saldo']);
            $saldoPosterior = $tipo === 'entrada' ? $saldoAnterior + $valor : $saldoAnterior - $valor;

            $stmt = $pdo->prepare("
                INSERT INTO transacoes (conta_id, tipo, categoria, descricao, valor, saldo_anterior, saldo_posterior, data_transacao,
                    beneficiario_nome, beneficiario_documento, beneficiario_banco, beneficiario_agencia, beneficiario_conta,
                    codigo_autenticacao, admin_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $contaId, $tipo, $data['categoria'], $data['descricao'], $valor,
                $saldoAnterior, $saldoPosterior, $data['data_transacao'],
                $data['beneficiario_nome'] ?? null, $data['beneficiario_documento'] ?? null,
                $data['beneficiario_banco'] ?? null, $data['beneficiario_agencia'] ?? null,
                $data['beneficiario_conta'] ?? null,
                bin2hex(random_bytes(16)), $data['admin_id'] ?? null,
            ]);

            $stmt = $pdo->prepare("UPDATE contas SET saldo = ? WHERE id = ?");
            $stmt->execute([$saldoPosterior, $contaId]);

            $pdo->commit();
            echo json_encode(['success' => true, 'saldo' => $saldoPosterior]);
        } catch (Exception $e) {
            $pdo->rollBack();
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit();
    }

    http_response_code(400);
    echo json_encode(['error' => 'Ação não reconhecida']);
}
