<?php
/**
 * NU Bank Virtual - Configuração geral e CORS
 */
require_once __DIR__ . '/conexao.php';

// Função auxiliar para obter a conexão
function getConnection(): PDO {
    global $pdo;
    return $pdo;
}

// CORS headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
