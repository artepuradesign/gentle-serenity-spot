<?php
// functions.php

function verificarTransferencias($pdo, $cpf)
{
    // Consultar o banco de dados para verificar se há novas transferências
    $query = "SELECT COUNT(*) as num_transferencias FROM transferencias WHERE destinocpf = :destinocpf AND lida = 0";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':destinocpf', $cpf);
    $stmt->execute();
    $resultado = $stmt->fetch();
    $num_transferencias = $resultado['num_transferencias'];

    if ($num_transferencias > 0) {
        $atualizarQuery = "UPDATE transferencias SET lida = 1 WHERE destinocpf = :destinocpf AND lida = 0";
        $atualizarStmt = $pdo->prepare($atualizarQuery);
        $atualizarStmt->bindParam(':destinocpf', $cpf);
        $atualizarStmt->execute();
        return true;
    } else {
        return false;
    }
}
?>
