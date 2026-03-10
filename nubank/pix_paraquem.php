<?php
session_start();
include 'conexaoatualizada.php'; // Inclua o arquivo de conexão

if (!isset($_SESSION['id'])) {
    header("refresh:0;url=login.php");
    exit;
}

// Inclua o arquivo de transferências
include 'transferencias.php';

$porcentagem = -85;
$porcentagem2 = 0.5;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senhadb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL para buscar o saldo
    $cpf = $_SESSION['cpf'];
    $sql = "SELECT saldo FROM usuarios WHERE cpf = :cpf";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $resultado = $stmt->fetch();
    $saldo = $resultado['saldo'];

    // Consulta SQL para buscar as chaves
    $sqlChaves = "SELECT chave FROM chaves ORDER BY id_chave DESC LIMIT 5";
    $stmtChaves = $pdo->prepare($sqlChaves);
    $stmtChaves->execute();
    $chaves = $stmtChaves->fetchAll(PDO::FETCH_COLUMN);

    // Codificar chaves em JSON para uso no JavaScript
    $chavesJson = json_encode($chaves);

} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}

$valor = isset($_POST['valor']) ? htmlspecialchars($_POST['valor']) : ''; // Sanitiza o valor da transação
$larguratabela = "98%";
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="imagens/icone.png" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="estilonu.css">
<style type="text/css">
body {
text-align: center;
margin: 0;
padding: 0;
background-color: #FFF;
}

.texto1 {
font-size: 16px;
color: #666;
font-weight: normal;
line-height: 1;
}

img {
max-width: 100%;
height: auto;
}

.botaoentrar {
background-color: #8A02DB;
cursor: pointer;
text-align: center;
margin: 0px;
padding: 0px;
width: 340px;
font-size: 18px;
background-position: center center;
font-style: normal;
height: 60px;
border-radius: 50px;
text-align: center;
border: 1px none #FFF;
color: #FFF;
}

.fundoimagem tr td table tr td {
background-image: url(03.png);
}

.txt {
font-size: 14px;
}

.fundo {
background-image: url(imagens/inicial.PNG);
background-repeat: no-repeat;
background-position: center top;
background-size: 100%;

}

.topo {
background-color: #771AC9;
}

.topotexto {
font-size: 20px;
color: #FFF;
}

.bases {}

.image-container {
overflow-x: auto;
white-space: nowrap;
}

.image-container img {
display: inline-block;
margin-right: 10px;
/* Adicione um espaçamento entre as imagens */
}

.fatura {
font-size: 18px;
color: #666;
font-family: "Graphik Medium";
}

.limite {
font-size: 13px;
color: #797979;
}

.linha {
width: 100%;
height: 1px;
background-color: #EBEBEB;
border-top-style: none;
border-right-style: none;
border-bottom-style: none;
border-left-style: none;
}

#divFixa {
position: fixed;
bottom: 2px;
/* Ajuste o valor do espaçamento conforme necessário */
width: 285px;
left: 50%;
transform: translateX(-50%);
background-color: rgba(0, 0, 0, 0.0);
opacity: 0.96;
}

.valortransf {
font-size: 34px;
border-top-style: none;
border-right-style: none;
border-bottom-style: none;
border-left-style: none;
color: #000;
}

.linha1 {
width: 100%;
height: 1px;
background-color: #EBEBEB;
border-top-style: none;
border-right-style: none;
border-bottom-style: none;
border-left-style: none;
}

.valorx {
	outline: none;
	font-size: 25px;
	color: #000;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	width: 90%;
	font-family: "Graphik Medium";
}
  .valorx::placeholder {
    font-size: 18px; /* Ajuste o tamanho da fonte do placeholder conforme necessário */
  }

.linha {
background-image: url(imagens/linha.png);
background-repeat: no-repeat;
background-position: center bottom;
width: 100%;
}
.chave-lista {
    margin-top: 20px;
    text-align: left;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    max-height: 200px;
    overflow-y: auto;
}

.chave-item {
    cursor: pointer;
    color: #007bff;
    text-decoration: underline;
    margin-bottom: 10px; /* Espaço entre os itens */
    padding: 5px;
    border-radius: 3px;
}

.chave-item:hover {
    color: #0056b3;
    background-color: #f0f0f0; /* Cor de fundo ao passar o mouse */
}

</style>
</head>
<body>
<table width="350" border="0" align="center">
    <tr>
        <td height="50" align="center">
            <table width="350" border="0">
                <tr>
                    <td><a href="areapix.php"><img src="imagens/setay.png" alt="" width="31"></a></td>
                    <td align="right">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table width="100%" border="0">
    <tr></tr>
</table>
<table width="350" border="0" align="center">
    <tr>
        <td>
            <form name="form1" method="post" action="pix_escolhido.php">
                <table width="350" border="0" align="center">
                    <tr>
                        <td height="50" align="left">
                            <span class="icon2" style="font-size: 26px; color: #333;">
                                Para quem você quer transferir R$ <?php echo htmlspecialchars($valor); ?>?
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td height="70" align="left" valign="middle">
                            <span class="icon3" style="font-size: 18px; color: #666; letter-spacing: -0.5px;">
                                <b>Encontre um contato</b> na sua lista ou inicie uma <b>nova transferência</b>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="bottom">
                            <input name="chave" placeholder="Nome, CPF/CNPJ ou chave Pix" type="text" class="valorx" id="chave" maxlength="100" size="20">

                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <hr noshade="noshade" class="linha">
                        </td>
                    </tr>
                    <tr>
                        <td height="120" align="left" valign="top" style="font-size: 20px; color: #333;"><BR><script>
document.addEventListener("DOMContentLoaded", function() {
    var chaves = <?php echo $chavesJson; ?>;
    var chaveLista = document.querySelector(".chave-lista");

    chaves.forEach(function(chave) {
        var div = document.createElement("div");
        div.className = "chave-item";
        div.textContent = chave;
        div.setAttribute("data-chave", chave);
        chaveLista.appendChild(div);
    });

    function preencherChave(chave) {
        document.getElementById("chave").value = chave;
    }

    chaveLista.addEventListener("click", function(event) {
        var item = event.target;
        if (item.classList.contains("chave-item")) {
            preencherChave(item.getAttribute("data-chave"));
        }
    });
});
</script>
<div class="chave-lista"></div></td>
                    </tr>
                    <tr>
                      <td height="124" align="center" valign="bottom"><input name="button" type="submit" class="botaoentrar" id="button" value="Transferir"></td>
                    </tr>
                </table>
                <div hidden="">
                    <input name="valor" type="text" class="valorx" id="valor" placeholder="Valor da transferência" value="<?php echo htmlspecialchars($valor); ?>" size="35" maxlength="35">
                    <br>
                </div>
            </form>
        </td>
    </tr>
</table>
</body>
</html>
