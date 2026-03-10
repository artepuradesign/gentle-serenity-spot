document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('audio-transferencia');
    const enableSoundButton = document.getElementById('enable-sound');

    function checkSoundEnabled() {
        return fetch('permissao_som.php')
            .then(response => response.json())
            .then(data => data.som_habilitado === 1);
    }

    function setSoundEnabled(enabled) {
        return fetch('permissao_som.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                habilitado: enabled ? '1' : '0'
            })
        }).then(response => response.json());
    }

    function requestSoundPermission() {
        return new Promise((resolve, reject) => {
            audio.play().then(() => {
                audio.pause();
                setSoundEnabled(true).then(() => resolve()).catch(reject);
            }).catch(reject);
        });
    }

    function showEnableSoundButton() {
        enableSoundButton.style.display = 'block';
    }

    enableSoundButton.addEventListener('click', () => {
        requestSoundPermission().then(() => {
            enableSoundButton.style.display = 'none';
        }).catch(error => {
            console.error('Erro ao tentar ativar o áudio:', error);
        });
    });

    checkSoundEnabled().then(isEnabled => {
        if (!isEnabled) {
            document.body.addEventListener('touchstart', () => {
                showEnableSoundButton();
            }, { once: true });
        }
    });
});
