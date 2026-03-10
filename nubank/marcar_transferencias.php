<?php
session_start();
include_once 'conexaoatualizada.php';

// Verificar se o usuário está autenticado
if (!isset($_SESSION['id']) || !isset($_SESSION['cpf'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado']);
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senhadb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro na conexão com o banco de dados']);
    exit;
}

// Função para marcar transferências como lidas
function marcarTransferenciasComoLidas($pdo, $ids)
{
    if (!empty($ids)) {
        // Convertendo os IDs para um array de placeholders
        $ids = json_decode($ids, true);
        $idsPlaceholder = implode(',', array_fill(0, count($ids), '?'));
        
        // Preparar a query de atualização
        $atualizarQuery = "UPDATE transferencias SET lida = 1 WHERE id_trans IN ($idsPlaceholder)";
        $atualizarStmt = $pdo->prepare($atualizarQuery);

        try {
            // Executar a query
            $atualizarStmt->execute($ids);
            return ['status' => 'success'];
        } catch (Exception $e) {
            error_log('Erro ao marcar transferências como lidas: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Erro ao marcar transferências como lidas'];
        }
    } else {
        return ['status' => 'error', 'message' => 'Nenhum ID de transferência fornecido.'];
    }
}

// Obter IDs do POST
$ids = $_POST['ids'] ?? '[]';

// Marcar transferências como lidas e retornar o resultado
$result = marcarTransferenciasComoLidas($pdo, $ids);
echo json_encode($result);
?>
