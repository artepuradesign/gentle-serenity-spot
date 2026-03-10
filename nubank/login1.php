<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nubank</title>
<?php include('icones.php'); ?>
<style>
body, td, th {
margin: 0;
padding: 0;
font-family: Arial, sans-serif;
background-color: #820AD1;
color: #820AD1;
text-align: center;
}

/* Estilo para tornar o conteúdo em tela cheia */
#fullscreen-container {
width: 100vw;
height: 100vh;
background-color: #820AD1;
display: flex;
justify-content: center;
align-items: center;
flex-direction: column;
}

/* Alinhar a imagem no centro */
#fullscreen-container img {
display: block;
margin: 0 auto;
opacity: 0;
transition: opacity 1s ease-in-out;
}
</style>
</head>
<body>
<!-- Conteúdo em Tela Cheia -->
<div id="fullscreen-container"><a href="entrar.php"><img id="splash-image" src="splash.png"></a></div>
<script>
// Aguarde 1 segundo e, em seguida, torne a imagem visível
setTimeout(() => {
const splashImage = document.getElementById('splash-image');
splashImage.style.opacity = 1;

// Após 6 segundos (1 segundo + 5 segundos fixos), torne a imagem invisível novamente
setTimeout(() => {
splashImage.style.opacity = 0;

// Redirecionamento automático para entrar.php após a animação
setTimeout(() => {
window.location.href = 'entrar.php';
}, 1500); // Tempo de espera de 1 segundo antes do redirecionamento
}, 2000);
}, 1000);
</script>
</body>
</html>