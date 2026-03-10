<?php
/**
 * NU Bank Virtual - Conexão com o Banco de Dados MySQL
 */

$host = "187.77.227.205";
$usuario = "nuusuario";
$senhadb = "Acerola@2026";
$banco = "nudatabase";
$charset = "utf8mb4";

try {
    $dsn = "mysql:host={$host};dbname={$banco};charset={$charset}";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, $usuario, $senhadb, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao conectar com o banco de dados']);
    exit();
}
