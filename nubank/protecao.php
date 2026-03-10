<?php
session_start();
// Verifica se a sessão 'id' não está definida, ou seja, se o usuário não está logado
if (!isset($_SESSION['id'])) {
    // Redireciona para a página de login
    header("Location: login.php");
    exit(); // Garante que o script será encerrado após o redirecionamento
}
?>