<?php
$plataforma = 'ONLINE'; // Altere para 'OFFLINE' se estiver trabalhando localmente

if ($plataforma === 'OFFLINE') {
    $host = "localhost";
    $usuario = "root";
    $senhadb = "";
    $banco = "plataforma_nubank"; // Nome do banco de dados offline

} elseif ($plataforma === 'ONLINE') {
    $host = "mysql.db5.net2.com.br";
    $usuario = "svrsrs3";
    $senhadb = "Maria2020";
    $banco = "svrsrs3"; // Nome do banco de dados online

} else {
    die("Status de plataforma desconhecido.");
}

// Tentar conectar ao banco de dados usando as configurações determinadas acima
$conexao = new mysqli($host, $usuario, $senhadb, $banco);

// Verificar a conexão
if ($conexao->connect_error) {
    die('Could not connect: ' . $conexao->connect_error);
} else {
    echo "Conectado ao banco de dados: $banco<br>";
}

$conexao->set_charset("utf8mb4");

// Você pode continuar o código aqui, usando a variável $conexao para interagir com o banco de dados

// Fechar a conexão ao final
$conexao->close();
?>
