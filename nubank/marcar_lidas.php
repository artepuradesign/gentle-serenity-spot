<?php
session_start();
include_once 'conexaoatualizada.php';

// Verificação da sessão do usuário
if (!isset($_SESSION['id'])) {
    exit;
}

if (!isset($_SESSION['cpf'])) {
    exit;
}

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senhadb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit;
}

// Função para marcar transferências como lidas
function marcarTransferenciasComoLidas($pdo, $ids)
{
    if (!empty($ids)) {
        $ids = json_decode($ids, true);
        $idsPlaceholder = implode(',', array_fill(0, count($ids), '?'));
        $atualizarQuery = "UPDATE transferencias SET lida = 1 WHERE id_trans IN ($idsPlaceholder)";
        $atualizarStmt = $pdo->prepare($atualizarQuery);

        try {
            $atualizarStmt->execute($ids);
        } catch (Exception $e) {
            error_log('Erro ao marcar transferências como lidas: ' . $e->getMessage());
        }
    } else {
        error_log('Nenhum ID de transferência fornecido.');
    }
}

if (isset($_POST['ids'])) {
    $ids = $_POST['ids'];
    marcarTransferenciasComoLidas($pdo, $ids);
}
?>
