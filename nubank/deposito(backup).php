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
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Saldo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
			margin-TOP: 10px;
			margin-bottom: 10px;


        }
        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 350px;
            width: 100%;
            box-sizing: border-box;
        }
        h2 {
            margin-top: 0;
            color: #333;
        }
        form {
            display: grid;
            gap: 15px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background: #4CAF50;
            color: #fff;
            border: none;
            padding: 15px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Adicionar Saldo</h2>
      <form action="depositar.php" method="POST" >
        <label for="cliente_id" readonly style="display: none;">ID do Cliente:</label>
            <input type="text" name="cliente_id" id="cliente_id" value="<?php echo $_SESSION['id']; ?>" readonly style="display: none;">
            
        <label for="valor">Valor do Depósito:</label>
            <input type="number" name="valor" id="valor" step="0.01" required>

        <label for="destinonome" readonly style="display: none;">Nome do Destinatário:</label>
        <input name="destinonome" type="text" readonly style="display: none;" required id="destinonome" value="<?php echo $_SESSION['nome']; ?> <?php echo $_SESSION['sobrenome']; ?>">
            
        <label for="destinocpf" readonly style="display: none;">CPF do Destinatário:</label>
        <input name="destinocpf" type="text" required id="destinocpf" readonly style="display: none;" value="<?php echo $_SESSION['cpf']; ?>">

        <label for="destinoinstitu" readonly style="display: none;">Instituição do Destinatário:</label>
        <input name="destinoinstitu" type="text" required id="destinoinstitu" readonly style="display: none;" value="NU PAGAMENTOS - IP">

        <label for="destinoagencia" readonly style="display: none;">Agência do Destinatário:</label>
        <input name="destinoagencia" type="text" required id="destinoagencia" readonly style="display: none;" value="0001">

        <label for="destinoconta" readonly style="display: none;">Conta do Destinatário:</label>
        <input name="destinoconta" type="text" required id="destinoconta" value="<?php echo $_SESSION['conta']; ?>" readonly style="display: none;">

            <label for="orinome">Nome da Origem:</label>
            <input name="orinome" type="text" required id="orinome" value="Okto Pagamentos S.A.">

        <label for="oriinstituicao">Instituição da Origem:</label>
            <select name="oriinstituicao" class="selecionados" id="oriinstituicao">
<option selected="selected">Bancos</option>
<option value="Banco do Brasil">Banco do Brasil</option>
<option value="BCO BRASIL">Banco do Brasil</option>
<option value="ITAU">Itaú Unibanco</option>
<option value="BRADESCO">Bradesco</option>
<option value="CAIXA">Caixa Econômica Federal</option>
<option value="SANTANDER">Santander Brasil</option>
<option value="BTG PACTUAL">BTG Pactual</option>
<option value="BANCO ORIGINAL">Banco Original</option>
<option value="BANRISUL">Banrisul</option>
<option value="SICOOB">Sicoob</option>
<option value="BANCO INTER">Banco Inter</option>
<option value="NUBANK">Nubank</option>
<option value="Safra">Banco Safra</option>
<option value="BANCO DO NORDESTE">Banco do Nordeste</option>
<option value="C6 BANK">C6 Bank</option>
<option value="BANCO PAN">Banco Pan</option>
<option value="BCO BMG">Banco BMG</option>
<option value="PAGSEGURO INTERQNET IP S.A">PagSeguro</option>
<option value="BANCO SANTANDER BRASIL">Banco Santander Brasil</option>
<option value="BANCO VOTORANTIM">Banco Votorantim</option>
<option value="BANCO DAYCOVAL">Banco Daycoval</option>
<option value="BANCO CREDIT SUISSE">Banco Credit Suisse</option>
<option value="BANCO SANTOS">Banco Santos</option>
<option value="BANCO ALFA">Banco Alfa</option>
<option value="BANCO ABC BRASIL">Banco ABC Brasil</option>
<option value="BANCO PANAMERICANO">Banco Panamericano</option>
<option value="BANCO INDUSVAL">Banco Indusval</option>
<option value="BANCO RURAL">Banco Rural</option>
<option value="BANCO CCB BRASIL">Banco CCB Brasil</option>
<option value="BANCO TRICURY">Banco Tricury</option>
<option value="BANCO CARREFOUR">Banco Carrefour</option>
<option value="BANCO SEMEAR">Banco Semear</option>
<option value="CITIBANK">Citibank Brasil</option>
<option value="BANCO PINE">Banco Pine</option>
<option value="BANCO FIBRA">Banco Fibra</option>
<option value="BANCO SOFISA">Banco Sofisa</option>
<option value="BANCO VOLKSWAGEN">Banco Volkswagen</option>
<option value="BANCO BONSUCESSO">Banco Bonsucesso</option>
<option value="BANCO PAULISTA">Banco Paulista</option>
<option value="BANCO NEON">Banco Neon</option>
<option value="BANCO J. SAFRA">Banco J. Safra</option>
<option value="BANCO MODAL">Banco Modal</option>
<option value="BANCO MATONE">Banco Matone</option>
<option value="BANCO SAFRA PESSOAL">Banco Safra Pessoal</option>
<option value="BANCO A.J. RENNER">Banco A.J. Renner</option>
<option value="BANCO TOPÁZIO">Banco Topázio</option>
<option value="BANCO ARBI">Banco Arbi</option>
<option value="BANCO FINASA">Banco Finasa</option>
<option value="BANCO PROSPER">Banco Prosper</option>
<option value="BANCO DA AMAZÔNIA">Banco da Amazônia</option>
<option value="BANCO FIBRA">Banco Fibra</option>
<option value="BANCO FICSA">Banco Ficsa</option>
<option value="BANCO 3M">Banco 3M</option>
<option value="BANCO AGIBANK">Banco Agibank</option>
<option value="BANCO ALVORADA">Banco Alvorada</option>
<option value="BANCO ATIVA">Banco Ativa</option>
<option value="BANCO AZTECA">Banco Azteca</option>
<option value="BANCO BAI EUROPA">Banco BAI Europa</option>
<option value="BANCO BANERJ">Banco Banerj</option>
<option value="BANCO BARIGUI">Banco Barigui</option>
<option value="BANCO BARI">Banco Bari</option>
<option value="BANCO BASE">Banco Base</option>
<option value="BANCO BBM">Banco BBM</option>
<option value="BANCO BCO">Banco BCO</option>
<option value="BANCO BDA">Banco BDA</option>
<option value="BANCO BMJ">Banco BMJ</option>
<option value="BANCO BONSUCESSO CONSIGNADO">Banco Bonsucesso Consignado</option>
<option value="BANCO BOREAL">Banco Boreal</option>
<option value="BANCO BRASCAN">Banco Brascan</option>
<option value="BANCO BS2">Banco BS2</option>
<option value="BANCO BTG PACTUAL DIGITAL">Banco BTG Pactual Digital</option>
<option value="BANCO BVA">Banco BVA</option>
<option value="BANCO BVA CONSIGNADO">Banco BVA Consignado</option>
<option value="BANCO CACIQUE">Banco Cacique</option>
<option value="BANCO CACIQUE CONSIGNADO">Banco Cacique Consignado</option>
<option value="BANCO CAIXA GERAL BRASIL">Banco Caixa Geral Brasil</option>
            <option value="BANCO CARGILL">Banco Cargill</option>
            <option value="BANCO CIFRA">Banco Cifra</option>
            <option value="BANCO CITIBANK">Banco Citibank</option>
            <option value="BANCO CONFIDENCE">Banco Confidence</option>
            <option value="BANCO COOP">Banco Coop</option>
            <option value="BANCO CSF">Banco CSF</option>
            <option value="BANCO CÉDULA">Banco Cédula</option>
            <option value="BANCO DAIMLER">Banco Daimler</option>
            <option value="BANCO DIGIMAIS">Banco Digimais</option>
            <option value="BANCO DME">Banco DME</option>
            <option value="BANCO DO VALE">Banco do Vale</option>
            <option value="BANCO DUCTOR">Banco Ductor</option>
            <option value="BANCO FATOR">Banco Fator</option>
            <option value="BANCO FIDIS">Banco Fidis</option>
            <option value="BANCO FORD">Banco Ford</option>
            <option value="BANCO GMAC">Banco GMAC</option>
            <option value="BANCO GUANABARA">Banco Guanabara</option>
            <option value="BANCO HONDA">Banco Honda</option>
            <option value="BANCO HYUNDAI">Banco Hyundai</option>
            <option value="BANCO INDUSTRIAL">Banco Industrial</option>
            <option value="BANCO INTERCAP">Banco Intercap</option>
            <option value="BANCO INTERMEDIUM">Banco Intermedium</option>
            <option value="BANCO ITAÚ BBA">Banco Itaú BBA</option>
            <option value="BANCO ITAÚ BANK">Banco Itaú Bank</option>
            <option value="BANCO ITAÚ CONSIGNADO">Banco Itaú Consignado</option>
            <option value="BANCO ITAÚ VEÍCULOS">Banco Itaú Veículos</option>
            <option value="BANCO ORIGINAL">Banco Original</option>
            <option value="BANCO PAN">Banco Pan</option>
            <option value="BANCO PANAMERICANO">Banco Panamericano</option>
            <option value="BANCO PARMER">Banco Parmer</option>
            <option value="BANCO PAULISTA">Banco Paulista</option>
            <option value="BANCO PEUGEOT">Banco Peugeot</option>
            <option value="BANCO PHOENIX">Banco Phoenix</option>
            <option value="BANCO PINHEIRO">Banco Pinheiro</option>
            <option value="BANCO PINE">Banco Pine</option>
            <option value="BANCO PLURAL">Banco Plural</option>
            <option value="BANCO POLIBANK">Banco Polibank</option>
            <option value="BANCO PORTO SEGURO">Banco Porto Seguro</option>
            <option value="BANCO POTTENCIAL">Banco Pottencial</option>
            <option value="BANCO PSA FINANCE">Banco PSA Finance</option>
            <option value="BANCO RCI BRASIL">Banco RCI Brasil</option>
            <option value="BANCO RENDIMENTO">Banco Rendimento</option>
            <option value="BANCO RIO">Banco Rio</option>
            <option value="BANCO RIO GRANDE">Banco Rio Grande</option>
            <option value="BANCO RODOBENS">Banco Rodobens</option>
            <option value="BANCO RURAL">Banco Rural</option>
            <option value="BANCO SABEMI">Banco Sabemi</option>
            <option value="BANCO SAFRA">Banco Safra</option>
            <option value="BANCO SANTANDER">Banco Santander</option>
            <option value="BANCO SEMEAR">Banco Semear</option>
            <option value="BANCO SICREDI">Banco Sicredi</option>
            <option value="BANCO SIMPLES">Banco Simples</option>
            <option value="BANCO SOFISA">Banco Sofisa</option>
            <option value="BANCO SOCINAL">Banco Socinal</option>
            <option value="BANCO SOFITASA">Banco Sofitasa</option>
            <option value="BANCO TABOÃO">Banco Taboão</option>
            <option value="BANCO TECNICRED">Banco Tecnicred</option>
            <option value="BANCO TOYOTA">Banco Toyota</option>
            <option value="BANCO TRICURY">Banco Tricury</option>
            <option value="BANCO TRIANGULO">Banco Triângulo</option>
            <option value="BANCO UBS">Banco UBS</option>
            <option value="BANCO UBS BRASIL">Banco UBS Brasil</option>
            <option value="BANCO UNICRED">Banco Unicred</option>
            <option value="BANCO UNICRED CONSIGNADO">Banco Unicred Consignado</option>
            <option value="BANCO UNICRED VEÍCULOS">Banco Unicred Veículos</option>
            <option value="BANCO UNICRED NORTE DO PARANÁ">Banco Unicred Norte do Paraná</option>
            <option value="BANCO UNICRED RS">Banco Unicred RS</option>
            <option value="BANCO UNIPRIME">Banco Uniprime</option>
            <option value="BANCO UNITED">Banco United</option>
            <option value="BANCO UNIVERSAL">Banco Universal</option>
            <option value="BANCO V MOTOR">Banco V Motor</option>
            <option value="BANCO VIPS">Banco Vips</option>
            <option value="BANCO VOLKSWAGEN">Banco Volkswagen</option>
            <option value="BANCO VR">Banco VR</option>
            <option value="BANCO WEEL">Banco Weel</option>
            <option value="BANCO WIDE">Banco Wide</option>
            <option value="BANCO WINBANK">Banco Winbank</option>
            <option value="BANCO YAMAHA">Banco Yamaha</option>
            <option value="BANCO YAMAHA VEÍCULOS">Banco Yamaha Veículos</option>
            <option value="BANCO YAMAHA WOORI">Banco Yamaha Woori</option>
            <option value="BANCO YARA">Banco Yara</option>
            <option value="BANCO YUHO">Banco Yuho</option>
            <option value="BANCO ZEMA">Banco Zema</option>
            <option value="BANCO ZOGBI">Banco Zogbi</option>
            <option value="BANCO AME DIGITAL">Banco AME</option>
    </select>

        <label for="oriagencia">Agência da Origem:</label>
            <input name="oriagencia" type="text" required id="oriagencia" value="0001">

        <label for="oriconta" readonly style="display: none;">Conta da Origem:</label>
        <input name="oriconta" type="text" required id="oriconta" readonly style="display: none;" value="142536">

        <label for="oricpf">CPF da Origem:</label>
            <input type="text" name="oricpf" id="oricpf" value="<?php echo $_SESSION['cpf']; ?>">
        <label for="oricpf" readonly style="display: none;">Data:</label>
        <input type="text" name="data" id="data" value="<?php $data_atual = date("d/m/Y");
echo $data_atual; ?>" readonly style="display: none;">
        <label for="oricpf" readonly style="display: none;">Hora:</label>
        <input type="text" name="hora" id="hora" value="<?php $hora_atual = date("H:i:s");
echo $hora_atual;
 ?>" readonly style="display: none;">

        <button type="submit">Depositar</button>
      </form>
    </div>
</body>
</html>
