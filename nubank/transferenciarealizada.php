<?php
session_start();
include 'conexaoatualizada.php'; // Inclua o arquivo de conexão

if (!isset($_SESSION['id'])) {
    header("refresh:0;url=login.php");
    exit;
}
include 'transferencias.php';
?>
<?php
$valor = $_POST["valor"] ?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="imagens/icone.png" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
<title>Nubank</title>
<link rel="stylesheet" href="estilonu.css">
  <script>
  window.onload = function() {
    var valElement = document.getElementById("val");
    var a1Image = document.getElementById("a1Image");

    a1Image.addEventListener("click", function() {
      if (valElement.innerHTML === "<?php echo $saldo; ?>") {
        valElement.innerHTML = "••••";
        valElement.style.fontSize = "25px";
        valElement.style.letterSpacing = "2px"; // Adiciona espaçamento de 2 pixels entre os caracteres
      } else {
        valElement.innerHTML = "<?php echo $saldo; ?>";
        valElement.style.fontSize = "17px";
        valElement.style.letterSpacing = "normal"; // Remove o espaçamento entre os caracteres
      }
    });
  };
</script>
<script>

function changeImage(img) {
  var imagePath = img.src;
  var imageName = imagePath.substring(imagePath.lastIndexOf('/') + 1, imagePath.length);

  if (imageName === 'a1.png') {
    img.src = 'imagens/a0.png'; // Altere o caminho da imagem clicada
  } else {
    img.src = 'imagens/a1.png'; // Altere o caminho da imagem normal
  }
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

<title>Nubank</title>
<link rel="stylesheet" href="estilonu.css">

  <style type="text/css">
    body {
	text-align: center;
	margin: 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 26px;
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
	font-family: Arial, Helvetica, sans-serif;
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
  margin-right: 10px; /* Adicione um espaçamento entre as imagens */
}
  .fatura {
	font-size: 18px;
	color: #666;
	font-family: Arial, Helvetica, sans-serif;
}
.fatura2 {
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
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
	bottom: 2px; /* Ajuste o valor do espaçamento conforme necessário */
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
.imageField {
    width: 60%;
}
  .texto22 {
	font-size: 22px;
	font-family: Arial, Helvetica, sans-serif;
}
  </style>
</head>
<body>
<table width="350" border="0" align="center">
  <tr>
    <td width="347" height="50" align="center"><table width="350" border="0">
      <tr>
        <td><a href="painel2.php"><img src="imagens/x.png" alt="" width="31"></a></td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="350" border="0">
  <tr>
    
  </tr>
</table>
<table width="350" border="0" align="center">
  <tr>
    <td>
<form name="form1" method="post" action="comprovante.php">
<table width="350" border="0" align="center">
      <tr>
        <td height="180" align="left" valign="middle"><img src="imagens/transfok.png" width="156"></td>
      </tr>
      <tr>
        <td height="40" align="left" class="icon2">

          Transferencia realizada!
            
          </td>
      </tr>
      <tr>
        <td align="left">
    <span class="icon3" style="font-size: 15px; color: #666666; font-family: 'Graphik Regular'; line-height: 1.5; display: inline-block;">
    Para mais detalhes, veja o histórico de transações da sua conta.
</span>

</td>


      </tr>
      <tr>
        <td align="left" valign="bottom"><hr noshade="noshade" class="linha"></td>
      </tr>
      <tr>
        <td height="60" align="center" valign="bottom"><span class="icon2" style="color: #000; font-size: 26px;">R$ <?php echo number_format($_POST["valor"], 2, ',', '.'); ?><br>
              para
<?php echo $_POST["dnome"]; ?></span>
            </b></td>
      </tr>
      <tr>
        <td height="80" align="center" valign="middle"><span style="color: #666; font-size: 16px; "> <span class="icon3"><span class="icon3">Agora mesmo • </span></span></span><span class="icon3"><span class="icon3" style="color: #333; font-size: 16px;">
          <?php $hora_atual = date("H\hi");
echo $hora_atual;?>
        </span></span>        </td>
      </tr>
      <tr>
        <td height="80" align="center" valign="middle"><input type="image" name="imageField" id="imageField" src="imagens/enviarcomprovante.png" class="imageField" style="width: 250px;></td>
      </tr>
      <tr>
        <td height="80" align="center" valign="middle">
<div hidden="">
          <input name="data"type="text" class="informacao" id="data" value="<?php $data_atual = date("d/m/Y");
echo $data_atual; ?>">
          <br>
          <input name="hora"type="text" class="informacao" id="hora" value="<?php $hora_atual = date("H:i:s");
echo $hora_atual;
 ?>">
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
     </div></td>
      </tr>
    </table>
    </form></td>
  </tr>
</table>
</body>
</html>
