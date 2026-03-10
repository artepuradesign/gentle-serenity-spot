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
$larguratabela = "98%";
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
	font-size: 15px;
	font-family: Arial, Helvetica, sans-serif;
	color: #666;
}
.faturaCopiar {
	font-size: 18px;
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
  .bolafundo {
	background-image: url(imagens/bolacinza2.png);
	background-repeat: no-repeat;
	font-family: Arial, Helvetica, sans-serif;
	background-position: center center;
	font-size: 16px;
	font-weight: normal;
}
  .informacao {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 15px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}
  </style>
</head>
<body>
<form name="form1" method="post" action="transferindo.php">
<table width="350" border="0" align="center">
  <tr>
    <td height="50" align="center"><table width="350" border="0">
      <tr>
        <td><a href="areapix.php"><img src="imagens/setay.png" alt="" width="31"></a></td>
        <td align="right"><a href="javascript:history.back()"><img src="imagens/3pontos.png" alt="" width="12"></a></td>
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
        <td height="22" colspan="2" align="left" valign="bottom"><span style="font-size: 27px; color: #333;">
          <?php
		  
 $chave = $_POST['chave'];
// Criar uma conexão com o banco de dados
$conn = new mysqli($host, $usuario, $senhadb, $banco);

// Verificar se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}



// Consulta SQL
$sql = "SELECT * FROM chaves WHERE chave = '$chave'";

// Executar a consulta
$result = $conn->query($sql);

// Verificar se a consulta retornou resultados
if ($result->num_rows > 0) {
    // Iterar sobre os resultados e exibi-los
    while ($row = $result->fetch_assoc()) {
		?>
        </span></td>
        </tr>
      <tr>
        <td width="19%" align="left" valign="bottom"><table width="70" border="0" class="bolafundo">
          <tr>
            <td height="72" align="center" valign="middle" class="icon2"><?php
$nome = $row["nome"];
$primeiraLetra = substr($nome, 0, 1);
echo $primeiraLetra;
?>
<?php
$sobrenome = $row["sobrenome"];
$palavras = explode(" ", $sobrenome);
$numeroPalavras = count($palavras);
$ultimaPalavra = $palavras[$numeroPalavras - 1];
$primeiraLetra = substr($ultimaPalavra, 0, 1);
echo $primeiraLetra;
?>
</td>
            </tr>
          </table></td>
        <td width="81%" align="left" valign="middle">
          <span class="icon2" style="font-size: 18px; color: #333;">
          <?php
        $nomecompleto = $row["nome"] ." ". $row["sobrenome"];
		$nomepix = $row["nome"];
		?>
          <?php 
		$textoFormatado = $nomecompleto;
		$textoFormatado2 = $textoFormatado;
		echo $textoFormatado2;?>
          <?php
$valor = $_POST['valor'];
// Agora você pode usar a variável $valor para realizar qualquer processamento necessário
?>
          <br>
          </span>          <span class="icon3" style="font-size: 15px; color: #666;">Transferindo </span><b><span class="icon3" style="font-size: 15px; color: #333;"> R$ <?php echo $valor; ?></span></b></span></td>
      </tr>
      <tr>
        <td align="left" valign="bottom">&nbsp;</td>
        <td align="left" valign="bottom"><span class="fatura"><b><span style="font-size: 20px; color: #333;"><span style="font-size: 27px; font-weight: bold; color: #333;">
          <?php
    }
} else {
    echo "  ";
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
</span></span></b></span>
          <script>
  function formatarValor(input) {
    var valor = input.value.replace(/\D/g, '');
    valor = (valor / 100).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    input.value = valor;
  }
          </script></td>
      </tr>
    </table>
    <div style="display: none;">
    <input name="valor"type="text" class="valorx" id="valor" placeholder="Nome, CPF/CNPJ ou chave Pix" value="<?php echo $valor ?>" size="35" maxlength="35">
    <br>
    </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    <div style="position: relative;">
    <input type="image" name="imageField" id="imageField" src="imagens/trans.png" style="position: absolute; top: 25px; left: 58px;">
  
  
    <table width="90%" border="0" align="center">
      <tr>
        <td height="22" colspan="3" align="left" valign="bottom"><span style="font-size: 27px; color: #333;">
          <?php
		  
 $chave = $_POST['chave'];

// Criar uma conexão com o banco de dados
$conn = new mysqli($host, $usuario, $senhadb, $banco);

// Verificar se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta SQL
$sql = "SELECT * FROM chaves WHERE chave = '$chave'";

// Executar a consulta
$result = $conn->query($sql);

// Verificar se a consulta retornou resultados
if ($result->num_rows > 0) {
    // Iterar sobre os resultados e exibi-los
    while ($row = $result->fetch_assoc()) {
		?>
        </span></td>
        </tr>
      <tr>
        <td width="150" rowspan="3" align="left" valign="middle"><img src="imagens/icobanco.png" width="25"></td>
            <td width="757" height="30" align="left" valign="middle"><strong class="icon3"><span class="icon3" style="font-size: 18px; color: #333;">
              <?php
            $instituicao= $row["instituicao"];
            $agencia = $row["agencia"];
            $tconta = $row["tipoconta"];
            $conta = $row["conta"];
            $tconta = $row["tipoconta"];
			$cpfpix = $row["cpf"];
                    
            ?>
              <?php 
            echo $instituicao;?>
              <?php
    $valor = $_POST['valor'];
    // Agora você pode usar a variável $valor para realizar qualquer processamento necessário
    ?>
              </span></strong></td>
        <td width="144" rowspan="3" align="left" valign="middle"><img src="imagens/setax.png" width="31"></td>
      </tr>
      <tr>
        <td align="left" valign="middle"><span class="icon3" style="font-size: 14px; color: #666; font-family: 'Graphik Regular';">Agencia <?php echo $agencia; ?> * <?php echo $tconta; ?> <?php echo $conta; ?></span></td>
        </tr>
      <tr>
        <td align="left" valign="bottom">&nbsp;</td>
        </tr>
        <tr>
          <TD>&nbsp;</TD>
        <TD>&nbsp;</TD>
        <TD>&nbsp;</TD></tr>
        <tr>
          <TD colspan="3"><table width="100%" border="0" align="center">
      <tr>
        <td height="22" colspan="3" align="left" valign="bottom">&nbsp;</td>
        </tr>
      <tr>
        <td width="140" height="37" align="left" valign="middle"><img src="imagens/icobanco.png" width="25"></td>
        <td width="721" align="left" valign="middle"><strong><span class="icon3" style="font-size: 18px; color: #333;">
          Outra instituição</span></strong></td>
        <td width="144" align="left" valign="middle"><img src="imagens/setax.png" width="31"></td>
      </tr>
      <tr>
        <td height="37" align="left" valign="middle">&nbsp;</td>
        <td align="left" valign="middle"><span class="fatura"><b><span style="font-size: 20px; color: #333;"><span style="font-size: 27px; font-weight: bold; color: #333;">
          <?php
    }
} else {
echo "<center><span class='icon2' id='mensagem' style='font-size: 26px; color: #333;'>Chave PIX Inválida!<br></span><span class='icon4' id='mensagem' style='font-size: 18px; color: #666;'>tente novamente!</span></center>";
echo "<script>
    setTimeout(function() {
        document.getElementById('mensagem').style.display = 'none'; // Oculta a mensagem após 1 segundos
        voltarPagina(); // Redireciona para a página anterior
    }, 1000);

    function voltarPagina() {
        history.go(-1); // Redireciona para a página anterior
    }
</script>";
	
}

// Fechar a conexão com o banco de dados
$conn->close();
?></span></span></b></span>
          <script>
  function formatarValor(input) {
    var valor = input.value.replace(/\D/g, '');
    valor = (valor / 100).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    input.value = valor;
  }
          </script></td>
        <td align="left" valign="middle">&nbsp;</td>
      </tr>
          </table></TD>
          </tr>
    </table>
    </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    <div hidden="">
          <p>
            <input name="chave" type="text" class="informacao" id="chave" value="<?php echo $_POST["chave"];?>">
            <br>
            <input name="data"type="text" class="informacao" id="data" value="<?php $data_atual = date("d/m/Y");
echo $data_atual; ?>">
            <br>
            <input name="hora"type="text" class="informacao" id="hora" value="<?php $hora_atual = date("H:i:s");
echo $hora_atual;
 ?>">
            <br>
  <input name="valor" type="text" class="informacao" id="valor" value="<?php echo $_POST["valor"];?>
  ">
            <br>
            <input name="dnome"type="text" class="informacao" id="dnome" value="<?php echo $nomecompleto; ?>">
            <br>
            <input name="dcpf"type="text" class="informacao" id="dcpf" value="<?php echo $cpfpix; ?>">
            <br>
            <input name="dinstitu"type="text" class="informacao" id="dinstitu" value="<?php echo $instituicao; ?>">
            <br>
            <input name="dagencia"type="text" class="informacao" id="dagencia" value="<?php echo $agencia; ?>">
            <br>
            <input name="dconta"type="text" class="informacao" id="valor6" value="<?php echo $conta; ?>">
            <br>
            <input name="dtconta"type="text" class="informacao" id="valor6" value="<?php echo $tconta; ?>">
            <br>
            <input name="onome"type="text" class="informacao" id="onome" value="<?php echo $_SESSION['nome'] ." ". $_SESSION['sobrenome']; ?>">
            <br>
            <input name="oinstitu"type="text" class="informacao" id="oinstitu" value="<?php echo $_SESSION['instituicao']; ?>">
            <br>
            <input name="oagencia"type="text" class="informacao" id="oagencia" value=<?php echo $_SESSION['agencia']; ?>>
            <br>
            <input name="oconta"type="text" class="informacao" id="valor7" value="<?php echo $_SESSION['conta']; ?>">
            <br>
            <input name="ocpf"type="text" class="informacao" id="valor8" value="<?php echo $_SESSION['cpf']; ?>">
            <br>
            <input name="valor1"type="text" class="informacao" id="valor1" value="<?php
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
    echo $saldo;

} catch(PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>">
            <br>
            <input name="valor2" type="text" class="informacao" id="valor2" value="<?php
$valor = $_POST["valor"];

// Remover ponto e substituir vírgula por ponto
$valor = str_replace('.', '', $valor);
$valor = str_replace(',', '.', $valor);

echo $valor;
?>
  ">
            <br>
      </div></td>
  </tr>
</table>
</form>
</body>
</html>
