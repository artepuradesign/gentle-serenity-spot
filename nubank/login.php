<?php
session_start();

// Verifica se o usuário já está logado
if (isset($_SESSION['id'])) {
    // Se o usuário estiver logado, redireciona para o painel ou outra página desejada
    header("Location: painel2.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - APPCENTRAL</title>
    <link rel="stylesheet" href="estilo_comum.css">
    <?php include('icones.php'); ?>    
</head>
<body>
    <div class="container">
        <div class="content">
            <center>
                <a href="painel2.php"><img src="imagens/logo_nova.png" width="150" height="150"></a><br><br>
                <?php if (isset($_GET['erro'])): ?>
                    <div class="erro"><?php echo htmlspecialchars($_GET['erro']); ?></div>
                <?php endif; ?>
                <form method="post" action="verificar_login.php">
                    <input name="cuser" type="text" required id="cuser" placeholder="CPF" maxlength="11">
                    <input name="csenha" type="password" required id="csenha" placeholder="Senha 4 Dígitos" maxlength="4">
                    <button type="submit">Entrar →</button>
                </form>
                <p>Não possui uma conta? <a href="cadastro.php">Cadastre-se!</a></p>
            </center>
        </div>
        <div class="image"></div>
    </div>
</body>
</html>