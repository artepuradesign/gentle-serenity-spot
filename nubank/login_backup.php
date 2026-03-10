<?php
include('conexaoatualizada.php');

if (isset($_POST['cuser']) || isset($_POST['csenha'])) {
    if (strlen($_POST['cuser']) == 0) {
        $erro = "Por favor, preencha seu CPF.";
    } else if (strlen($_POST['csenha']) == 0) {
        $erro = "Por favor, preencha sua senha.";
    } else {
        $usuario = $_POST['cuser'];
        $senha = $_POST['csenha'];
        $CRITERIO = '1';

        $sql_code = "SELECT * FROM usuarios WHERE cpf = :cpf AND senha = :senha AND status = :status";
        $stmt = $pdo->prepare($sql_code);
        $stmt->bindParam(':cpf', $usuario);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':status', $CRITERIO);
        $stmt->execute();

        $quantidade = $stmt->rowCount();
        if ($quantidade == 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id_cod'];
            $_SESSION['cpf'] = $usuario['cpf'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['sobrenome'] = $usuario['sobrenome'];
            $_SESSION['instituicao'] = $usuario['instituicao'];
            $_SESSION['agencia'] = $usuario['agencia'];
            $_SESSION['conta'] = $usuario['conta'];
            $_SESSION['tipodeconta'] = $usuario['tipodeconta'];
            $_SESSION['saldo'] = $usuario['saldo'];

            header("Location: painel2.php");
            exit();
        } else {
            $erro = "CPF ou senha incorretos. Por favor, tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENTRAR</title>
    <link rel="stylesheet" href="estilo_comum.css">
<?php include('icones.php'); ?>    
</head>
<body>
    <div class="container">
        <div class="content"><center>
            <a href="painel2.php"><img src="imagens/logo_nova.png" width="150" height="150"></a><br><br>
            <?php if (isset($erro)): ?><br>
                <div class="error"><?php echo $erro; ?></div>
            <?php endif; ?></center>
            <form action="" method="POST">
                <input name="cuser" type="text" required class="input-field" placeholder="Digite seu CPF" maxlength="11">
                <input name="csenha" type="password" required class="input-field" placeholder="Senha de 4 dígitos" pattern="\d{4}" maxlength="4" inputmode="numeric">
                <button type="submit" class="submit-btn">Entrar  →</button>
            </form>
            <p>Não possui conta? <a href="cadastro.php">Cadastre-se</a></p>
        </div>
        <div class="image"></div>
    </div>
</body>
</html>
