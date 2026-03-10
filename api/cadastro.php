<?php
/**
 * NU Bank Virtual - API de Cadastro
 * POST /api/cadastro.php
 */
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['tipo'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos']);
    exit();
}

try {
    $pdo = getConnection();
    $pdo->beginTransaction();

    $tipo = $data['tipo']; // PF ou PJ
    $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    $senha = password_hash($data['senha'], PASSWORD_BCRYPT);

    if (!$email) {
        throw new Exception('E-mail inválido');
    }

    // Verificar e-mail duplicado
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        throw new Exception('Este e-mail já está cadastrado. Utilize outro e-mail ou faça login.');
    }

    // PIN de 4 dígitos (obrigatório)
    $pin = $data['pin'] ?? '';
    if (!preg_match('/^\d{4}$/', $pin)) {
        throw new Exception('PIN deve ter exatamente 4 dígitos numéricos');
    }
    $pinHash = password_hash($pin, PASSWORD_BCRYPT);

    // Limitar estado a 2 caracteres (UF)
    $estado = substr($data['estado'] ?? '', 0, 2);

    // Criar usuário
    $stmt = $pdo->prepare("INSERT INTO usuarios (email, senha_hash, pin_hash, tipo_conta) VALUES (?, ?, ?, ?)");
    $stmt->execute([$email, $senha, $pinHash, $tipo]);
    $userId = $pdo->lastInsertId();

    // Dados específicos PF ou PJ
    if ($tipo === 'PF') {
        // Verificar CPF duplicado
        $stmt = $pdo->prepare("SELECT id FROM pessoas_fisicas WHERE cpf = ?");
        $stmt->execute([$data['cpf']]);
        if ($stmt->fetch()) {
            throw new Exception('Este CPF já está cadastrado.');
        }
        $stmt = $pdo->prepare("INSERT INTO pessoas_fisicas (usuario_id, nome_completo, cpf, data_nascimento, telefone) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $data['nome'], $data['cpf'], $data['dataNascimento'], $data['telefone']]);
    } else {
        // Verificar CNPJ duplicado
        $stmt = $pdo->prepare("SELECT id FROM pessoas_juridicas WHERE cnpj = ?");
        $stmt->execute([$data['cnpj']]);
        if ($stmt->fetch()) {
            throw new Exception('Este CNPJ já está cadastrado.');
        }
        $stmt = $pdo->prepare("INSERT INTO pessoas_juridicas (usuario_id, razao_social, nome_fantasia, cnpj, inscricao_estadual, telefone, responsavel_nome, responsavel_cpf, responsavel_telefone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $userId, $data['razaoSocial'], $data['nomeFantasia'] ?? null,
            $data['cnpj'], $data['inscricaoEstadual'] ?? null, $data['telefone'],
            $data['responsavelNome'], $data['responsavelCpf'], $data['responsavelTelefone']
        ]);
    }

    // Endereço
    $stmt = $pdo->prepare("INSERT INTO enderecos (usuario_id, cep, logradouro, numero, complemento, bairro, cidade, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $data['cep'], $data['endereco'], $data['numero'], $data['complemento'] ?? null, $data['bairro'], $data['cidade'], $estado]);

    // Criar conta bancária
    $numeroConta = str_pad(mt_rand(100000000, 999999999), 9, '0', STR_PAD_LEFT) . '-' . mt_rand(0, 9);
    $stmt = $pdo->prepare("INSERT INTO contas (usuario_id, numero_conta) VALUES (?, ?)");
    $stmt->execute([$userId, $numeroConta]);

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Conta criada com sucesso',
        'data' => [
            'usuario_id' => $userId,
            'agencia' => '0001',
            'conta' => $numeroConta,
        ]
    ]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
