<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'conexaoatualizada.php';
$usuario_id = !empty($_SESSION['id']) ? $_SESSION['id'] : 26;
$link_completo = "https://svrsrs.com/nubank/cadastrar.php?ref=" . $usuario_id;
$codigo_referencia = $usuario_id;
?><style>
        .containerx {
	font-family: Arial, sans-serif;
	margin: 20px;
	padding: 20px;
	border: 1px solid #ccc;
	border-radius: 8px;
	background-color: #f9f9f9;
	max-width: 700px;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
	background-position: center;
        }
        .link-box {
            display: flex;
            align-items: center;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
        }
        .link-box input {
            border: none;
            background: none;
            width: 100%;
            font-size: 14px;
            color: #333;
            outline: none;
        }
        .link-box button {
	background-color: #3F1875;
	color: white;
	border: none;
	padding: 8px 12px;
	border-radius: 4px;
	cursor: pointer;
	transition: background-color 0.3s;
        }
        .link-box button:hover {
            background-color: #45a049;
        }
        .link-box button:active {
            transform: scale(0.98);
        }
        .success-message {
            color: #28a745;
            margin-top: 10px;
            display: none;
            font-weight: bold;
        }
        .share-icons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .share-icons a {
            text-decoration: none;
            font-size: 24px;
            color: #555;
            transition: color 0.3s;
        }
        .share-icons a:hover {
            color: #000;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<center>
<?php
$tamanhoicones = "35px"; // Defina o tamanho desejado aqui
$tamanhomargem = "10px"; // Defina o tamanho desejado aqui
?>
<div class="containerx">
    <div class="link-box">
        <!-- Mostrar apenas o código -->
        <input type="text" id="refLinkDisplay" value="<?php echo $codigo_referencia; ?>" size="5" readonly>
        <button onclick="copyToClipboard()">x</button>
    </div>
    <div id="successMessage" class="success-message">Link copiado com sucesso!</div>

    <div class="share-icons">
        <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($link_completo); ?>" target="_blank" title="Compartilhar no WhatsApp">
            <i class="fab fa-whatsapp" style="color: #25D366; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>;"></i>
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($link_completo); ?>" target="_blank" title="Compartilhar no Facebook">
            <i class="fab fa-facebook" style="color: #3b5998; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>;"></i>
        </a>
<a href="https://t.me/share/url?url=<?php echo urlencode($link_completo); ?>" target="_blank" title="Compartilhar no Telegram">
    <i class="fab fa-telegram" style="color: #0088cc; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>;"></i>
</a>
        <a href="mailto:?subject=Confira este link&body=Veja este link: <?php echo urlencode($link_completo); ?>" target="_blank" title="Enviar por Email">
            <i class="fas fa-envelope" style="color: #DD4B39; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>; "></i>
        </a>
        <a href="#" onclick="copyToClipboard()" title="Copiar Link">
            <i class="fas fa-copy" style="color: #f0ad4e; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>;"></i>
        </a>
    </div>
</div></center>
<script>
    function copyToClipboard() {
        var fullLink = "<?php echo $link_completo; ?>";
        var tempInput = document.createElement("input");
        tempInput.value = fullLink;
        document.body.appendChild(tempInput);
        tempInput.select();
        tempInput.setSelectionRange(0, 99999);
        document.execCommand("copy");
        document.body.removeChild(tempInput);

        var successMessage = document.getElementById("successMessage");
        successMessage.style.display = "block";

        setTimeout(function() {
            successMessage.style.display = "none";
        }, 3000);
    }
</script>