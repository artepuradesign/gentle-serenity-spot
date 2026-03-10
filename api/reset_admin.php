<?php
/**
 * Script para redefinir a senha do administrador
 * Execute uma vez e depois DELETE este arquivo do servidor por segurança
 * 
 * Acesse: https://nu.apipainel.com.br/api/reset_admin.php
 */
require_once 'config.php';

try {
    $pdo = getConnection();
    
    $novaSenha = 'admin123';
    $hash = password_hash($novaSenha, PASSWORD_BCRYPT);
    
    $stmt = $pdo->prepare("UPDATE usuarios SET senha_hash = ?, status = 'ativo' WHERE email = 'admin@nu.com' AND is_admin = 1");
    $stmt->execute([$hash]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Senha do admin atualizada para: ' . $novaSenha]);
    } else {
        // Criar admin se não existir
        $stmt = $pdo->prepare("INSERT INTO usuarios (email, senha_hash, tipo_conta, status, is_admin) VALUES ('admin@nu.com', ?, 'PF', 'ativo', 1)");
        $stmt->execute([$hash]);
        echo json_encode(['success' => true, 'message' => 'Admin criado com senha: ' . $novaSenha]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro: ' . $e->getMessage()]);
}
