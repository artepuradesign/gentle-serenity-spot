<?php
if(isset($_POST['imagem'])){
    $imagemBase64 = $_POST['imagem'];
    $imagemDecodificada = base64_decode(str_replace('data:image/png;base64,', '', $imagemBase64));

    // Salva a imagem em um arquivo no servidor
    $caminhoImagem = 'imagemweb/imagem.png';
    file_put_contents($caminhoImagem, $imagemDecodificada);

    echo 'Imagem salva com sucesso!';
}
?>
