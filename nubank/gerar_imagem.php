<?php
// Gera a imagem de exemplo (substitua esta parte com a lógica de criação da imagem que desejar)
$imagem = imagecreatetruecolor(100, 100);
$cor = imagecolorallocate($imagem, 255, 0, 0);
imagefill($imagem, 0, 0, $cor);

// Define o cabeçalho para download da imagem
header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="print.png"');

// Envia a imagem como um arquivo PNG
imagepng($imagem);
imagedestroy($imagem);
?>
