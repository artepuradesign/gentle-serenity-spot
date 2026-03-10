<?php
session_start();
include_once 'conexaoatualizada.php'; // Certifique-se de que este caminho está correto

if (!isset($_SESSION['id']) || !isset($_SESSION['cpf'])) {
    exit('Usuário não autenticado');
}

$id_cliente = $_SESSION['id'];
$cpf_cliente = $_SESSION['cpf'];
$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$tipotransf = filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_STRING);
$destinonome = filter_input(INPUT_POST, 'destinonome', FILTER_SANITIZE_STRING);
$destinocpf = filter_input(INPUT_POST, 'destinocpf', FILTER_SANITIZE_STRING);
$destinoinstitu = filter_input(INPUT_POST, 'destinoinstitu', FILTER_SANITIZE_STRING);
$destinoagencia = filter_input(INPUT_POST, 'destinoagencia', FILTER_SANITIZE_STRING);
$destinoconta = filter_input(INPUT_POST, 'destinoconta', FILTER_SANITIZE_STRING);
$orinome = filter_input(INPUT_POST, 'orinome', FILTER_SANITIZE_STRING);
$oriinstituicao = filter_input(INPUT_POST, 'oriinstituicao', FILTER_SANITIZE_STRING);
$oriagencia = filter_input(INPUT_POST, 'oriagencia', FILTER_SANITIZE_STRING);
$oriconta = filter_input(INPUT_POST, 'oriconta', FILTER_SANITIZE_STRING);
$oricpf = filter_input(INPUT_POST, 'oricpf', FILTER_SANITIZE_STRING);
$tipotransferencia = filter_input(INPUT_POST, 'tipotransferencia', FILTER_SANITIZE_STRING);

$data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
$hora = filter_input(INPUT_POST, 'hora', FILTER_SANITIZE_STRING);

try {
    $pdo->beginTransaction();

    // Inserir dados na tabela de depósitos
    $queryDeposito = "INSERT INTO depositos (cliente_id, valor, data_deposito) VALUES (:cliente_id, :valor, :data)";
    $stmtDeposito = $pdo->prepare($queryDeposito);
    $stmtDeposito->bindParam(':cliente_id', $id_cliente);
    $stmtDeposito->bindParam(':valor', $valor);
    $stmtDeposito->bindParam(':data', $data);
    $stmtDeposito->execute();

    // Atualizar o saldo do usuário
    $querySaldo = "UPDATE usuarios SET saldo = saldo + :valor WHERE id_cod = :id";
    $stmtSaldo = $pdo->prepare($querySaldo);
    $stmtSaldo->bindParam(':valor', $valor);
    $stmtSaldo->bindParam(':id', $id_cliente);
    $stmtSaldo->execute();

    // Gerar um valor para o campo chave
    $chave = uniqid('trans_', true);

    // Inserir dados na tabela de transferências
    $queryTransferencia = "INSERT INTO transferencias (chave, data, hora, valor, tipodetransf, destinonome, destinocpf, destinoinstitu, destinoagencia, destinoconta, dtconta, orinome, oriinstituicao, oriagencia, oriconta, oricpf, tipo, usuariotransf, lida) 
                           VALUES (:chave, :data, :hora, :valor, :tipotransf, :destinonome, :destinocpf, :destinoinstitu, :destinoagencia, :destinoconta, :data, :orinome, :oriinstituicao, :oriagencia, :oriconta, :oricpf, :tipotransferencia, :id, 0)";
    $stmtTransferencia = $pdo->prepare($queryTransferencia);
    $stmtTransferencia->bindParam(':chave', $chave);
    $stmtTransferencia->bindParam(':data', $data);
    $stmtTransferencia->bindParam(':hora', $hora);
    $stmtTransferencia->bindParam(':valor', $valor);
    $stmtTransferencia->bindParam(':tipotransf', $tipotransf);
	$stmtTransferencia->bindParam(':destinonome', $destinonome);
    $stmtTransferencia->bindParam(':destinocpf', $destinocpf);
    $stmtTransferencia->bindParam(':destinoinstitu', $destinoinstitu);
    $stmtTransferencia->bindParam(':destinoagencia', $destinoagencia);
    $stmtTransferencia->bindParam(':destinoconta', $destinoconta);
    $stmtTransferencia->bindParam(':orinome', $orinome);
    $stmtTransferencia->bindParam(':oriinstituicao', $oriinstituicao);
    $stmtTransferencia->bindParam(':oriagencia', $oriagencia);
    $stmtTransferencia->bindParam(':oriconta', $oriconta);
    $stmtTransferencia->bindParam(':oricpf', $oricpf);
    $stmtTransferencia->bindParam(':tipotransferencia', $tipotransferencia);
	$stmtTransferencia->bindParam(':id', $id_cliente);
    $stmtTransferencia->execute();

    $pdo->commit();
    echo "Operação de {$tipotransferencia} realizada com sucesso!";

    // Espera 2 segundos antes de redirecionar
    sleep(2);

    // Redireciona para a página painel2.php
    header("Location: painel2.php");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erro ao realizar a operação: " . $e->getMessage();
}
?>
