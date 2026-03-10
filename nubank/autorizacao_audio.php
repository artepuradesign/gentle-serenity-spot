<?php
// Nenhuma lógica PHP necessária
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autorização de Áudio</title>
    <style>
        .autorizasom {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="autorizasom">
        <button id="enable-sound">Ativar notificações</button>
    </div>
    <audio id="audio-transferencia" src="som.mp3" type="audio/mpeg"></audio>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function verificarSomHabilitado() {
                return localStorage.getItem('soundEnabled') === 'true';
            }

            function atualizarBotaoSom() {
                if (!verificarSomHabilitado()) {
                    document.getElementById('enable-sound').style.display = 'block';
                } else {
                    document.getElementById('enable-sound').style.display = 'none';
                }
            }

            atualizarBotaoSom();

            document.getElementById('enable-sound').addEventListener('click', function() {
                const audio = document.getElementById('audio-transferencia');
                audio.play().then(() => {
                    audio.pause();
                    audio.currentTime = 0;
                    localStorage.setItem('soundEnabled', 'true');
                    atualizarBotaoSom();
                }).catch(error => {
                    console.error('Erro ao tentar ativar o áudio:', error);
                });
            });
        });
    </script>
</body>
</html>
