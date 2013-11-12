<?php
    ini_set("error_reporting", -1);
    ini_set("display_error", -1);
    error_reporting(-1);
	include("php_lib/comun.php");
    iniciasesion();
    destruirsesion();
	$_SESSION = array();
?>
<!DOCTYPE html>
<html>
<!--
    Exchange the line above for this to enable offline support
    <html manifest="manifest.appcache">

    Please make your homework before doing this:
        http://www.alistapart.com/articles/application-cache-is-a-douchebag/
        http://appcachefacts.info

    This might be necessary to set up on your server, to make sure
    files are updated when the appcache file itself is:
        https://github.com/robnyman/Firefox-OS-Boilerplate-App/blob/gh-pages/.htaccess
 -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.3.2.min.css">
	<link rel="stylesheet" type="text/css" href="css/codiqa.ext.css">
    <title>La Cafe</title>
	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.mobile-1.3.2.min.js"></script>    
    <script type="text/javascript" src="js/manejador.js"></script>
    <script type="text/javascript" src="js/codiqa.ext.js"></script>
    <base target="_blank">
</head>

<body>
<div data-role="page" id="page1">
    <div data-theme="a" data-role="header">
        <h3 id="dv_lacafe">
            La Kfe 1.0
        </h3>
    </div>
    <div data-role="content">
        <div style="" class="logos">
            <img id="im_logo" src="images/coffee.png">
        </div>
        <div data-role="fieldcontain">
            <label for="tx_usuario">
                Usuario:
            </label>
            <input name="" id="tx_usuario" placeholder="Usuario o correo" value="" type="text">
        </div>
        <div data-role="fieldcontain">
            <label for="tx_clave">
                Clave:
            </label>
            <input name="" id="tx_clave" placeholder="" value="" type="password">
        </div>
		<input data-theme="b" data-icon="plus" data-iconpos="right" value="Entrar"
        type="button" id="bt_entrar">
		<div style="text-align:center; padding:8px;">
			<a href="#nada" id="a_registro">No tengo usuario - Registrar</a>
		</div>
    </div>
</div>
   
</body>
</html>
