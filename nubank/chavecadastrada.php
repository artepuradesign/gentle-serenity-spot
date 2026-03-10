<?php
session_start();
include 'conexaoatualizada.php'; // Inclua o arquivo de conexão

if (!isset($_SESSION['id'])) {
    header("refresh:0;url=login.php");
    exit;
}
include 'transferencias.php';

$porcentagem = -85;
// dinheiro guardado (% sobre o Dinheiro)
$porcentagem2 = 0.5;
// Lucro bruto
?>
<?php
$con=mysqli_connect("$host","$usuario","$senhadb");
mysqli_select_db($con,"$banco");
$chave = $_POST['chave'];
$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$instituicao = $_POST['banco'];
$agencia = $_POST['agencia'];
$conta = $_POST['conta'];
$tipodeconta = $_POST['tipoconta'];
$status = 'ON';

$sql= "INSERT INTO chaves VALUES ('NULL','$chave','$cpf','$nome','$sobrenome','$instituicao','$agencia','$conta','$tipodeconta','$status');";	

$res=mysqli_query($con,$sql); 
$nun=mysqli_affected_rows($con);

$vcpf = $_POST['cpf'];

// Código para inserção no banco de dados...

// Redirecionar para a próxima página
header("Location: areapix.php");
exit;
mysqli_close($con);
?>