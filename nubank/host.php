<?php
$plataforma = 'ONLINE';

if ($plataforma === 'OFFLINE') {
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "if0_35423555_plataformas";

} elseif ($plataforma === 'ONLINE') {
$host = "mysql.db4.net2.com.br";
$usuario = "svrsrs";
$senha = "Maria2020";
$banco = "svrsrs2"; 

} else {
  die("Status de plataforma desconhecido.");
}
// Conectar ao banco de dados usando as configuraÃ§Ãµes determinadas acima

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
  die("Falha na conexão: " . $conexao->connect_error);
}
$conexao->set_charset("utf8mb4");

?>