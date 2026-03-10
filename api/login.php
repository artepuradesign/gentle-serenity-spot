<?php
/**
 * NU Bank Virtual - API de Login
 * POST /api/login.php
 */
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

try {
    $pdo = getConnection();

    // Determinar tipo de login: CPF, CNPJ ou Email
    if (!empty($data['cpf'])) {
        $stmt = $pdo->prepare("SELECT u.id, u.email, u.senha_hash, u.pin_hash, u.tipo_conta, u.status, u.is_admin FROM usuarios u INNER JOIN pessoas_fisicas pf ON pf.usuario_id = u.id WHERE pf.cpf = ?");
        $stmt->execute([$data['cpf']]);
    } elseif (!empty($data['cnpj'])) {
        $stmt = $pdo->prepare("SELECT u.id, u.email, u.senha_hash, u.pin_hash, u.tipo_conta, u.status, u.is_admin FROM usuarios u INNER JOIN pessoas_juridicas pj ON pj.usuario_id = u.id WHERE pj.cnpj = ?");
        $stmt->execute([$data['cnpj']]);
    } elseif (!empty($data['email'])) {
        $stmt = $pdo->prepare("SELECT id, email, senha_hash, pin_hash, tipo_conta, status, is_admin FROM usuarios WHERE email = ?");
        $stmt->execute([$data['email']]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Informe CPF, CNPJ ou E-mail']);
        exit();
    }

    $user = $stmt->fetch();

    // Verificar senha OU PIN
    $senhaValida = $user && password_verify($data['senha'], $user['senha_hash']);
    $pinValido = $user && !empty($user['pin_hash']) && preg_match('/^\d{4}$/', $data['senha']) && password_verify($data['senha'], $user['pin_hash']);

    if (!$senhaValida && !$pinValido) {
        http_response_code(401);
        echo json_encode(['error' => 'Credenciais inválidas']);
        exit();
    }

    if ($user['status'] !== 'ativo' && !$user['is_admin']) {
        http_response_code(403);
        echo json_encode(['error' => 'Aguarde, seu cadastro está em Verificação.']);
        exit();
    }

    // Atualizar último acesso
    $stmt = $pdo->prepare("UPDATE usuarios SET ultimo_acesso = NOW() WHERE id = ?");
    $stmt->execute([$user['id']]);

    // Log de acesso
    $stmt = $pdo->prepare("INSERT INTO logs_acesso (usuario_id, acao, ip, user_agent) VALUES (?, 'login', ?, ?)");
    $stmt->execute([$user['id'], $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '']);

    unset($user['senha_hash']);
    unset($user['pin_hash']);
    echo json_encode(['success' => true, 'user' => $user]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro interno']);
}
