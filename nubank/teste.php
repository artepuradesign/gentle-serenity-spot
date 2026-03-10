<?php
session_start();
include_once 'conexaoatualizada.php';

// Verificação da sessão do usuário
if (!isset($_SESSION['id'])) {
    header("refresh:2;url=login.php");
    exit;
}

if (!isset($_SESSION['cpf'])) {
    exit('Usuário não autenticado');
}

// Conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senhadb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit('Erro na conexão com o banco de dados');
}

// Função para verificar transferências
function verificarTransferencias($pdo, $cpf)
{
    $query = "SELECT id_trans, orinome, valor FROM transferencias WHERE destinocpf = :destinocpf AND lida = 0";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':destinocpf', $cpf);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $resultados;
}

// Função para marcar transferências como lidas
function marcarTransferenciasComoLidas($pdo, $ids)
{
    if (!empty($ids)) {
        $ids = json_decode($ids, true); // Decodificar IDs JSON
        $idsPlaceholder = implode(',', array_fill(0, count($ids), '?'));
        $atualizarQuery = "UPDATE transferencias SET lida = 1 WHERE id_trans IN ($idsPlaceholder)";
        $atualizarStmt = $pdo->prepare($atualizarQuery);

        try {
            $atualizarStmt->execute($ids);
        } catch (Exception $e) {
            error_log('Erro ao marcar transferências como lidas: ' . $e->getMessage());
        }
    } else {
        error_log('Nenhum ID de transferência fornecido.');
    }
}

// Verifica se é uma chamada AJAX para verificar transferências
if (isset($_GET['action']) && $_GET['action'] === 'verificar') {
    $transferencias = verificarTransferencias($pdo, $_SESSION['cpf']);
    header('Content-Type: application/json');
    echo json_encode($transferencias);
    exit;
}

// Verifica se é uma chamada AJAX para marcar transferências como lidas
if (isset($_POST['action']) && $_POST['action'] === 'marcar_lidas') {
    $ids = $_POST['ids'] ?? [];
    marcarTransferenciasComoLidas($pdo, $ids);
    exit;
}

// Obter transferências inicialmente (ao carregar a página)
$transferencias = verificarTransferencias($pdo, $_SESSION['cpf']);
$idsTransferencias = array_column($transferencias, 'id_trans');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Transferência</title>
    <style>
        .mensagem-transferencia {
            font-size: 12px;
            display: none;
            position: fixed;
            top: 0;
            left: 5%;
            transform: translateX(-3%);
            z-index: 9999;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .rounded-table {
            font-size: 12px;
            border-collapse: collapse;
            border-radius: 15px;
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.95);
            width: 100%;
        }

        .rounded-table td {
            padding: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <audio id="audio-transferencia" src="som.mp3" type="audio/mpeg"></audio>
</head>
<body>
    <div id="mensagem-transferencia" class="mensagem-transferencia"></div>

    <script>
        $(document).ready(function () {
            // Função para exibir a tabela de transferência
            async function exibirTabelaTransferencia(remetente, valorTransferencia, ids) {
                return new Promise((resolve) => {
                    var formatarValor = function (valor) {
                        return parseFloat(valor).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    };

                    var valorFormatado = formatarValor(valorTransferencia);
                    var tabelaTransferencia = `
                        <br><table class="rounded-table" width="100%" border="0" align="center">
                          <tr>
                            <td align="center"><img src="icone.png" width="30" height="30" /></td>
                            <td width="85%"><b>Transferência recebida</b> <br />
                            Você recebeu uma transferência de ${valorFormatado} de ${remetente}</td>
                          </tr>
                        </table>
                    `;
                    $('#mensagem-transferencia').html(tabelaTransferencia);
                    $('#mensagem-transferencia').show();
                    $('#audio-transferencia')[0].play();

                    setTimeout(function () {
                        $('#mensagem-transferencia').hide();
                        resolve(); // Resolve a promise quando a mensagem desaparece
                    }, 8000);
                }).then(() => {
                    // Atualizar transferências como lidas após a mensagem ser escondida
                    $.ajax({
                        url: 'teste.php',
                        method: 'POST',
                        contentType: 'application/x-www-form-urlencoded',
                        data: { action: 'marcar_lidas', ids: JSON.stringify(ids) },
                        success: function () {
                            console.log('Transferências marcadas como lidas.');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('Erro ao marcar transferências como lidas: ' + textStatus + ' - ' + errorThrown);
                        }
                    });
                });
            }

            // Função para verificar transferências
            function verificarTransferencias() {
                $.ajax({
                    url: 'teste.php?action=verificar',
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (Array.isArray(response) && response.length > 0) {
                            response.forEach(async function (item) {
                                await exibirTabelaTransferencia(item.orinome, item.valor, [item.id_trans]);
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Erro ao verificar transferências: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }

            // Iniciar a verificação 2 segundos após a página ser carregada
            setTimeout(function () {
                verificarTransferencias();

                // Verificar transferências a cada 10 segundos
                setInterval(verificarTransferencias, 10000);
            }, 2000);

            // Exibir mensagens de transferência existentes ao carregar a página
            <?php foreach ($transferencias as $transferencia) { ?>
                exibirTabelaTransferencia('<?php echo $transferencia['orinome']; ?>', <?php echo $transferencia['valor']; ?>, [<?php echo $transferencia['id_trans']; ?>]);
            <?php } ?>
        });
    </script>
    <!-- Meta refresh para recarregar a página a cada 10 segundos -->
    <meta http-equiv="refresh" content="20">
</body>
</html>
