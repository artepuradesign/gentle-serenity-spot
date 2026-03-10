<?php
include 'msg-trans.php';
header('Content-Type: text/html; charset=UTF-8');
?>
<?php
$valor = $_POST['valor'];
// Agora você pode usar a variável $valor para realizar qualquer processamento necessário
?>
<!DOCTYPE html>
<html><head>
<link rel="stylesheet" href="estilonu.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="imagens/icone.png" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
<script>
function capturarPagina() {
  // Selecione o elemento da imagem pelo ID
  const imagemElemento = document.getElementById('imagem-compartilhar');

  // Use o html2canvas para capturar a página completa
  html2canvas(document.body).then(function(canvas) {
    // Crie um novo canvas para combinar a imagem da página e a imagem capturada
    const canvasFinal = document.createElement('canvas');
    canvasFinal.width = canvas.width;
    canvasFinal.height = canvas.height;

    // Obtenha o contexto do canvas final
    const contextoFinal = canvasFinal.getContext('2d');

    // Desenhe a imagem da página no canvas final
    contextoFinal.drawImage(canvas, 0, 0);

    // Obtenha as coordenadas da imagem selecionada
    const rect = imagemElemento.getBoundingClientRect();
    const imagemX = rect.left + window.scrollX;
    const imagemY = rect.top + window.scrollY;

    // Desenhe a imagem selecionada no canvas final
    contextoFinal.drawImage(imagemElemento, imagemX, imagemY, imagemElemento.width, imagemElemento.height);

    // Converta o canvas final em um Blob (dados binários)
    canvasFinal.toBlob(function(blob) {
      // Crie uma URL temporária para o Blob
      const url = URL.createObjectURL(blob);

      // Crie um link para download do arquivo
      const link = document.createElement('a');
      link.href = url;
      link.download = 'captura_pagina.png';

      // Clique no link para iniciar o download
      link.click();

      // Libere a URL temporária
      URL.revokeObjectURL(url);
    });
  });
}
</script>
  <script>
    function captureScreen() {
      const node = document.body;
      domtoimage.toBlob(node)
        .then(function(blob) {
          const url = URL.createObjectURL(blob);
          const link = document.createElement('a');
          link.href = url;
          link.download = 'screenshot.png';
          link.click();
          URL.revokeObjectURL(url);
        });
    }
  </script>
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
  <style type="text/css">
    body {
	text-align: center;
	margin: 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
	color: #666;
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
  margin-right: 10px; /* Adicione um espaçamento entre as imagens */
}
  .fatura {
	font-size: 17px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333;
}
.fatura15 {
	font-size: 15px;
	font-family: Arial, Helvetica, sans-serif;
	color: #666;
}
.faturax {
	font-size: 15px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333;
}
.datahora {
	font-size: 20px;
	font-family: Arial, Helvetica, sans-serif;
	color: #666;
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
	height: 2px;
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
    <td height="50" align="center"><table width="350" border="0">
      <tr>
        <td><a href="painel2.php"><img src="imagens/x.png" alt="" width="24"></a></td>
        <td align="right"><img id="imagem-compartilhar" src="imagens/compartilhar.png" width="24" onclick="capturarPagina()">
</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="350" border="0">
  <tr>
    
  </tr>
</table>
<table width="100%" border="0" align="center">
  <tr>
    <td>
<form name="form1" method="post" action="#">
<table width="350" border="0" align="center">
      <tr>
        <td height="160" colspan="2" align="left" valign="bottom"><img src="imagens/topocomprovante.png" width="259"><span style="font-size: 27px; font-family: Arial, Helvetica, sans-serif; font-weight: bold; color: #333;">
          <?php
include 'base.php';
?>
        </span></td>
      </tr>
      <tr>
        <td height="40" colspan="2" align="left" valign="middle"><span class="icon2" style="font-size: 20px; color: #333;"><?php echo $_POST["data"]; ?> - <?php echo $_POST["hora"]; ?></span></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">Valor</span></td>
        <td align="right" valign="middle">R$ <?php $valor = $_POST['valor'];
$valor_formatado = number_format($_POST['valor'], 2, ',', '.');

echo $valor_formatado; ?></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">Tipo de Transferencia</span></td>
        <td align="right" valign="middle">Pix</td>
      </tr>
      <tr>
        <td height="60" align="left" valign="bottom"><img src="imagens/destino.png" width="101"></td>
        <td align="right" valign="middle">&nbsp;</td>
      </tr>
    </table><table width="350" border="0" align="center">
      <tr>
        <td align="left" valign="middle"><hr class="linha1"></td>
      </tr>
    </table>
    </form></td>
  </tr>
  <tr>
    <td><table width="350" border="0" align="center">
      <tr>
        <td width="28%" height="30" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">Nome</span></td>
        <td width="72%" align="right" valign="middle"><?php echo $_POST["dnome"]; ?></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">CPF</span></td>
        <td height="60" align="right" valign="middle">
		<?php 
$cpfx = $_POST["dcpf"];

$parte1 = substr($cpfx, 0, 3);
$parte2 = substr($cpfx, 3, 3);
$parte3 = substr($cpfx, 6, 3);
$parte4 = substr($cpfx, 9, 2);

$cpf_formatado = $parte1 . '.' . $parte2 . '.' . $parte3 . '-' . $parte4;

echo "•••".substr($cpf_formatado, 3, -2)."••"; ?>

</td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">Instituição</span></td>
        <td height="60" align="right" valign="middle"><?php echo $_POST["dinstitu"]; ?></td>
      </tr>
      <?php if (!empty($_POST["dagencia"])): ?>
    <tr>
        <td height="60" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">Agencia</span></td>
        <td height="60" align="right" valign="middle"><?php echo $_POST["dagencia"]; ?></td>
      </tr>
	  <?php ;
      ?>
<?php endif; ?>
      
      <?php if (!empty($_POST["dconta"])): ?>
   <tr>
        <td height="60" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">Conta</span></td>
        <td height="60" align="right" valign="middle"><?php echo $_POST["dconta"]; ?></td>
      </tr>
<?php endif; ?>
      
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">Tipo de conta</span></td>
        <td height="60" align="right" valign="middle"><?php echo $_POST["dtconta"]; ?></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="bottom"><img src="imagens/origem.png" width="101"></td>
        <td align="right" valign="middle">&nbsp;</td>
      </tr>
      
    </table>
    <table width="350" border="0" align="center">
      <tr>
        <td align="left" valign="middle"><hr class="linha1"></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td><table width="350" border="0" align="center">
      <tr>
        <td height="50" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">Nome</strong></span></td>
        <td align="right" valign="middle"><?php echo $_POST["onome"]; ?></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">Instituição</span></td>
        <td height="60" align="right" valign="middle"><?php echo $_POST["oinstitu"]; ?></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">Agencia</span></td>
        <td height="60" align="right" valign="middle"><?php echo $_POST["oagencia"]; ?></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">Conta</span></td>
        <td height="60" align="right" valign="middle"><?php echo $_POST["oconta"]; ?></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon5" style="font-size: 18px; color: #000000;">CPF</span></td>
        <td height="60" align="right" valign="middle"><?php 
$cpfx = $_POST["ocpf"];

$parte1 = substr($cpfx, 0, 3);
$parte2 = substr($cpfx, 3, 3);
$parte3 = substr($cpfx, 6, 3);
$parte4 = substr($cpfx, 9, 2);

$cpf_formatado = $parte1 . '.' . $parte2 . '.' . $parte3 . '-' . $parte4;

echo "•••".substr($cpf_formatado, 3, -2)."••"; ?></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle">&nbsp;</td>
        <td height="60" align="right" valign="middle">&nbsp;</td>
      </tr>
      
    </table><table width="350" border="0" align="center">
      <tr>
        <td align="center" valign="middle" bgcolor="#EEEEEE"><img src="imagens/rodape.png" width="350"></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
