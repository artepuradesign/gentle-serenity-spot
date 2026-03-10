<?php

include_once 'conexaoatualizada.php';

// Verificação da sessão do usuário
if (!isset($_SESSION['id']) || !isset($_SESSION['cpf'])) {
    header("Location: login.php");
    exit('Usuário não autenticado');
}

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senhadb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit('Erro na conexão com o banco de dados: ' . $e->getMessage());
}

// Função para verificar transferências
function verificarTransferenciasAjax($pdo, $cpf)
{
    $query = "SELECT id_trans, orinome, valor FROM transferencias WHERE destinocpf = :destinocpf AND lida = 0";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':destinocpf', $cpf);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

// Verifica se é uma chamada AJAX para verificar transferências
if (isset($_GET['action']) && $_GET['action'] === 'verificar') {
    $transferencias = verificarTransferenciasAjax($pdo, $_SESSION['cpf']);
    header('Content-Type: application/json');
    echo json_encode($transferencias);
    exit;
}

// Verifica se é uma chamada AJAX para marcar transferências como lidas
if (isset($_POST['action']) && $_POST['action'] === 'marcar_lidas') {
    $ids = $_POST['ids'] ?? [];
    marcarTransferenciasComoLidas($pdo, $ids);
    exit;
}

// Obter transferências inicialmente (ao carregar a página)
$transferencias = verificarTransferenciasAjax($pdo, $_SESSION['cpf']);
$idsTransferencias = array_column($transferencias, 'id_trans');
?>