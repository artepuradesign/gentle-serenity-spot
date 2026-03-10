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

$larguratabela = "98%";
?>
<?php
// Verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtendo a senha fornecida no formulário
  $senha = $_POST['1'] . $_POST['2'] . $_POST['3'] . $_POST['4'];
  
  // Obtendo o ID do usuário da sessão
  $idUsuario = $_SESSION['id'];
  
  // Realize a lógica necessária para obter a senha armazenada do usuário com base no ID do usuário.
  // Supondo que você tenha um banco de dados e uma tabela "usuarios" com uma coluna "senha", você poderia fazer algo como:
  
  // Conecte-se ao banco de dados (substitua os valores com as configurações do seu banco de dados)
  include_once 'conexaoatualizada.php'; // Inclua o arquivo de conexão

  $conexao = new mysqli($host, $usuario, $senhadb, $banco);
  
  // Verifique se houve algum erro de conexão
  if ($conexao->connect_error) {
    die('Erro de conexão: ' . $conexao->connect_error);
  }
  
  // Prepare a consulta SQL para obter a senha do usuário com base no ID do usuário
  $consulta = $conexao->prepare("SELECT senha FROM usuarios WHERE id_cod = ?");
  $consulta->bind_param("i", $idUsuario);
  $consulta->execute();
  
  // Obtenha o resultado da consulta
  $resultado = $consulta->get_result();
  
  // Verifique se a consulta retornou algum resultado
  if ($resultado->num_rows === 1) {
    // Obtenha a senha armazenada no banco de dados
    $row = $resultado->fetch_assoc();
    $senhaArmazenada = $row['senha'];
    
    // Verifique se a senha fornecida corresponde à senha armazenada
    if ($senha === $senhaArmazenada) {
      // A senha é válida, faça o que for necessário aqui
      
      // Exemplo: exiba uma mensagem de sucesso
	  

$conexao = mysqli_connect($host, $usuario, $senhadb, $banco);

$chave = $_POST['chave'];
$data = $_POST['data'];
$hora = $_POST['hora'];
$valor = $_POST['valor'];
$tipodetransf = 'Pix';
$destinonome = $_POST['dnome'];
$cpf = $_POST['dcpf'];
$destinoinstitu = $_POST['dinstitu'];
$destinoagencia = $_POST['dagencia'];
$dconta = $_POST['dconta'];
$dtconta = $_POST['dtconta'];
$onome = $_POST['onome'];
$oriinstituicao = $_POST['oinstitu'];
$oriagencia = $_POST['oagencia'];
$oriconta = $_POST['oconta'];
$oricpf = $_POST['ocpf'];
$usuariotransf = $_POST['ocpf'];

// Inserir a transação enviada
$sql_enviada = "INSERT INTO transferencias (chave, data, hora, valor, tipodetransf, destinonome, destinocpf, destinoinstitu, destinoagencia, destinoconta, dtconta, orinome, oriinstituicao,oriagencia,oriconta,oricpf,tipo,usuariotransf) 
VALUES ('$chave','$data', '$hora', '$valor', '$tipodetransf', '$destinonome', '$cpf', '$destinoinstitu', '$destinoagencia', '$dconta', '$dtconta','$onome','$oriinstituicao','$oriagencia','$oriconta','$oricpf','enviada','$oricpf')";

$res_enviada = mysqli_query($conexao, $sql_enviada);

// Inserir a transação recebida
$sql_recebida = "INSERT INTO transferencias (chave, data, hora, valor, tipodetransf, destinonome, destinocpf, destinoinstitu, destinoagencia, destinoconta, dtconta, orinome, oriinstituicao,oriagencia,oriconta,oricpf,tipo,usuariotransf) 
VALUES ('$chave','$data', '$hora', '$valor', '$tipodetransf', '$destinonome', '$cpf', '$destinoinstitu', '$destinoagencia', '$dconta', '$dtconta','$onome','$oriinstituicao','$oriagencia','$oriconta','$oricpf','recebida','$oricpf')";

$res_recebida = mysqli_query($conexao, $sql_recebida);

if ($res_enviada && $res_recebida) {
	$transferenciaRealizadaURL = 'transferenciarealizada.php';
    $postFields = array(
        'chave' => $chave,
        'data' => $data,
        'hora' => $hora,
        'valor' => $valor,
        'dnome' => $destinonome,
        'dcpf' => $cpf,
        'dinstitu' => $destinoinstitu,
        'dagencia' => $destinoagencia,
        'dconta' => $dconta,
        'dtconta' => $dtconta,
        'onome' => $onome,
        'oinstitu' => $oriinstituicao,
        'oagencia' => $oriagencia,
        'oconta' => $oriconta,
        'ocpf' => $oricpf
    );
    ?>
    <form id="postForm" action="<?php echo $transferenciaRealizadaURL ?>" method="post">
        <?php
        foreach ($postFields as $name => $value) {
            echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
        }
        ?>
    </form>
    
    <script type="text/javascript">
        document.getElementById('postForm').submit();
    </script>
    <?php
} else {
    echo "Erro ao cadastrar: " . mysqli_error($conexao);
}


if (mysqli_connect_errno()) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

$id = $_SESSION['id']; // ID do usuário remetente

// Obtém o saldo atual do usuário remetente
$sqlSaldoRemetente = "SELECT saldo FROM usuarios WHERE id_cod = $id";
$resultadoRemetente = mysqli_query($conexao, $sqlSaldoRemetente);
$saldoAtualRemetente = 0;

if ($resultadoRemetente) {
    $row = mysqli_fetch_assoc($resultadoRemetente);
    $saldoAtualRemetente = $row['saldo'];
} else {
    die("Erro ao consultar o saldo do remetente: " . mysqli_error($conexao));
}

// Subtrai o valor da transferência do saldo do remetente
$novoSaldoRemetente = $saldoAtualRemetente - $valor;

// Atualiza o saldo do remetente no banco de dados
$sqlUpdateRemetente = "UPDATE usuarios SET saldo = $novoSaldoRemetente WHERE id_cod = $id";
if (!mysqli_query($conexao, $sqlUpdateRemetente)) {
    die("Erro ao atualizar o saldo do remetente: " . mysqli_error($conexao));
}

// Atualiza o saldo na sessão
$_SESSION['saldo'] = $novoSaldoRemetente;

// Atualizar o saldo do destinatário
$chavepix = $_POST['chave']; // Assumindo que $chavepix é a chave CPF do destinatário

// Obtém o saldo atual do destinatário
$sqlConsulta = "SELECT saldo FROM usuarios WHERE cpf = '$chavepix'";
$resultadoConsulta = mysqli_query($conexao, $sqlConsulta);

if ($resultadoConsulta) {
    $row = mysqli_fetch_assoc($resultadoConsulta);
    $saldoAtual = $row['saldo'];

    // Calcula o novo saldo
    $novoSaldo = $saldoAtual + $valor;

    // Atualiza o campo de saldo na tabela usuarios
    $sqlAtualizacao = "UPDATE usuarios SET saldo = $novoSaldo WHERE cpf = '$chavepix'";
    if (mysqli_query($conexao, $sqlAtualizacao)) {
        echo "Campo saldo atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar o campo saldo: " . mysqli_error($conexao);
    }
} else {
    echo "Erro ao consultar o saldo: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>
      
<?php

    } else {
      // A senha não corresponde, faça o que for necessário aqui
      
      // Exemplo: exiba uma mensagem de erro
?>
<script>
    // Redirecionar para a página anterior
    window.history.back();
</script>
<?php    
}
  } else {
    // ID de usuário inválido, faça o que for necessário aqui
    
    // Exemplo: exiba uma mensagem de erro
    echo "ID de usuário inválido.";
  }
  
  // Feche a conexão com o banco de dados
  $conexao->close();
}
?>
