<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Vibração e Notificação</title>
</head>
<body>
    <h1>Teste de Vibração e Notificação</h1>
    <button id="testar-vibracao">Testar Vibração</button>
    <button id="testar-notificacao">Testar Notificação</button>

    <script>
        // Testar vibração
        document.getElementById('testar-vibracao').addEventListener('click', function() {
            if ("vibrate" in navigator) {
                navigator.vibrate(200); // Vibra por 200ms
            } else {
                alert('Vibração não suportada.');
            }
        });

        // Testar notificação
        document.getElementById('testar-notificacao').addEventListener('click', function() {
            if ("Notification" in window) {
                Notification.requestPermission().then(function(permission) {
                    if (permission === "granted") {
                        new Notification("Notificação de Teste", {
                            body: "Esta é uma notificação de teste!",
                            icon: "https://via.placeholder.com/150" // Adicione um ícone para a notificação
                        });
                    } else {
                        alert('Permissão para notificações não concedida.');
                    }
                });
            } else {
                alert('Notificações não suportadas.');
            }
        });
    </script>
</body>
</html>
