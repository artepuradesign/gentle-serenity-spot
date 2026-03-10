<?php
session_start();
include_once 'conexaoatualizada.php';

if (!isset($_SESSION['id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Usuário não autenticado');
}

$id_usuario = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $somHabilitado = isset($_POST['habilitado']) ? 1 : 0;
    $query = "UPDATE usuarios SET som_habilitado = :som_habilitado WHERE id = :id_usuario";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':som_habilitado', $somHabilitado, PDO::PARAM_INT);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode(['success' => true]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT som_habilitado FROM usuarios WHERE id = :id_usuario";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($result);
    exit;
}
?>
