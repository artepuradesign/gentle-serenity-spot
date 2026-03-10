<footer> <center>
    <div class="footer-content">
        <div class="footer-social">
<div>
<?php
$tamanhomargem = 20;
$tamanhoicones = 50;
?>
        <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($link_completo); ?>" target="_blank" title="Compartilhar no WhatsApp"><i class="fab fa-whatsapp" style="color: #25D366; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>;"></i></a><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($link_completo); ?>" target="_blank" title="Compartilhar no Facebook"><i class="fab fa-facebook" style="color: #3b5998; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>;"></i></a><a href="https://t.me/share/url?url=<?php echo urlencode($link_completo); ?>" target="_blank" title="Compartilhar no Telegram"><i class="fab fa-telegram" style="color: #0088cc; margin-right:<?php echo $tamanhomargem; ?>; font-size: <?php echo $tamanhoicones; ?>;"></i></a><br><br></div></div></div></center>
</footer> 