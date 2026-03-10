<?php
session_start(); // Inicia a sessão

// Verifica se o usuário já está logado
if(isset($_SESSION['id']) && isset($_SESSION['cpf'])) {
    header("Location: painel2.php"); // Redireciona para a página painel2.php
    exit();
}

include('conexao.php');

if(isset($_POST['cuser']) || isset($_POST['csenha'])) {

    if(strlen($_POST['cuser']) == 0) {
        echo "";
		    echo "<table width='100%' border='0'>";
 			echo "<tr>";
			echo "<th height='83' bgcolor='#FFFFFF' scope='col'>";
			echo "<center><br>Preencha seu CPF<center>";
			echo "<th/><tr/>";
  			echo "</table>";

		
		
    } else if(strlen($_POST['csenha']) == 0) {
        echo "<table width='100%' border='0'>";
 			echo "<tr>";
			echo "<th height='83' bgcolor='#FFFFFF' scope='col'>";
			echo "";
			echo "<center><br>Preencha sua SENHA<center>";
			echo "<th/><tr/>";
  			echo "</table>";
    } else {

        $usuario = $mysqli->real_escape_string($_POST['cuser']);
        $senha = $mysqli->real_escape_string($_POST['csenha']);
		
		$CRITERIO = 'ON';
        $sql_code = "SELECT * FROM usuarios WHERE cpf = '$usuario' AND senha = '$senha' and status = '$CRITERIO'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {
            
            $usuario = $sql_query->fetch_assoc();

            if(!isset($_SESSION)) {
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

        } else {
            echo "<table width='100%' border='0'>";
 			echo "<tr>";
			echo "<th height='83' bgcolor='#FFFFFF' scope='col'>";
			echo "";
			echo "<center><br>Falha ao logar!<br>CPF ou Senha incorretos!<center>";
				echo "<th/><tr/>";
  			echo "</table>";

        }

    }

}
?>
<!doctype html>
<html lang="en">
<head>
<title>Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<script language="javascript" type="text/javascript">
            function keyEnterPressed(e, document){
                if(e.keyCode=='13')
                {
                    document.focus();
                }
            }
        </script>
</head>
<body>
<section class="ftco-section">
<div class="container">
  <div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
<div class="login-wrap p-4 p-md-5">
<div class="icon d-flex align-items-center justify-content-center">
<span class="fa fa-user-o"></span>
</div>
<h3 class="text-center mb-4">Não tem uma conta?</h3>
<form action="" class="login-form" method="POST">
<div class="form-group">
<input name="cuser" type="text" required class="form-control rounded-left" id="cuser" placeholder="Digite seu CPF" maxlength="11">
</div>
<div class="form-group d-flex">
<input name="csenha" type="password" required class="form-control rounded-left" id="csenha" placeholder="Senha">
</div>
<div class="form-group d-md-flex">
<div class="w-50">
<label class="checkbox-wrap checkbox-primary">Lembrar
  <input type="checkbox" checked>
<span class="checkmark"></span>
</label>
</div>
<div class="w-50 text-md-right">
<a href="#">Esqueci minha senha</a>
</div>
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary rounded submit p-3 px-5">Entrar</button>
</div>
</form>
</div>
</div>
</div>
</div>
</section>
</body>
</html>