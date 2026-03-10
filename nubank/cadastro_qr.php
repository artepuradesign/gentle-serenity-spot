<?php
// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inclua seu arquivo de conexão ao banco de dados
    include 'conexaoatualizada.php';

    // Receba os dados do formulário
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $chave = $_POST['chave'];
    $instituicao = $_POST['instituicao'];
    $telefone = $_POST['telefone'];

    // Processamento do upload da imagem
    $imagem = $_FILES['imagem'];
    $imagemNome = $imagem['name'];
    $imagemTmp = $imagem['tmp_name'];
    $imagemErro = $imagem['error'];

    if ($imagemErro === 0) {
        $imagemDestino = 'uploads/' . basename($imagemNome);

        if (move_uploaded_file($imagemTmp, $imagemDestino)) {
            // Insira os dados no banco de dados
            $sql = "INSERT INTO qrcodes (nome, cpf, chave, instituicao, telefone, imagem) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $cpf, $chave, $instituicao, $telefone, $imagemDestino]);

            echo "<p>QR Code cadastrado com sucesso!</p>";
        } else {
            echo "<p>Erro ao fazer o upload da imagem.</p>";
        }
    } else {
        echo "<p>Erro no upload da imagem.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .form-container h2 {
            margin-top: 0;
        }
        .form-container input[type="text"], .form-container input[type="file"], .form-container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .form-container button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Cadastro de QR Code</h2>
        <form action="cadastro_qrcode.php" method="post" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" required>

            <label for="chave">Chave Pix:</label>
            <input type="text" name="chave" id="chave" required>

            <label for="instituicao">Instituição:</label>
            <input type="text" name="instituicao" id="instituicao" required>

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" required>

            <label for="imagem">Imagem do QR Code:</label>
            <input type="file" name="imagem" id="imagem" accept="image/*" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
