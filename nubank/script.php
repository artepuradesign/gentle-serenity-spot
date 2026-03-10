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
