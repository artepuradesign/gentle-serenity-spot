<?php
// Incluir a conexão PDO
include 'conexaoatualizada.php';

// Verificar se há uma referência fornecida na URL
$referido_por = isset($_GET['ref']) ? intval($_GET['ref']) : 206;

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];  // Senha de 4 dígitos
    $senha_alfa = $_POST['senha_alfa'];  // Senha alfa com letras e números
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $instituicao = $_POST['instituicao'];
    $agencia = $_POST['agencia'];
    $conta = $_POST['conta'];
    $tipodeconta = $_POST['tipodeconta'];
    $nascimento = $_POST['nascimento'];
    $telemovel = $_POST['telemovel'];
    $email = $_POST['email'];
    $whatsapp = $_POST['whatsapp'];
    $facebook = $_POST['facebook'];
    $telegram = $_POST['telegram'];
    $twitter = $_POST['twitter'];
    $plataforma = $_POST['plataforma'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $nivel_usuario = $_POST['nivel_usuario'];

    // Preparar a query para inserir o usuário
    $stmt = $pdo->prepare("INSERT INTO usuarios (cpf, senha, senha_alfa, nome, sobrenome, instituicao, agencia, conta, tipodeconta, nascimento, telemovel, email, whatsapp, facebook, telegram, twitter, plataforma, cep, endereco, cidade, estado, nivel_usuario, referido_por) 
                           VALUES (:cpf, :senha, :senha_alfa, :nome, :sobrenome, :instituicao, :agencia, :conta, :tipodeconta, :nascimento, :telemovel, :email, :whatsapp, :facebook, :telegram, :twitter, :plataforma, :cep, :endereco, :cidade, :estado, :nivel_usuario, :referido_por)");
    
    // Executar a query
    $stmt->execute([
        ':cpf' => $cpf,
        ':senha' => $senha,
        ':senha_alfa' => $senha_alfa,
        ':nome' => $nome,
        ':sobrenome' => $sobrenome,
        ':instituicao' => $instituicao,
        ':agencia' => $agencia,
        ':conta' => $conta,
        ':tipodeconta' => $tipodeconta,
        ':nascimento' => $nascimento,
        ':telemovel' => $telemovel,
        ':email' => $email,
        ':whatsapp' => $whatsapp,
        ':facebook' => $facebook,
        ':telegram' => $telegram,
        ':twitter' => $twitter,
        ':plataforma' => $plataforma,
        ':cep' => $cep,
        ':endereco' => $endereco,
        ':cidade' => $cidade,
        ':estado' => $estado,
        ':nivel_usuario' => $nivel_usuario,
        ':referido_por' => $referido_por,
    ]);

    echo "<div class='success'>Cadastro realizado com sucesso!</div>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            overflow: auto;
        }
        .form-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 450px;
            box-sizing: border-box;
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }
        input, select {
            width: 100%;
            padding: 15px;
            margin-bottom: 00px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 18px;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.3s;
        }
        input:focus, select:focus {
            border-color: #0071e3;
        }
        .submit-btn {
	background-color: #3F1875;
	color: white;
	border: none;
	padding: 15px;
	border-radius: 8px;
	cursor: pointer;
	font-size: 18px;
	width: 100%;
	transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #005bb5;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 18px;
        }
        .input-container {
            margin-bottom: 20px;
        }
        .input-container label {
	display: block;
	margin-bottom: 8px;
	font-size: 16px;
	color: #333;
	text-align: left;
        }
        </style>
</head>
<body>
<center>
<div class="form-container">
    <form action="" method="POST">
        <div class="input-container">
          <input type="text" id="cpf" name="cpf" placeholder="CPF" required maxlength="15">
        </div>
        <div class="input-container">
          <input type="text" id="senha" name="senha" placeholder="Senha (4 dígitos)" required maxlength="4" pattern="\d{4}" title="Senha deve conter apenas 4 dígitos">
        </div>
        <div class="input-container">
          <input type="text" id="senha_alfa" name="senha_alfa" placeholder="Senha Alfanumérica" required maxlength="255" pattern="[A-Za-z0-9]{1,255}" title="Senha alfa deve conter letras e números">
        </div>
        <div class="input-container">
          <input type="text" id="nome" name="nome" placeholder="Primeiro Nome" required maxlength="50">
        </div>
        <div class="input-container">
            <input type="text" id="sobrenome" name="sobrenome" placeholder="Sobrenome" required maxlength="100">
        </div>
        <div class="input-container" style="display:none">
            <input name="instituicao" type="text" required id="instituicao" placeholder="Instituição Bancária" value="NU PAGAMENTOS - IP" maxlength="200">
        </div>
        <div class="input-container" style="display: none;">
            <input name="agencia" type="text" required id="agencia" placeholder="Agência" value="0001" maxlength="10">
        </div>
        <div class="input-container" style="display:none">
        <?php
// Gera um número aleatório de 6 dígitos
$numeroConta = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
?>
            <input name="conta" type="text" required id="conta" placeholder="Conta" value="<?php echo htmlspecialchars($numeroConta); ?>" maxlength="10">
        </div>
      <div class="input-container" style="display: none;">
            <label for="tipodeconta">Tipo de Conta</label>
            <select id="tipodeconta" name="tipodeconta" required>
                <option value="Conta corrente" selected="selected">Conta corrente</option>
                <option value="poupanca">Poupança</option>
                <option value="salario">Salário</option>
            </select>
        </div>
        <div class="input-container"><input type="text"  id="nascimento" name="nascimento" placeholder="Data de Nascimento" required>
        </div>
        <div class="input-container">
            <input type="text" id="telemovel" name="telemovel" placeholder="Telefone" required maxlength="15">
        </div>
      <div class="input-container">
            <input type="email" id="email" name="email" placeholder="E-mail" required maxlength="100">
        </div>
        <div class="input-container" style="display:none">
            <input type="text" id="whatsapp" name="whatsapp" placeholder="WhatsApp" maxlength="15">
        </div>
        <div class="input-container" style="display:none">
            <input type="text" id="facebook" name="facebook" placeholder="Facebook" maxlength="255">
        </div>
        <div class="input-container" style="display:none">
            <input type="text" id="telegram" name="telegram" placeholder="Telegram" maxlength="50">
        </div>
        <div class="input-container" style="display:none">
            <input type="text" id="twitter" name="twitter" placeholder="Twitter" maxlength="50">
        </div>
        <div class="input-container" style="display:none">
            <input name="plataforma" type="text" id="plataforma" placeholder="Plataforma" value="260" maxlength="50">
        </div>
        <div class="input-container">
            <input type="text" id="cep" name="cep" placeholder="CEP" required maxlength="10" onblur="consultarCEP(this.value)">
        </div>
        <div class="input-container">
            <input type="text" id="endereco" name="endereco" placeholder="Endereço" required maxlength="255">
        </div>
        <div class="input-container">
            <input type="text" id="cidade" name="cidade" placeholder="Cidade" required maxlength="100">
        </div>
        <div class="input-container">
            <input type="text" id="estado" name="estado" placeholder="Estado" required maxlength="2">
        </div>
      <div class="input-container">
            <select id="nivel_usuario" name="nivel_usuario" required>
                <option value="comum">Comum</option>
                <option value="premium">Premium</option>
                <option value="admin">Admin</option>
            </select>
        </div>
      <button type="submit" class="submit-btn">Cadastrar</button>
    </form>
</div>
</center>
<script>
function consultarCEP(cep) {
    if (cep.length === 8) {
        fetch(`https://brasilapi.com.br/api/cep/v2/${cep}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.street) {
                    document.getElementById('endereco').value = data.street;
                    document.getElementById('cidade').value = data.city;
                    document.getElementById('estado').value = data.state;
                } else {
                    alert('CEP não encontrado.');
                }
            })
            .catch(error => {
                console.error('Erro ao buscar o CEP:', error);
            });
    }
}
</script>

</body>
</html>
