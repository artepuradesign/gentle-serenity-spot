<?php
// Verificar se o usuário está logado (exemplo de verificação de sessão)
session_start();
if (!isset($_SESSION['cpf'])) {
  exit('false'); // Se o usuário não estiver logado, retorna 'false'
}

// Conectar ao banco de dados (exemplo de conexão com PDO)
$dbHost = 'localhost';
$dbName = 'database';
$dbUser = 'root';
$dbPass = '';

try {
  $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  exit('false'); // Se houver um erro na conexão com o banco de dados, retorna 'false'
}

// Função para verificar as transferências
function verificarTransferencias() {
  global $pdo;

  // Consultar o banco de dados para verificar se há novas transferências
  $query = "SELECT COUNT(*) as num_transferencias FROM transferencias WHERE destinocpf = :destinocpf AND lida = 0";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':destinocpf', $_SESSION['cpf']);
  $stmt->execute();
  $resultado = $stmt->fetch();

  $num_transferencias = $resultado['num_transferencias'];

  if ($num_transferencias > 0) {
    $atualizarQuery = "UPDATE transferencias SET lida = 1 WHERE destinocpf = :destinocpf AND lida = 0";
    $atualizarStmt = $pdo->prepare($atualizarQuery);
    $atualizarStmt->bindParam(':destinocpf', $_SESSION['cpf']);
    $atualizarStmt->execute();

    return true;
  } else {
    return false;
  }
}

// Verificar as transferências
$transferenciaRecebida = verificarTransferencias();
?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .mensagem-transferencia {
      display: none;
    }
  </style>
  <script>
    $(document).ready(function() {
      // Verificar transferências a cada 2 segundos
      setInterval(verificarTransferencias, 2000);

      function verificarTransferencias() {
        $.ajax({
          url: 'verificar_transferencias.php',
          method: 'GET',
          success: function(response) {
            if (response === 'transferencia recebida') {
              exibirMensagemTransferencia();
            }
          },
          error: function() {
            console.log('Ocorreu um erro na requisição.');
          }
        });
      }

      function exibirMensagemTransferencia() {
        $('#mensagem-transferencia').html('<img src=\'imagens/transf.png\' width=\'100%\' height=\'91\'>');
        $('#mensagem-transferencia').show();
        setTimeout(function() {
          $('#mensagem-transferencia').hide();
        }, 5000); // Exibe a mensagem por 5 segundos (5000 milissegundos)
      }
    });
  </script>
  <div id="mensagem-transferencia" class="mensagem-transferencia"></div>
  <?php
  if ($transferenciaRecebida) {
    echo '<script>exibirMensagemTransferencia();</script>';
  }
  ?>