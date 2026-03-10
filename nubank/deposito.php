<?php
ob_start();
include('conexaoatualizada.php');
include('../protecao.php');
include('../verificacao_transferencias.php');
ob_end_clean();
?>
<div id="mensagem-transferencia" class="mensagem-transferencia" style="display:none; text-align:center;"></div>
<audio id="audio-transferencia" src="som.mp3" type="audio/mpeg"></audio>

<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/modelo1.dwt.php" codeOutsideHTMLIsLocked="false" --><head>
<link rel="stylesheet" href="estilo_nubank.css">
<style>
  .image-container {
    white-space: nowrap; /* Manter os ícones em uma linha */
    overflow-x: hidden;  /* O conteúdo ainda será rolável */
    cursor: grab;        /* Mudar o cursor para indicar arrastável */
    scrollbar-width: none; /* Ocultar a barra de rolagem no Firefox */
  }

  /* Ocultar a barra de rolagem no Chrome, Safari e Edge */
  .image-container::-webkit-scrollbar {
    display: none;
  }

  /* Cursor ao arrastar */
  .image-container:active {
    cursor: grabbing;
  }
.linha {
    height: 1px;
    background-color: #ccc; /* Define a cor da linha */
    margin: 20px 0; /* Espaçamento */
    width: 80%; /* Ocupa a largura completa */
}  

.largura_padrao {
    width: 720px; /* Largura padrão para telas maiores */
}

/* Estilos para dispositivos com largura máxima de 768px (tablets e smartphones) */
@media (max-width: 768px) {
    .largura_padrao {
        width: 90%; /* Ajusta para ocupar toda a largura da tela */
    }
}
</style>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Nubank</title>
<!-- InstanceEndEditable -->
<?php include('icones.php'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Remova a barra de navegação e o botão "Abrir" no Safari no iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Defina a cor da barra de status no Safari no iOS -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="stylesheet" href="estilo_nubank.css">
<style type="text/css">
.image-container1 {    white-space: nowrap; /* Manter os ícones em uma linha */
    overflow-x: hidden;  /* O conteúdo ainda será rolável */
    cursor: grab;        /* Mudar o cursor para indicar arrastável */
    scrollbar-width: none; /* Ocultar a barra de rolagem no Firefox */
}
</style>
</head>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<body>
<table width="100%" border="0" class="topo">
<tr>
<td height="100%" align="center"><br>
<table class="largura_padrao" border="0" align="center">
<tr>
<td><a href="painel2.php"><img src="imagens/00.png" alt="" width="56"></a></td>
<td align="right"><img src="imagens/a1.png" alt="" name="a1Image" width="52" id="a1Image" onclick="changeImage(this)">
<img id="enable-sound" src="imagens/somdesativado.fw.png" alt="Ativar Som" width="52">
<a href="#" onclick="confirmLogout();"><img src="imagens/a3.png" width="52"></a>
</td>
</tr>
</table></td>
</tr>
<tr>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cpfusuario = !empty($_SESSION['cpf']) ? $_SESSION['cpf'] : '000.000.000-00';
$con = mysqli_connect($host, $usuario, $senhadb) or die(mysqli_error($con));
$bd = mysqli_select_db($con, $banco) or die(mysqli_error($con));

$sql = "SELECT * FROM usuarios WHERE cpf = '$cpfusuario'";
$res = mysqli_query($con, $sql);
$lin = mysqli_num_rows($res);

if ($lin > 0) {
    while ($reg = mysqli_fetch_assoc($res)) {
        $cpf = $reg['cpf'];
        $nome = $reg['nome'];
        $sobrenome = $reg['sobrenome'];
        $instituicao = $reg['instituicao'];
        $agencia = $reg['agencia'];
        $conta = $reg['conta'];
        $tipodeconta = $reg['tipodeconta'];
        $saldo = $reg['saldo'];
    }
} else {
    echo "";
}

mysqli_close($con);
?>
<td height="50" align="center" valign="top">
<table class="largura_padrao" border="0" align="center">
<tr>
<td class="topotexto">Olá <?php
$nomeExibido = empty($nome) ? 'Visitante' : ucwords(strtolower($nome));
echo $nomeExibido;
?>
</td>
</tr>
</table></td>
</tr>
</table><br>
<table class="largura_padrao" align="center">
  <tr valign="bottom">
    <td height="126" style="font-size: 20px;">
      <div class="image-container" id="draggable-container">
        <a href="areapix.php"><img src="imagens/areapix.png" alt="50" width="75" height="240"></a>
        <a href="deposito.php"><img src="imagens/bt_depositar.png" width="75" height="240"></a>
        <a href="indique.php"><img src="imagens/bt_indique.fw.png" width="75" height="240"></a><a href="downloads.php"><img src="imagens/download.fw.png" width="75" height="240"></a><a href="https://t.me/nubankqr" target="_blank"><img src="imagens/bt_telegram.fw.png" width="75" height="240"></a><span class="image-container1"><a href="cadastro_qr.php"><img src="imagens/bt_qrcode.fw.png" width="75" height="240"></a></span><a href="pagina_perguntas.php"><img src="imagens/suporte.fw.png" width="75" height="240"></a><img src="imagens/bt_ajustes.fw.png" width="75" height="240">&nbsp;&nbsp;&nbsp;
      </div>
    </td>
  </tr>
</table>
<table class="largura_padrao" border="0" align="center" valign="top">
  <tr>
  <td height="42" valign="top"><!-- InstanceBeginEditable name="conteudo" -->    <div class="container">
    <form action="depositar.php" method="POST" >
      
  <table width="100%" border="0">
  <tr>
    <th align="left" valign="top" scope="col">
     <p>
       <style>
        /* Estilos globais */

        /* Container do formulário */
        form {
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
            box-sizing: border-box;
        }

        /* Títulos dos campos (ocultos) */

        /* Campos de entrada */
        form input[type="text"],
        form input[type="number"],
        form input[type="password"],
        form input[type="email"],
        form select {
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            border-radius: 10px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 18px;
            transition: border-color 0.3s;
            background-color: #f0f0f5;
        }

        /* Placeholder estilo Apple */
        form input::placeholder,
        form select {
            color: #8e8e93;
            opacity: 1; /* Para navegadores mais antigos */
        }

        /* Efeito ao focar */
        form input:focus,
        form select:focus {
            border-color: #007bff;
            outline: none;
            background-color: #e5e5ea;
        }

        /* Botão de envio */
        form button[type="submit"] {
            background-color: #007aff;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            font-size: 18px;
        }

        /* Efeito de hover no botão */
        form button[type="submit"]:hover {
            background-color: #005eb8;
        }

        /* Estilo para o select */
        form select {
            appearance: none;
            background-color: #f0f0f5;
            border: 1px solid #ccc;
            padding-right: 10px;
        }

        /* Personalizando seta do select */
        form select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="none" stroke="%23333" stroke-width=".75" d="M1 0l2 2-2 2"/></svg>');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 8px 10px;
        }

        /* Media queries para responsividade */
        @media (max-width: 600px) {
            form {
                padding: 20px;
            }

            form input,
            form button {
                font-size: 16px;
                padding: 12px;
            }
        }
     </style>
       <label for="cliente_id" readonly style="display: none;">ID do Cliente:</label>
       <input type="text" name="cliente_id" id="cliente_id" value="<?php echo $_SESSION['id']; ?>" readonly style="display: none;">
       <label for="valor">Valor do Depósito:</label>
       <input type="number" name="valor" id="valor" step="0.01" size="5" required>
       <label for="destinonome" readonly style="display: none;">Nome do Destinatário:</label>
       <input name="destinonome" type="text" readonly style="display: none;" required id="destinonome" value="<?php echo $_SESSION['nome']; ?> <?php echo $_SESSION['sobrenome']; ?>">
       <label for="destinocpf" readonly style="display: none;">CPF do Destinatário:</label>
       <input name="destinocpf" type="text" required id="destinocpf" readonly style="display: none;" value="<?php echo $_SESSION['cpf']; ?>">
       <label for="destinoinstitu" readonly style="display: none;">Instituição do Destinatário:</label>
       <input name="destinoinstitu" type="text" required id="destinoinstitu" readonly style="display: none;" value="NU PAGAMENTOS - IP">
       <label for="destinoagencia" readonly style="display: none;">Agência do Destinatário:</label>
       <input name="destinoagencia" type="text" required id="destinoagencia" readonly style="display: none;" value="0001">
       <label for="destinoconta" readonly style="display: none;">Conta do Destinatário:</label>
       <input name="destinoconta" type="text" required id="destinoconta" value="<?php echo $_SESSION['conta']; ?>" readonly style="display: none;">
       <label for="orinome"> <br>
         Remetente: </label>
       <input name="orinome" type="text" required id="orinome" value="Okto Pagamentos S.A.">
       <label for="oriinstituicao"> <br>
         Banco - Instituição da Origem:  </label>
       <select name="oriinstituicao" class="selecionados" id="oriinstituicao">
         <option selected="selected">Bancos</option>
         <option value="Banco do Brasil">Banco do Brasil</option>
         <option value="BCO BRASIL">Banco do Brasil</option>
         <option value="ITAU">Itaú Unibanco</option>
         <option value="BRADESCO">Bradesco</option>
         <option value="CAIXA">Caixa Econômica Federal</option>
         <option value="SANTANDER">Santander Brasil</option>
         <option value="BTG PACTUAL">BTG Pactual</option>
         <option value="BANCO ORIGINAL">Banco Original</option>
         <option value="BANRISUL">Banrisul</option>
         <option value="SICOOB">Sicoob</option>
         <option value="BANCO INTER">Banco Inter</option>
         <option value="NUBANK">Nubank</option>
         <option value="Safra">Banco Safra</option>
         <option value="BANCO DO NORDESTE">Banco do Nordeste</option>
         <option value="C6 BANK">C6 Bank</option>
         <option value="BANCO PAN">Banco Pan</option>
         <option value="BCO BMG">Banco BMG</option>
         <option value="PAGSEGURO INTERQNET IP S.A">PagSeguro</option>
         <option value="BANCO SANTANDER BRASIL">Banco Santander Brasil</option>
         <option value="BANCO VOTORANTIM">Banco Votorantim</option>
         <option value="BANCO DAYCOVAL">Banco Daycoval</option>
         <option value="BANCO CREDIT SUISSE">Banco Credit Suisse</option>
         <option value="BANCO SANTOS">Banco Santos</option>
         <option value="BANCO ALFA">Banco Alfa</option>
         <option value="BANCO ABC BRASIL">Banco ABC Brasil</option>
         <option value="BANCO PANAMERICANO">Banco Panamericano</option>
         <option value="BANCO INDUSVAL">Banco Indusval</option>
         <option value="BANCO RURAL">Banco Rural</option>
         <option value="BANCO CCB BRASIL">Banco CCB Brasil</option>
         <option value="BANCO TRICURY">Banco Tricury</option>
         <option value="BANCO CARREFOUR">Banco Carrefour</option>
         <option value="BANCO SEMEAR">Banco Semear</option>
         <option value="CITIBANK">Citibank Brasil</option>
         <option value="BANCO PINE">Banco Pine</option>
         <option value="BANCO FIBRA">Banco Fibra</option>
         <option value="BANCO SOFISA">Banco Sofisa</option>
         <option value="BANCO VOLKSWAGEN">Banco Volkswagen</option>
         <option value="BANCO BONSUCESSO">Banco Bonsucesso</option>
         <option value="BANCO PAULISTA">Banco Paulista</option>
         <option value="BANCO NEON">Banco Neon</option>
         <option value="BANCO J. SAFRA">Banco J. Safra</option>
         <option value="BANCO MODAL">Banco Modal</option>
         <option value="BANCO MATONE">Banco Matone</option>
         <option value="BANCO SAFRA PESSOAL">Banco Safra Pessoal</option>
         <option value="BANCO A.J. RENNER">Banco A.J. Renner</option>
         <option value="BANCO TOPÁZIO">Banco Topázio</option>
         <option value="BANCO ARBI">Banco Arbi</option>
         <option value="BANCO FINASA">Banco Finasa</option>
         <option value="BANCO PROSPER">Banco Prosper</option>
         <option value="BANCO DA AMAZÔNIA">Banco da Amazônia</option>
         <option value="BANCO FIBRA">Banco Fibra</option>
         <option value="BANCO FICSA">Banco Ficsa</option>
         <option value="BANCO 3M">Banco 3M</option>
         <option value="BANCO AGIBANK">Banco Agibank</option>
         <option value="BANCO ALVORADA">Banco Alvorada</option>
         <option value="BANCO ATIVA">Banco Ativa</option>
         <option value="BANCO AZTECA">Banco Azteca</option>
         <option value="BANCO BAI EUROPA">Banco BAI Europa</option>
         <option value="BANCO BANERJ">Banco Banerj</option>
         <option value="BANCO BARIGUI">Banco Barigui</option>
         <option value="BANCO BARI">Banco Bari</option>
         <option value="BANCO BASE">Banco Base</option>
         <option value="BANCO BBM">Banco BBM</option>
         <option value="BANCO BCO">Banco BCO</option>
         <option value="BANCO BDA">Banco BDA</option>
         <option value="BANCO BMJ">Banco BMJ</option>
         <option value="BANCO BONSUCESSO CONSIGNADO">Banco Bonsucesso Consignado</option>
         <option value="BANCO BOREAL">Banco Boreal</option>
         <option value="BANCO BRASCAN">Banco Brascan</option>
         <option value="BANCO BS2">Banco BS2</option>
         <option value="BANCO BTG PACTUAL DIGITAL">Banco BTG Pactual Digital</option>
         <option value="BANCO BVA">Banco BVA</option>
         <option value="BANCO BVA CONSIGNADO">Banco BVA Consignado</option>
         <option value="BANCO CACIQUE">Banco Cacique</option>
         <option value="BANCO CACIQUE CONSIGNADO">Banco Cacique Consignado</option>
         <option value="BANCO CAIXA GERAL BRASIL">Banco Caixa Geral Brasil</option>
         <option value="BANCO CARGILL">Banco Cargill</option>
         <option value="BANCO CIFRA">Banco Cifra</option>
         <option value="BANCO CITIBANK">Banco Citibank</option>
         <option value="BANCO CONFIDENCE">Banco Confidence</option>
         <option value="BANCO COOP">Banco Coop</option>
         <option value="BANCO CSF">Banco CSF</option>
         <option value="BANCO CÉDULA">Banco Cédula</option>
         <option value="BANCO DAIMLER">Banco Daimler</option>
         <option value="BANCO DIGIMAIS">Banco Digimais</option>
         <option value="BANCO DME">Banco DME</option>
         <option value="BANCO DO VALE">Banco do Vale</option>
         <option value="BANCO DUCTOR">Banco Ductor</option>
         <option value="BANCO FATOR">Banco Fator</option>
         <option value="BANCO FIDIS">Banco Fidis</option>
         <option value="BANCO FORD">Banco Ford</option>
         <option value="BANCO GMAC">Banco GMAC</option>
         <option value="BANCO GUANABARA">Banco Guanabara</option>
         <option value="BANCO HONDA">Banco Honda</option>
         <option value="BANCO HYUNDAI">Banco Hyundai</option>
         <option value="BANCO INDUSTRIAL">Banco Industrial</option>
         <option value="BANCO INTERCAP">Banco Intercap</option>
         <option value="BANCO INTERMEDIUM">Banco Intermedium</option>
         <option value="BANCO ITAÚ BBA">Banco Itaú BBA</option>
         <option value="BANCO ITAÚ BANK">Banco Itaú Bank</option>
         <option value="BANCO ITAÚ CONSIGNADO">Banco Itaú Consignado</option>
         <option value="BANCO ITAÚ VEÍCULOS">Banco Itaú Veículos</option>
         <option value="BANCO ORIGINAL">Banco Original</option>
         <option value="BANCO PAN">Banco Pan</option>
         <option value="BANCO PANAMERICANO">Banco Panamericano</option>
         <option value="BANCO PARMER">Banco Parmer</option>
         <option value="BANCO PAULISTA">Banco Paulista</option>
         <option value="BANCO PEUGEOT">Banco Peugeot</option>
         <option value="BANCO PHOENIX">Banco Phoenix</option>
         <option value="BANCO PINHEIRO">Banco Pinheiro</option>
         <option value="BANCO PINE">Banco Pine</option>
         <option value="BANCO PLURAL">Banco Plural</option>
         <option value="BANCO POLIBANK">Banco Polibank</option>
         <option value="BANCO PORTO SEGURO">Banco Porto Seguro</option>
         <option value="BANCO POTTENCIAL">Banco Pottencial</option>
         <option value="BANCO PSA FINANCE">Banco PSA Finance</option>
         <option value="BANCO RCI BRASIL">Banco RCI Brasil</option>
         <option value="BANCO RENDIMENTO">Banco Rendimento</option>
         <option value="BANCO RIO">Banco Rio</option>
         <option value="BANCO RIO GRANDE">Banco Rio Grande</option>
         <option value="BANCO RODOBENS">Banco Rodobens</option>
         <option value="BANCO RURAL">Banco Rural</option>
         <option value="BANCO SABEMI">Banco Sabemi</option>
         <option value="BANCO SAFRA">Banco Safra</option>
         <option value="BANCO SANTANDER">Banco Santander</option>
         <option value="BANCO SEMEAR">Banco Semear</option>
         <option value="BANCO SICREDI">Banco Sicredi</option>
         <option value="BANCO SIMPLES">Banco Simples</option>
         <option value="BANCO SOFISA">Banco Sofisa</option>
         <option value="BANCO SOCINAL">Banco Socinal</option>
         <option value="BANCO SOFITASA">Banco Sofitasa</option>
         <option value="BANCO TABOÃO">Banco Taboão</option>
         <option value="BANCO TECNICRED">Banco Tecnicred</option>
         <option value="BANCO TOYOTA">Banco Toyota</option>
         <option value="BANCO TRICURY">Banco Tricury</option>
         <option value="BANCO TRIANGULO">Banco Triângulo</option>
         <option value="BANCO UBS">Banco UBS</option>
         <option value="BANCO UBS BRASIL">Banco UBS Brasil</option>
         <option value="BANCO UNICRED">Banco Unicred</option>
         <option value="BANCO UNICRED CONSIGNADO">Banco Unicred Consignado</option>
         <option value="BANCO UNICRED VEÍCULOS">Banco Unicred Veículos</option>
         <option value="BANCO UNICRED NORTE DO PARANÁ">Banco Unicred Norte do Paraná</option>
         <option value="BANCO UNICRED RS">Banco Unicred RS</option>
         <option value="BANCO UNIPRIME">Banco Uniprime</option>
         <option value="BANCO UNITED">Banco United</option>
         <option value="BANCO UNIVERSAL">Banco Universal</option>
         <option value="BANCO V MOTOR">Banco V Motor</option>
         <option value="BANCO VIPS">Banco Vips</option>
         <option value="BANCO VOLKSWAGEN">Banco Volkswagen</option>
         <option value="BANCO VR">Banco VR</option>
         <option value="BANCO WEEL">Banco Weel</option>
         <option value="BANCO WIDE">Banco Wide</option>
         <option value="BANCO WINBANK">Banco Winbank</option>
         <option value="BANCO YAMAHA">Banco Yamaha</option>
         <option value="BANCO YAMAHA VEÍCULOS">Banco Yamaha Veículos</option>
         <option value="BANCO YAMAHA WOORI">Banco Yamaha Woori</option>
         <option value="BANCO YARA">Banco Yara</option>
         <option value="BANCO YUHO">Banco Yuho</option>
         <option value="BANCO ZEMA">Banco Zema</option>
         <option value="BANCO ZOGBI">Banco Zogbi</option>
         <option value="BANCO AME DIGITAL">Banco AME</option>
       </select>
       <a href="cadastro_bancos.php" style="font-family:Verdana, Geneva, sans-serif; font-size:14px">Cadastrar Instituição, clique aqui</a>
        <label for="oriagencia"><br>
         <br>
         <br>
         Agência da Origem:</label>
       <input name="oriagencia" type="text" required id="oriagencia" value="0001">
       <br>
       <br>
       <label for="oriagencia">Conta da Origem:</label>
       <input name="conta" type="text" required id="oriagencia">
       <br>
       <br>
       <label for="oriconta" readonly style="display: none;">Conta da Origem:</label>
       <input name="oriconta" type="text" required id="oriconta" readonly style="display: none;" value="142536">
       <label for="oricpf"> CPF / CNPJ Remetente:</label>
       <input type="text" name="oricpf" id="oricpf" value="<?php echo $_SESSION['cpf']; ?>">
       <label for="oricpf" readonly style="display: none;">Data:</label>
       <input type="text" name="data" id="data" value="<?php $data_atual = date("d/m/Y");
echo $data_atual; ?>" readonly style="display: none;">
       <label for="oricpf" readonly style="display: none;">Hora:</label>
       <input type="text" name="hora" id="hora" value="<?php $hora_atual = date("H:i:s");
echo $hora_atual;
 ?>" readonly style="display: none;">
       <br>
       <br>
       <label for="modelo">Tipo de Transferência:</label>
       <label for="modelo"></label>
       <select name="tipotransferencia" class="selecionados" id="tipotransferencia">
         <option value="deposito">deposito</option>
         <option value="recebida">recebida</option>
       </select>
       <br>
       <br>
       <label for="modelo">Transferência enviada por:</label>
       <br>
       <br>
       <input name="modelo" type="radio" id="modelo" value="PIX" checked>
       PIX <br>
       <br>
       <input type="radio" name="modelo" id="modelo2" value="TED">
       TED<br>
       <br>
     </p>
<button type="submit">Depositar</button>
  </tr>
</table>
    </form></div><!-- InstanceEndEditable --></td>
</tr>
</table><br>
<script>
  const container = document.getElementById('draggable-container');
  let isDown = false;
  let startX;
  let scrollLeft;

  container.addEventListener('mousedown', (e) => {
    isDown = true;
    container.classList.add('active');
    startX = e.pageX - container.offsetLeft;
    scrollLeft = container.scrollLeft;
  });

  container.addEventListener('mouseleave', () => {
    isDown = false;
    container.classList.remove('active');
  });

  container.addEventListener('mouseup', () => {
    isDown = false;
    container.classList.remove('active');
  });

  container.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - container.offsetLeft;
    const walk = (x - startX) * 2; // Velocidade de arraste
    container.scrollLeft = scrollLeft - walk;
  });
</script>
<script>
function confirmLogout() {
    if (confirm("Tem certeza de que deseja sair?")) {
        window.location.href = "logout.php";
    }
}

window.onload = function() {
var valElement = document.getElementById("val");
var a1Image = document.getElementById("a1Image");

a1Image.addEventListener("click", function() {
if (valElement.innerHTML === "R$ <?php echo number_format($saldo, 2, ',', '.'); ?>") {
valElement.innerHTML = "••••";
valElement.style.fontSize = "25px";
valElement.style.letterSpacing = "2px"; // Adiciona espaçamento de 2 pixels entre os caracteres
} else {
valElement.innerHTML = "R$ <?php echo number_format($saldo, 2, ',', '.'); ?>";
valElement.style.fontSize = "17px";
valElement.style.letterSpacing = "normal"; // Remove o espaçamento entre os caracteres
}
});
};

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Verificar se o som já foi habilitado
    if (!localStorage.getItem('soundEnabled')) {
        // Mostra o botão para ativar o som se ainda não estiver habilitado
        $('#enable-sound').show();

        // Tentar tocar o áudio após 2 segundos
        setTimeout(function() {
            const audio = document.getElementById('audio-transferencia');
            audio.play().then(() => {
                audio.pause(); // Pausa imediatamente após tocar para autorizar
                audio.currentTime = 0; // Reseta o áudio para o início
                localStorage.setItem('soundEnabled', true);
                $('#enable-sound').hide(); // Esconde o botão após a autorização
            }).catch(error => {
                console.error('Erro ao tentar ativar o áudio:', error);
            });
        }, 2000); // 2000 milissegundos = 2 segundos
    }

// Ativar som ao clicar no botão
$('#enable-sound').on('click', function() {
    const audio = document.getElementById('audio-transferencia');

    // Verifica se o som já está ativado
    if (localStorage.getItem('soundEnabled') === 'true') {
        // Desativa o som
        audio.pause(); // Pausa o áudio
        audio.currentTime = 0; // Reseta o áudio para o início
        localStorage.removeItem('soundEnabled');
        $(this).attr('src', 'imagens/somdesativado.fw.png'); // Atualiza o ícone para o estado desativado
        $(this).removeClass('active').addClass('inactive'); // Atualiza a classe CSS
    } else {
        // Ativa o som
        audio.play().then(() => {
            audio.pause(); // Pausa imediatamente após tocar para autorizar
            audio.currentTime = 0; // Reseta o áudio para o início
            localStorage.setItem('soundEnabled', true);
            $(this).attr('src', 'imagens/somativado.fw.png'); // Atualiza o ícone para o estado ativado
            $(this).removeClass('inactive').addClass('active'); // Atualiza a classe CSS
        }).catch(error => {
            console.error('Erro ao tentar ativar o áudio:', error);
        });
    }
});

    function exibirTabelaTransferencia(remetente, valorTransferencia, ids) {
        var valorFormatado = parseFloat(valorTransferencia).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        var tabelaTransferencia = `
            <br><table class="rounded-table" width="350 px" border="0" align="center">
                <tr>
                   <td align="center"><img src="icone.png" width="30" height="30" style="border-radius: 20%;" /></td>
                   <td width="85%"><b>Transferência recebida</b> <br />
                    Você recebeu uma transferência de ${valorFormatado} de ${remetente}</td>
                </tr>
            </table>
        `;
        $('#mensagem-transferencia').html(tabelaTransferencia).show();
        
        const audio = document.getElementById('audio-transferencia');
        if (localStorage.getItem('soundEnabled')) {
            audio.play().catch(error => {
                console.error('Erro ao tocar o áudio:', error);
            });
        }

        if (navigator.vibrate) {
            navigator.vibrate(200);
        }

        setTimeout(function () {
            $('#mensagem-transferencia').hide();
            $.ajax({
                url: 'transferencias.php',
                method: 'POST',
                data: { action: 'marcar_lidas', ids: JSON.stringify(ids) }
            });
        }, 8000);
    }

    function verificarTransferencias() {
        $.ajax({
            url: 'transferencias.php?action=verificar',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (Array.isArray(response) && response.length > 0) {
                    response.forEach(function (item) {
                        exibirTabelaTransferencia(item.orinome, item.valor, [item.id_trans]);
                    });
                }
            },
            error: function () {
                console.log('Erro ao verificar transferências.');
            }
        });
    }

    setInterval(verificarTransferencias, 3000);
});
</script>
</body>
<!-- InstanceEnd --></html>