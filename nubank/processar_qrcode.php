<?php
if (isset($_POST['qrcode_value'])) {
    $qrcode_value = $_POST['qrcode_value'];

    // Aqui você pode processar o valor do QR Code como necessário
    echo "<h1>Dados do QR Code Pix</h1>";
    echo "<p>QR Code: " . htmlspecialchars($qrcode_value) . "</p>";

    // Opcional: redirecionar para outra página, salvar no banco de dados, etc.
} else {
    echo "Nenhum QR Code foi detectado.";
}
?>
