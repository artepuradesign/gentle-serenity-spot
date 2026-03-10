<?php
session_start();
include 'conexaoatualizada.php'; // Inclua o arquivo de conexão

if (!isset($_SESSION['id'])) {
    header("refresh:0;url=login.php");
    exit;
}
?>
<?php
$id = $_GET['id'];
// Agora você pode usar a variável $valor para realizar qualquer processamento necessário
?>
<link rel="stylesheet" href="estilonu.css">
<!DOCTYPE html>
<html><head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="imagens/icone.png" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
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
	font-size: 18px;
	color: #666;
	background-color: #FFF;
    }
.texto1 {
	font-size: 16px;
	color: #666;
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
	background-image: url(03.png);
}
  .txt {
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
	color: #333;
}
.fatura15 {
	font-size: 15px;
	color: #666;
}
.faturax {
	font-size: 15px;
	color: #333;
}
.datahora {
	font-size: 20px;
	color: #666;
}
.fatura2 {
	font-size: 18px;
	color: #333;
}
  .limite {
	font-size: 13px;
	color: #797979;
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
}
  </style>
</head>
<body>
<table width="350" border="0" align="center">
  <tr>
    <td height="50" align="center"><table width="350" border="0">
      <tr>
        <td><a href="painel2.php"><img src="imagens/x.png" alt="" width="24"></a></td>
        <td align="right"><img src="imagens/compartilhar.png" width="24" onclick="captureScreen()"></td>
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
<table width="350" border="0" align="center">
      <tr>
        <td height="160" colspan="2" align="left" valign="bottom"><img src="imagens/topocomprovante.png" width="259"><span style="font-size: 27px; font-weight: bold; color: #333;"><span class="datahora"><?php 
		
		// Estabeleça a conexão com o banco de dados (substitua os valores pelas suas configurações)

$conn = new mysqli($host, $usuario, $senhadb, $banco);

// Verifique se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Prepare a consulta SQL com o parâmetro
$sql = "SELECT * FROM transferencias WHERE id_trans = ?";

// Crie uma declaração preparada
$stmt = $conn->prepare($sql);

// Vincule o valor da variável $id ao parâmetro na declaração preparada
$stmt->bind_param("i", $id);

// Execute a consulta
$stmt->execute();

// Obtenha o resultado da consulta
$result = $stmt->get_result();

// Faça algo com os dados obtidos
while ($row = $result->fetch_assoc()) {
    // Acesse os valores das colunas
    $id_trans = $row['id_trans'];
	?>
        </span></span></td>
      </tr>
      <tr>
        <td height="40" colspan="2" align="left" valign="middle"><span class="icon3" style="font-size: 20px; color: #333;"><?php echo $row['data']; ?> - <?php echo $row['hora']; ?></span></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">Valor</span></td>
        <td align="right" valign="middle"><span class="icon3" style="font-size: 16px; color: #666">R$ 
		<?php $valor = $row['valor'];
$valor_formatado = number_format($valor, 2, ',', '.');

echo $valor_formatado; ?></span></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">Tipo de Transferencia</span></td>
        <td align="right" valign="middle"><span class="icon3" style="font-size: 16px; color: #666"><?php echo $row['tipodetransf']; ?></span></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="bottom"><img src="imagens/destino.png" width="101"></td>
        <td align="right" valign="middle">&nbsp;</td>
      </tr>
    </table><table width="100%" border="0" align="center">
      <tr>
        <td align="left" valign="middle"><hr class="linha1"></td>
      </tr>
    </table>
   </td>
  </tr>
  <tr>
    <td><table width="350" border="0" align="center">
      <tr>
        <td width="20%" height="30" align="left" valign="middle"><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">Nome</span></td>
        <td width="80%" align="right" valign="middle"><span class="icon3" style="font-size: 16px; color: #868686"><?php echo $row['destinonome']; ?></span></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">CPF</span></td>
        <td height="60" align="right" valign="middle">
		<span class="icon3" style="font-size: 16px; color: #868686">
		<?php 
$cpfx = $row['destinocpf'];

$parte1 = substr($cpfx, 0, 3);
$parte2 = substr($cpfx, 3, 3);
$parte3 = substr($cpfx, 6, 3);
$parte4 = substr($cpfx, 9, 2);

$cpf_formatado = $parte1 . '.' . $parte2 . '.' . $parte3 . '-' . $parte4;

echo "•••".substr($cpf_formatado, 3, -2)."••"; ?>
</span>
</td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">Instituição</span></td>
        <td height="60" align="right" valign="middle"><span class="icon3" style="font-size: 16px; color: #868686"><?php echo $row['destinoinstitu']; ?></span></td>
      </tr>
      <?php if (!empty($row['destinoagencia'])): ?>
    <tr>
        <td height="60" align="left" valign="middle"><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">Agencia</span></td>
        <td height="60" align="right" valign="middle"><span class="icon3" style="font-size: 16px; color: #868686"><?php echo $row['destinoagencia']; ?></span></td>
      </tr>
	  <?php ;
      ?>
<?php endif; ?>
      
      <?php if (!empty($row['destinoconta'])): ?>
   <tr>
        <td height="60" align="left" valign="middle"><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">Conta</span></td>
        <td height="60" align="right" valign="middle"><span class="icon3" style="font-size: 16px; color: #868686"><?php echo $row['destinoconta']; ?></span></td>
      </tr>
<?php endif; ?>
      
      <tr>
        <td height="60" align="left" valign="middle"><p><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">Tipo de conta</span></p></td>
        <td height="60" align="right" valign="middle"><span class="icon3" style="font-size: 16px; color: #868686"><?php echo $row['dtconta']; ?></span></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="bottom"><img src="imagens/origem.png" width="101"></td>
        <td align="right" valign="middle">&nbsp;</td>
      </tr>
      
    </table>
    <table width="100%" border="0" align="center">
      <tr>
        <td align="left" valign="middle"><hr class="linha1"></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td><table width="350" border="0" align="center">
      <tr>
        <td width="20%" height="30" align="left" valign="middle"><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">Nome</span></td>
        <td width="82%" align="right" valign="top"><span class="icon3" style="font-size: 16px; color: #868686"><?php echo $row['orinome']; ?></span></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">Instituição</span></td>
        <td height="60" align="right" valign="middle"><span class="icon3" style="font-size: 16px; color: #868686"><?php echo $row['oriinstituicao']; ?></span></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">Agencia</span></td>
        <td height="60" align="right" valign="middle"><span class="icon3" style="font-size: 16px; color: #868686"><?php echo $row['oriagencia']; ?></span></td>
      </tr>
      <tr>
        <td height="60" align="left" valign="middle"><span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">Conta</span></td>
        <td height="60" align="right" valign="middle"><span class="icon3" style="font-size: 16px; color: #868686"><?php echo $row['oriconta']; ?></span></td>
      </tr>
      <tr>
    <td height="60" align="left" valign="middle">
        <span class="icon2" style="font-size: 16px; color: #000; letter-spacing: 0.2px;">
            <?php 
            $cpfx = $row['oricpf'];

            // Verifica se é CPF ou CNPJ
            if (strlen($cpfx) > 11) {
                // É um CNPJ
                echo 'CNPJ';
            } else {
                // É um CPF
                echo 'CPF';
            }
            ?>
        </span>
    </td>
    <td height="60" align="right" valign="middle">
        <span class="icon3" style="font-size: 16px; color: #868686">
            <?php 
            if (strlen($cpfx) > 11) {
                // Formata como CNPJ
                $parte1 = substr($cpfx, 0, 2);
                $parte2 = substr($cpfx, 2, 3);
                $parte3 = substr($cpfx, 5, 3);
                $parte4 = substr($cpfx, 8, 4);
                $parte5 = substr($cpfx, 12, 2);

                $cnpj_formatado = $parte1 . '.' . $parte2 . '.' . $parte3 . '/' . $parte4 . '-' . $parte5;

                echo "•••" . substr($cnpj_formatado, 3, -2) . "••";
            } else {
                // Formata como CPF
                $parte1 = substr($cpfx, 0, 3);
                $parte2 = substr($cpfx, 3, 3);
                $parte3 = substr($cpfx, 6, 3);
                $parte4 = substr($cpfx, 9, 2);

                $cpf_formatado = $parte1 . '.' . $parte2 . '.' . $parte3 . '-' . $parte4;

                echo "•••" . substr($cpf_formatado, 3, -2) . "••";
            }
            ?>
        </span>
    </td>
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
<?php
}

$stmt->close();
$conn->close();		
		 ?>
</body>
</html>
