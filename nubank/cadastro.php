<?php
include 'conexao.php'; // Certifique-se de que este é o caminho correto para o seu arquivo de configuração

if (isset($_SESSION['id'])) {
    header("Location: painel2.php"); // Redireciona se já estiver logado
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha']; // Sem hash, salva a senha como está
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $instituicao = $_POST['instituicao'];
    $agencia = $_POST['agencia'];
    $conta = $_POST['conta'];
    $tipodeconta = $_POST['tipodeconta'];
    $saldo = 0; // Valor inicial de saldo
    $status = '1'; // Alterado para "1 ativo"
    $saldo_atualizado = date('Y-m-d H:i:s'); // Data e hora atual

    // Verificar se o CPF já existe
    $sql = "SELECT id_cod FROM usuarios WHERE cpf = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('s', $cpf);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $erro = "CPF já está em uso.";
    } else {
        // Inserir dados na tabela "usuarios"
        $sql = "INSERT INTO usuarios (cpf, senha, nome, sobrenome, instituicao, agencia, conta, tipodeconta, saldo, status, saldo_atualizado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('sssssssssss', $cpf, $senha, $nome, $sobrenome, $instituicao, $agencia, $conta, $tipodeconta, $saldo, $status, $saldo_atualizado);

        if ($stmt->execute()) {
            // Inserir dados na tabela "chaves"
            $sql_chaves = "INSERT INTO chaves (chave, cpf, nome, sobrenome, instituicao, agencia, conta, tipoconta, status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_chaves = $conexao->prepare($sql_chaves);
            $stmt_chaves->bind_param('sssssssss', $cpf, $cpf, $nome, $sobrenome, $instituicao, $agencia, $conta, $tipodeconta, $status);

            if ($stmt_chaves->execute()) {
                $sucesso = "Cadastro realizado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar na tabela 'chaves'.";
            }
        } else {
            $erro = "Erro ao cadastrar. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - APPCENTRAL</title>
    <link rel="stylesheet" href="estilo_comum.css">
<?php include('icones.php'); ?>    
    <style>
	  .hidden {
    display: none !important;
}
</style>
</head>
<body>
    <div class="container">
        <div class="content"><center>
          <a href="painel2.php"><img src="imagens/logo_nova.png" width="150" height="150"></a><br>
          <br>
          <?php if (isset($erro)) { ?>
          <div class="error"><?php echo $erro; ?></div>
            <?php } ?>
            <?php if (isset($sucesso)) { ?>
                <div class="success"><?php echo $sucesso; ?></div>
            <?php } ?><form method="post" action="">
                <input name="cpf" type="text" required placeholder="CPF" maxlength="11">
                <input name="senha" type="password" required placeholder="Senha 4 Dígitos" maxlength="4">
                <input type="text" name="nome" placeholder="Primeiro Nome" required>
                <input type="text" name="sobrenome" placeholder="Sobrenome" required>
                <input name="instituicao" type="text" required placeholder="Instituição Bancária" value="NU PAGAMENTOS - IP" readonly  class="hidden">
                <input name="agencia" type="text" required placeholder="Agência" value="0001" readonly  class="hidden">
                <?php
// Gera um número aleatório de 6 dígitos
$numeroConta = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
?>
                <input name="conta" type="text" required placeholder="Número da Conta" readonly value="<?php echo htmlspecialchars($numeroConta); ?>"  class="hidden">
                <input name="tipodeconta" type="text" required placeholder="Tipo de Conta" value="Conta corrente" readonly  class="hidden">
                <button type="submit">Cadastrar →</button>
             
            </form><p>Já possui uma conta? <a href="login.php">Entrar!</a></p>
</center>
        </div>
        <div class="image"></div>
    </div>
</body>
</html>
