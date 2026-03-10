<?php
ob_start();
include('conexaoatualizada.php');
include('protecao.php');
include('verificacao_transferencias.php');
ob_end_clean();
?>
<div id="mensagem-transferencia" class="mensagem-transferencia" style="display:none; text-align:center;"></div>
<audio id="audio-transferencia" src="som.mp3" type="audio/mpeg"></audio>

<!DOCTYPE html>
<html><head>
<link rel="stylesheet" href="estilo_nubank.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>

.image-container {
  white-space: nowrap;  /* Mantém os ícones em uma linha */
  overflow-x: hidden;   /* Esconde qualquer conteúdo que ultrapasse a largura */
  cursor: grab;         /* Muda o cursor para indicar que o conteúdo é arrastável */
  scrollbar-width: none; /* Oculta a barra de rolagem no Firefox */
  position: relative;   /* Necessário para arrastar os elementos */
}

/* Oculta a barra de rolagem no Chrome, Safari e Edge */
.image-container::-webkit-scrollbar {
  display: none;
}

/* Cursor ao arrastar */
.image-container:active {
  cursor: grabbing; /* Indica que o conteúdo está sendo arrastado */
}
</style>

<title>Nubank</title>
<?php include('icones.php'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Remova a barra de navegação e o botão "Abrir" no Safari no iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Defina a cor da barra de status no Safari no iOS -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="stylesheet" href="estilo_nubank.css">

</head>
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
$cpfusuario = $_SESSION['cpf'];
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
    echo "Nenhum registro encontrado para o CPF informado.";
}

mysqli_close($con);
?>
<td height="50" align="center" valign="top">
<table class="largura_padrao" border="0" align="center">
<tr>
<td class="topotexto">Olá <?php echo ucwords(strtolower($nome));?></td>
</tr>
</table></td>
</tr>
</table><a href="historico.php" class="table-link">
<table class="largura_padrao" border="0" align="center" id="tabsaldo">
<tr>
<td height="20" colspan="2" style="font-size: 20px; "></td>
</tr>
<tr>
<td height="25" align="left" valign="top" style="font-size: 18px;">Conta<br></td>
<td align="right" style="font-size: 18px; "><a href="#"><img src="imagens/seta.png" width="18"></td>
</tr>
<tr>
<td height="45" align="left" valign="top" id="val" style="font-size: 18px; ;"><?php echo "R$ " . number_format($saldo, 2, ',', '.');?></td>
<td height="45" align="left" valign="top" id="val" style="font-size: 18px; ;"></td>
</tr>
</table>

</a>
<table align="center" class="largura_padrao" id="menu">
<tr>
  <td height="50" valign="middle" style="font-size: 20px;"><div class="image-container" id="draggable-container">&nbsp;<a href="areapix.php"><img src="imagens/areapix.png" alt="50" width="75" height="240"></a><a href="deposito.php"><img src="imagens/bt_depositar.png" width="75" height="240"></a><a href="indique.php"><img src="imagens/bt_indique.fw.png" width="75" height="240"></a><a href="#"><img src="imagens/cartoes.fw.png" width="75" height="240"></a><a href="#"><img src="imagens/bt_qrcode.fw.png" width="75" height="240"></a><img src="imagens/pagar.png" width="75" height="240"><img src="imagens/investir.png" width="75" height="240"><img src="imagens/bt_telegram.fw.png" width="75" height="240"><img src="imagens/bt_instagram.fw.png" width="75" height="240"><a href="#"><img src="imagens/download.fw.png" width="75" height="240"></a><img src="imagens/suporte.fw.png" width="75" height="240"><img src="imagens/bt_ajustes.fw.png" width="75" height="240">&nbsp;	&nbsp;&nbsp;&nbsp; </div></td>
</table>
<table class="largura_padrao" border="0" align="center">
<tr>

</tr>
<tr>
<td height="85" align="left" valign="middle" style="font-size: 20px; "><span class="image-container"><img src="imagens/meuscards.png" width="340" height="59"></span></td>
</tr>
<tr>
<td height="110" valign="middle" style="font-size: 20px;"><div class="image-container"><img src="imagens/banner1.png" alt="50" width="289" height="190"><img src="imagens/banner2.png" width="289" height="190">&nbsp;	&nbsp;&nbsp;&nbsp; </div>
</td>
</tr>
</table>
<hr class="linha">
<table class="largura_padrao" border="0" align="center">
<tr>
<td><table width="100%" border="0" align="center">
<tr>
<td height="35" align="left"><span style="font-size: 17px;">Cartão de crédito</span></td>
<td align="right"><span style="font-size: 18px; "><a href="#"><img src="imagens/seta.png" width="18"></td>
</tr>
<tr>
<td height="30" colspan="2" align="left" valign="bottom"><span class="icon3" style="font-size: 17px; color: #000000;">Fatura atual</span></td>
</tr>
<tr>
<td height="30" colspan="2" align="left"><span style="font-size: 18px; color: #000000;" ><?php 
$guardado1 = $saldo;
$guardado2 = $saldo;

$porcentagem_decimal = $porcentagem / 100; // Converter a porcentagem para decimal
$valor_porcentagem = $saldo * $porcentagem_decimal; // Calcular o valor da porcentagem
$valor_final = $saldo + $valor_porcentagem; // Adicionar o valor da porcentagem ao saldo

$guardado = $valor_final;
?>
R$ </span><?php echo number_format($valor_final, 2, ',', '.')?></td>
</tr>
<tr>
<td height="40" colspan="2" align="left" valign="middle"><span class="icon3" style="font-size: 14px; color: #575757;">Limite disponível de R$ <?php 

$porcentagem_decimal = $porcentagem2 / 100; // Converter a porcentagem para decimal
$valor_porcentagem2 = $guardado * $porcentagem_decimal; // Calcular o valor da porcentagem

$comlucro = $valor_final + $valor_porcentagem2;
$lucrofinal = $comlucro + $valor_final;	  

?>
<?php echo number_format($lucrofinal, 2, ',', '.')?></span></td>
</tr>
</table></td>
</tr>
</table>
<hr class="linha">
<table class="largura_padrao" border="0" align="center">
<tr>
<td><table width="100%" border="0" align="center">
<tr>
<td height="35" align="left"><span style="font-size: 17px;">Acompanhe também</span></td>
</tr>
<tr>
<td height="40" align="left" valign="bottom"><img src="imagens/assistente.png" width="370"></td>
</tr>
</table></td>
</tr>
</table>
<hr class="linha">
<table class="largura_padrao" border="0" align="center">
<tr>
<td><table width="100%" border="0" align="center">
<tr>
<td height="30" align="left"><span style="font-size: 17px; ">Empréstimo</span></td>
</tr>
<tr>
<td height="50" align="left" valign="middle"><span class="fatura">Aviso criado! Vamos te avisar aqui no app se um empréstimo ficar disponível.</span></td>
</tr>
</table></td>
</tr>
</table>
<hr class="linha">
<table class="largura_padrao" border="0" align="center">
<tr>
<td><table width="100%" border="0" align="center">
<tr>
<td height="30" align="left"><span style="font-size: 17px; ">Descubra mais</span></td>
</tr>
</table></td>
</tr>
</table>
<table border="0" align="center" class="largura_padrao" id="descubra">
<tr>
<td height="309" valign="middle" style="font-size: 20px;"><div class="image-container">&nbsp;<img src="imagens/c1.png" alt="50" width="240" height="552"><img src="imagens/c2.png" width="240" height="552"><img src="imagens/c3.png" width="240" height="552"><img src="imagens/c4.png" width="240" height="552"><img src="imagens/c5.png" width="240" height="552"><img src="imagens/c6.png" width="240" height="552"><img src="imagens/c7.png" width="240" height="552">&nbsp;	&nbsp;&nbsp;	&nbsp;&nbsp; </div></td>
</tr>
<tr>
<td height="80" align="center" valign="top" style="font-size: 20px;"><img src="imagens/btx.png" name="divFixa" width="450" height="200" id="divFixa"></td>
</tr>
</table>
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
<script>
  // Código para arrastar o elemento com o ID 'draggable-container'
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
    const walk = (x - startX) * 3; // Ajuste a multiplicação para a velocidade de arrasto
    container.scrollLeft = scrollLeft - walk;
  });

  // Adicione código semelhante para o elemento com o ID 'descubra'
  const descobrirContainer = document.getElementById('descubra');
  
  descobrirContainer.addEventListener('mousedown', (e) => {
    isDown = true;
    descobrirContainer.classList.add('active');
    startX = e.pageX - descobrirContainer.offsetLeft;
    scrollLeft = descobrirContainer.scrollLeft;
  });

  descobrirContainer.addEventListener('mouseleave', () => {
    isDown = false;
    descobrirContainer.classList.remove('active');
  });

  descobrirContainer.addEventListener('mouseup', () => {
    isDown = false;
    descobrirContainer.classList.remove('active');
  });

  descobrirContainer.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - descobrirContainer.offsetLeft;
    const walk = (x - startX) * 3; // Ajuste a multiplicação para a velocidade de arrasto
    descobrirContainer.scrollLeft = scrollLeft - walk;
  });
  $(function() {
    $("#draggable-container, #descubra").draggable({
        containment: "body", // Mantém o elemento dentro da área visível da página
        cursor: "move" // Cursor de mover enquanto arrasta
    });
});
</script>
</body>
</html>