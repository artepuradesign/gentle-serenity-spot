<?php
ob_start();
include('conexaoatualizada.php');
include('../protecao.php');
include('../verificacao_transferencias.php');
ob_end_clean();
?>
<?php
// Array com os nomes das imagens
$imagens = ['indique_2.jpg', 'indique_3.jpg', 'indique_4.jpg'];

// Obter o número de segundos desde o início do Unix Epoch
$tempoAtual = time();

// Calcular o índice da imagem com base no tempo atual
// Isso garantirá uma mudança de imagem a cada 3 segundos
$indiceImagem = ($tempoAtual / 3) % count($imagens);

// Selecionar a imagem
$imagemEscolhida = $imagens[$indiceImagem];

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
  <td height="42" valign="top"><!-- InstanceBeginEditable name="conteudo" -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'conexaoatualizada.php';

$usuario_id = !empty($_SESSION['id']) ? $_SESSION['id'] : 26;
$link_completo = "https://svrsrs.com/nubank/cadastrar.php?ref=" . $usuario_id;
$codigo_referencia = $usuario_id;
?>

    <style>
        .container {
	font-family: Arial, sans-serif;
	margin: 20px;
	padding: 20px;
	border: 1px solid #ccc;
	border-radius: 8px;
	background-color: #f9f9f9;
	max-width: 700px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	background-position: center;
        }
        .link-box {
            display: flex;
            align-items: center;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
        }
        .link-box input {
			margin-left:15;
            border: none;
            background: none;
            width: 100%;
            font-size: 24px;
            color: #333;
            outline: none;
        }
        .link-box button {
	font-size:16;
	width:90%;
	background-color: #3F1875;
	color: white;
	border: none;
	padding: 15px;
	border-radius: 25px;
	cursor: pointer;
	transition: background-color 0.3s;
        }
        .link-box button:hover {
            background-color: #45a049;
        }
        .link-box button:active {
            transform: scale(0.98);
        }
        .success-message {
            color: #28a745;
            margin-top: 10px;
            display: none;
            font-weight: bold;
        }
        .share-icons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .share-icons a {
            text-decoration: none;
            font-size: 24px;
            color: #555;
            transition: color 0.3s;
        }
        .share-icons a:hover {
            color: #000;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script>
    function copyToClipboard() {
        var fullLink = "<?php echo $link_completo; ?>";
        var tempInput = document.createElement("input");
        tempInput.value = fullLink;
        document.body.appendChild(tempInput);
        tempInput.select();
        tempInput.setSelectionRange(0, 99999);
        document.execCommand("copy");
        document.body.removeChild(tempInput);

        var successMessage = document.getElementById("successMessage");
        successMessage.style.display = "block";

        setTimeout(function() {
            successMessage.style.display = "none";
        }, 3000);
    }
</script>
<center>
<?php
$tamanhoicones = "40px"; // Defina o tamanho desejado aqui
$tamanhomargem = "5px"; // Defina o tamanho desejado aqui
?>
<div class="container" style="margin-top: -20px;">    <div class="link-box">
        <!-- Mostrar apenas o código -->
        <input type="text" id="refLinkDisplay" value="<?php echo $codigo_referencia; ?>" readonly>
        <button onclick="copyToClipboard()">Compartilhar</button>
    </div>
    <div id="successMessage" class="success-message">Link copiado com sucesso!</div>

    <div class="share-icons">
        <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($link_completo); ?>" target="_blank" title="Compartilhar no WhatsApp">
            <i class="fab fa-whatsapp" style="color: #25D366; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>;"></i>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($link_completo); ?>" target="_blank" title="Compartilhar no Facebook">
            <i class="fab fa-facebook" style="color: #3b5998; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>;"></i>
        </a>
<a href="https://t.me/share/url?url=<?php echo urlencode($link_completo); ?>" target="_blank" title="Compartilhar no Telegram"><a href="https://t.me/seu_grupo" target="_blank"><i class="fab fa-telegram" style="color: #0088cc; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>;"></i>
</a>
        <a href="mailto:?subject=Confira este link&body=Veja este link: <?php echo urlencode($link_completo); ?>" target="_blank" title="Enviar por Email">
            <i class="fas fa-envelope" style="color: #DD4B39; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>; "></i>
        </a>
        <a href="#" onclick="copyToClipboard()" title="Copiar Link">
            <i class="fas fa-copy" style="color: #f0ad4e; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>;"></i>
        </a>
    </div>
</div></center>

<center>
  <div class="container_indicacao" style="max-width: 800px; margin: 0 auto;">
    
<div class="texto_indique" style="width: 100%; margin-bottom: 0; display: flex; align-items: flex-start;"><div class="texto_caixa" style="text-align: justify; width: 370px; padding:00px;">
<div class="containerx">
  <img src="imagens/indique_texto.png"> </div>
<style>
    .containerx {
        margin: 0 auto;
        padding: 25px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        color: #5a2a79;
		font-size:14px;

    }
    h2 {
        color: #5a2a79;
        border-bottom: 2px solid #5a2a79;
        padding-bottom: 10px;
        margin-bottom: 20px;
		font-size:18px;

    }
    .section {
		font-size:16px;
        margin-bottom: 20px;
    }
    .section ul {
        list-style-type: none;
        padding: 0;
    }
    .section ul li {
        margin-bottom: 10px;
    }
    .section ul li::before {
        content: '•';
        color: #5a2a79;
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }
    .highlight {
        background-color: #f7f7f7;
        padding: 10px;
        border-left: 4px solid #5a2a79;
    }
</style>
      </div>
      <div> <h1><span class="texto_indique_lilas_24"></div>
    </div><br>
<img src="imagens/<?php echo $imagemEscolhida ?>" alt="Indique e Ganhe" style="max-width: 330px; height: auto; border-radius:15px">  </div>
</center>

<style>
  @media (min-width: 700px) {
	      .containerx {
        width: 100%; /* Ajusta para 90% da largura da tela */
        padding: 20px; /* Opcional: diminui o padding em telas menores */
    }
    .container_indicacao {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .texto_indique {
      width: 50%;
    }

    .container_indicacao img {
      width: 90%;
      max-width: 400px;
      height: auto;
    }
  }
  
  
</style>


<!-- InstanceEndEditable --></td>
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