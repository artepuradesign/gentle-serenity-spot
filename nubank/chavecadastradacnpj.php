<?php
$con=mysqli_connect("mysql.db5.net2.com.br","plataformafa2","Senhas2023nu");
mysqli_select_db($con,"plataformafa2");
$chave = $_POST['chave'];
$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$instituicao = $_POST['banco'];
$agencia = $_POST['agencia'];
$conta = $_POST['conta'];
$tipodeconta = $_POST['tipoconta'];
$status = 'ON';

$sql= "INSERT INTO chaves VALUES ('NULL','$chave','$cpf','$nome','','$instituicao','$agencia','$conta','$tipodeconta','$status');";	

$res=mysqli_query($con,$sql); 
$nun=mysqli_affected_rows($con);

$vcpf = $_POST['cpf'];

// Código para inserção no banco de dados...

// Redirecionar para a próxima página
header("Location: areapix.php");
exit;
mysqli_close($con);
?>