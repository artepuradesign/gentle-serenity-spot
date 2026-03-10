<?php

$porcentagem = -95;
// dinheiro guardado (% sobre o Dinheiro)

$porcentagem2 = 0.3;
// Lucro bruto

$host = "187.77.227.205";
$usuario = "nuusuario";
$senhadb = "Acerola@2026";
$banco = "nudatabase";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senhadb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar com o banco de dados: " . $e->getMessage());
}

?>