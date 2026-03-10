<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leitor de QR Code</title>
</head>
<body>
    <h1>Leitor de QR Code</h1>
    <button id="start-scan">Iniciar Scanner</button>
    <video id="qr-video" style="width: 100%; height: auto;" playsinline autoplay></video>
    <input type="text" id="result" placeholder="Conteúdo do QR Code" style="width: 100%;" readonly>

    <script src="https://cdn.jsdelivr.net/npm/instascan@2.0.0/instascan.min.js"></script>
    <script>
        const video = document.getElementById('qr-video');
        const resultField = document.getElementById('result');
        const startScanButton = document.getElementById('start-scan');

        let scanner = null;

        startScanButton.addEventListener('click', () => {
            if (scanner) {
                scanner.start();
            } else {
                startScan();
            }
        });

        async function startScan() {
            scanner = new Instascan.Scanner({ video: video });
            scanner.addListener('scan', (content) => {
                resultField.value = content;
                scanner.stop();
            });

            Instascan.Camera.getCameras().then(cameras => {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                    alert("Nenhuma câmera encontrada.");
                }
            }).catch(err => {
                console.error(err);
                alert("Erro ao acessar a câmera.");
            });
        }
    </script>
</body>
</html>
