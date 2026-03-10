<?php
// Inicia a sessão
session_start();

// Finaliza a sessão
session_destroy();

// Redireciona para outra página
header("Location: login.php");
exit;
?>