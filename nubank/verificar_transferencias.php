<?php
session_start();
include_once 'conexaoatualizada.php';

// Verificação da sessão do usuário
if (!isset($_SESSION['id'])) {
    echo json_encode([]);
    exit;
}

if (!isset($_SESSION['cpf'])) {
    echo json_encode([]);
    exit;
}

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senhadb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode([]);
    exit;
}

// Função para verificar transferências
function verificarTransferencias($pdo, $cpf)
{
    $query = "SELECT id_trans, orinome, valor FROM transferencias WHERE destinocpf = :destinocpf AND lida = 0";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':destinocpf', $cpf);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $resultados;
}

$transferencias = verificarTransferencias($pdo, $_SESSION['cpf']);
header('Content-Type: application/json');
echo json_encode($transferencias);
?>
