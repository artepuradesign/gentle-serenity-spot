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
            header("Location: login.php?erro=" . urlencode($erro));
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>
