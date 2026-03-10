<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitura de QR Code Pix</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
        }
        #qr-reader {
            width: 100%;
            max-width: 500px;
            margin: 20px auto;
            display: none; /* Inicialmente escondido até o usuário ativar */
        }
        #result {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #fafafa;
            font-size: 18px;
            color: #333;
        }
        button {
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Leitura de QR Code Pix</h1>
    
    <button id="start-camera">Iniciar Câmera</button>
    <div id="qr-reader" class="container">
        <video id="video" width="100%" style="max-width: 500px; margin: auto;"></video>
    </div>
    <div id="result">Aguardando leitura...</div>

    <form action="processar_qrcode.php" method="post">
        <input type="hidden" id="qrcode_value" name="qrcode_value">
        <button type="submit">Enviar Dados</button>
    </form>

    <!-- Inclua a biblioteca zxing-js -->
    <script src="https://unpkg.com/@zxing/library@0.18.6/umd/index.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let codeReader = new ZXing.BrowserQRCodeReader();

            function onScanSuccess(result) {
                document.getElementById('result').innerText = `QR Code detectado: ${result.text}`;
                document.getElementById('qrcode_value').value = result.text;
                codeReader.stop();
            }

            function onScanError(error) {
                console.warn(`Erro de leitura: ${error}`);
            }

            document.getElementById('start-camera').addEventListener('click', function() {
                // Exibe o leitor de QR Code
                document.getElementById('qr-reader').style.display = 'block';

                codeReader.decodeFromVideoDevice(null, 'video', (result, error) => {
                    if (result) {
                        onScanSuccess(result);
                    } else if (error) {
                        onScanError(error);
                    }
                }).catch((err) => {
                    document.getElementById('result').innerText = 'Erro ao iniciar a câmera: ' + err;
                    console.error('Erro ao iniciar a câmera: ', err);
                });
            });
        });
    </script>
</body>
</html>
