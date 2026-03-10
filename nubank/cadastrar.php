<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'conexaoatualizada.php'; // Certifique-se de que este arquivo contém a lógica para conectar ao banco de dados usando PDO.

// Verifica se a referência foi passada via URL. Se não, usa a referência padrão "206".
$referencia_id = isset($_GET['ref']) ? (int)$_GET['ref'] : 206;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $instituicao = $_POST['instituicao'];
    $agencia = $_POST['agencia'];
    $conta = $_POST['conta'];
    $tipodeconta = $_POST['tipodeconta'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
    $saldo = 0;  // Saldo inicial padrão para novos usuários
    $status = 'ativo'; // Status padrão para novos usuários
    $saldo_atualizado = date('Y-m-d H:i:s'); // Data e hora da criação do cadastro

    // Verifica se o CPF já está cadastrado
    $stmt = $conexao->prepare("SELECT COUNT(*) FROM usuarios WHERE cpf = :cpf");
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $cpf_existe = $stmt->fetchColumn();

    if ($cpf_existe) {
        echo "Este CPF já está cadastrado.";
    } else {
        // Insere o novo usuário no banco de dados
        $stmt = $conexao->prepare("
            INSERT INTO usuarios (cpf, nome, sobrenome, instituicao, agencia, conta, tipodeconta, senha, saldo, status, saldo_atualizado, referencia_id) 
            VALUES (:cpf, :nome, :sobrenome, :instituicao, :agencia, :conta, :tipodeconta, :senha, :saldo, :status, :saldo_atualizado, :referencia_id)
        ");
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':instituicao', $instituicao);
        $stmt->bindParam(':agencia', $agencia);
        $stmt->bindParam(':conta', $conta);
        $stmt->bindParam(':tipodeconta', $tipodeconta);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':saldo', $saldo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':saldo_atualizado', $saldo_atualizado);
        $stmt->bindParam(':referencia_id', $referencia_id);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
            // Redireciona ou faz outra ação, como iniciar uma sessão para o novo usuário
        } else {
            echo "Ocorreu um erro ao tentar realizar o cadastro.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="styles.css"> <!-- Supondo que você tenha um CSS externo -->
    <style>
        /* Estilos básicos para o formulário de cadastro */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0c3fc, #8ec5fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .form-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container button {
            background-color: #6200ea;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #3700b3;
        }

        .form-container p {
            margin-top: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Cadastro</h1>
        <form method="POST">
            <input type="text" name="cpf" placeholder="CPF" required>
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="text" name="sobrenome" placeholder="Sobrenome" required>
            <input type="text" name="instituicao" placeholder="Instituição" required>
            <input type="text" name="agencia" placeholder="Agência" required>
            <input type="text" name="conta" placeholder="Conta" required>
            <input type="text" name="tipodeconta" placeholder="Tipo de Conta" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Cadastrar</button>
        </form>
        <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
    </div>
</body>
</html>
