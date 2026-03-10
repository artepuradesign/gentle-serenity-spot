<!-- gerar_arquivo.php -->
<?php
// Conteúdo que será colocado no arquivo
$conteudoPagina = "<!DOCTYPE html>\n<html>\n<head>\n<title>Título da Página</title>\n</head>\n<body>\n<h1>Conteúdo da Página</h1>\n<p>Este é um exemplo de conteúdo da página.</p>\n</body>\n</html>";

// Definir o cabeçalho para download do arquivo
header('Content-Type: text/html');
header('Content-Disposition: attachment; filename="pagina.html"');

// Imprimir o conteúdo do arquivo
echo $conteudoPagina;
?>
