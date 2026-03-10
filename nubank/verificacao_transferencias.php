
<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
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