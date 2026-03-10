<?php include 'configuracao.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="icone.png" />
<title>Nubank</title>
<style type="text/css">
body {
	background-color: #820AD1;
	text-align: center;
}
<style>
  html, body {
    margin: 0;
    padding: 0;
    overflow: hidden;
  }

  #fullscreen-iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
  }
</style>
</head>
<center>
<body>
  <iframe id="fullscreen-iframe" src="<php echo $link ?>"></iframe>
</body></center>
</html>
