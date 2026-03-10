<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'conexaoatualizada.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['cpf'])) {
    header("refresh:2;url=login.php");
    exit('Usuário não autenticado');
}

if (!function_exists('verificarTransferencias')) {
    function verificarTransferencias($pdo, $cpf)
    {
        $query = "SELECT id_trans, orinome, valor FROM transferencias WHERE destinocpf = :destinocpf AND lida = 0";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':destinocpf', $cpf);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('marcarTransferenciasComoLidas')) {
    function marcarTransferenciasComoLidas($pdo, $ids)
    {
        if (!empty($ids)) {
            $idsPlaceholder = implode(',', array_fill(0, count($ids), '?'));
            $atualizarQuery = "UPDATE transferencias SET lida = 1 WHERE id_trans IN ($idsPlaceholder)";
            $atualizarStmt = $pdo->prepare($atualizarQuery);
            $atualizarStmt->execute($ids);
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'verificar') {
    $transferencias = verificarTransferencias($pdo, $_SESSION['cpf']);
    header('Content-Type: application/json');
    echo json_encode($transferencias);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'marcar_lidas') {
    $ids = json_decode($_POST['ids'], true);
    marcarTransferenciasComoLidas($pdo, $ids);
    exit;
}
?>

<div id="mensagem-transferencia" class="mensagem-transferencia" style="display:none; text-align:center;"></div>
<audio id="audio-transferencia" src="som.mp3" type="audio/mpeg"></audio>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    function exibirTabelaTransferencia(remetente, valorTransferencia, ids) {
        var valorFormatado = parseFloat(valorTransferencia).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        var tabelaTransferencia = `
            <br><table class="rounded-table" width="350 px" border="0" align="center">
                <tr>
                   <td align="center"><img src="icone.png" width="30" height="30" style="border-radius: 20%;" /></td>
				   <td width="85%"><b>Transferência recebida</b> <br />
                    Você recebeu uma transferência de ${valorFormatado} de ${remetente}</td>
                </tr>
            </table>
        `;
        $('#mensagem-transferencia').html(tabelaTransferencia).show();
        
        $('#audio-transferencia')[0].play();
        
        if (navigator.vibrate) {
            navigator.vibrate(200);
        }

        setTimeout(function () {
            $('#mensagem-transferencia').hide();
            $.ajax({
                url: 'transferencias.php',
                method: 'POST',
                data: { action: 'marcar_lidas', ids: JSON.stringify(ids) }
            });
        }, 8000);
    }

    function verificarTransferencias() {
        $.ajax({
            url: 'transferencias.php?action=verificar',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (Array.isArray(response) && response.length > 0) {
                    response.forEach(function (item) {
                        exibirTabelaTransferencia(item.orinome, item.valor, [item.id_trans]);
                    });
                }
            },
            error: function () {
                console.log('Erro ao verificar transferências.');
            }
        });
    }

    setInterval(verificarTransferencias, 3000);
});
</script>
