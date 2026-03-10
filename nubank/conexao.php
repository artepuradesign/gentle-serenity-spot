<?php
$porcentagem = -95;
// dinheiro guardado (% sobre o Dinheiro)

$porcentagem2 = 0.3;
// Lucro bruto

$host = "187.77.227.205";
$usuario = "nuusuario";
$senhadb = "Acerola@2026";
$banco = "nudatabase";

// Conectar ao banco
$conexao = new mysqli($host, $usuario, $senhadb, $banco);

// Verificar conexão
if ($conexao->connect_error) {
    die('Erro ao conectar: ' . $conexao->connect_error);
}

// Charset
$conexao->set_charset("utf8mb4");

// Continue usando $conexao normalmente no sistema

// $conexao->close(); // fechar somente se precisar
?>