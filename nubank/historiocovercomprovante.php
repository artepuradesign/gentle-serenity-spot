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
  .bolafundo {
	background-image: url(imagens/bolacinzaok.png);
	background-repeat: no-repeat;
	font-family: Arial, Helvetica, sans-serif;
	background-position: center center;
	font-size: 16px;
	font-weight: normal;
	background-size: 60%;
}

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
    <td height="50" align="center"><?php 
		
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
      <table width="350" border="0">
      <tr>
        <td width="10%"><a href="painel2.php"><img src="imagens/x.png" alt="" width="24"></a></td>
        <td width="80%" align="center"><span class="icon3" style="font-size: 16px; color: #555;">
		
		<?php
$data_str = $row['data'];
$data_parts = explode('/', $data_str); // Divide a string em partes separadas por '/'
$data_mysql_format = $data_parts[2] . '-' . $data_parts[1] . '-' . $data_parts[0]; // Formata a data no formato "YYYY-MM-DD"
$data = date_create($data_mysql_format);

if ($data) {
    $data_formatada = $data->format('d M Y');
    echo strtoupper($data_formatada);
} else {
    echo "Erro ao converter a data.";
}
?>
 - <?php echo $row['hora']; ?></span></td>
        <td width="10%" align="center">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="350" border="0" align="center">
  <tr>
    <td><table width="350" border="0" align="center">
      <tr>
        <td align="center" valign="top"><span style="font-size: 27px; font-weight: bold; color: #333;">
        <span class="datahora"><table width="150" border="0" class="bolafundo">
            <tr>
            <td height="110" align="center" valign="middle" class="icon2" ><span style="color: #000"><?php
$nome = $row["destinonome"];
$primeiraLetra = substr($nome, 0, 1);
echo $primeiraLetra;
?>
<?php
$sobrenome = $row["destinonome"];
$palavras = explode(" ", $sobrenome);
$numeroPalavras = count($palavras);
$ultimaPalavra = $palavras[$numeroPalavras - 1];
$primeiraLetra = substr($ultimaPalavra, 0, 1);
echo $primeiraLetra;
?></span>
</td>
            </tr>
        </table></span></span></td>
      </tr>
      <tr>
        <td height="60" align="center" valign="bottom"><span class="icon2" style="font-size: 20px; color: #000; letter-spacing: 0.2px;"><?php echo $row['destinonome']; ?></span></td>
      </tr>
      <tr>
        <td height="30" align="center" valign="middle"><span class="icon4" style="font-size: 18px; color: #555"><?php echo $row['destinoinstitu']; ?></span></td>
      </tr>
      <tr>
        <td height="60" align="center" valign="middle"><span class="icon2" style="font-size: 28px; color: #000; letter-spacing: -0.5px;"><?php
$valor = $row['valor'];
$valor_formatado = 'R$ ' . number_format($valor, 2, ',', '.');
echo $valor_formatado;
?>
</span></td>
      </tr>
      <tr>
        <td height="80" align="center" valign="bottom"><a href="historiocomprovante.php?id=<?php echo $id ?>"><img src="imagens/vercomprovante.png" width="200"></a></td>
      </tr>
      <tr>
        <td height="25" align="center" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="60" align="center" valign="middle"><img src="imagens/pretextocomprovante.png" width="406"></td>
      </tr>
      <tr>
        <td height="20" align="center" valign="middle">&nbsp;</td>
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
