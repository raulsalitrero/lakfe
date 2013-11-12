<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<title>Registro</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.3.2.min.css">
	<link rel="stylesheet" href="css/registro.css">
	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.mobile-1.3.2.min.js"></script>  
	<script type="text/javascript" src="js/registro.js"></script>  
</head>
<body>
<!-- Home -->
<div data-role="page" id="page1">
    <div data-theme="a" data-role="header">
        <h3>
            Registrar en La Kfe
        </h3>
    </div>
	 <div style="padding:10px; height:70px; text-align:center;">
            <img src="images/Users-Add-user-icon.png" alt="image">
        </div>
    <div data-role="content">
        <div data-role="fieldcontain">
            <label for="tx_email">
                Email:
            </label>
            <input name="" id="tx_email" placeholder="Correo electronico" value=""
            type="email">
        </div>
        <div data-role="fieldcontain">
            <label for="tx_usuario">
                Usuario:
            </label>
            <input name="" id="tx_usuario" placeholder="Nombre de usuario" value=""
            type="text">
        </div>
        <div data-role="fieldcontain">
            <label for="tx_clave">
                Clave:
            </label>
            <input name="" id="tx_clave" placeholder="" value="" type="password">
        </div>
		<div data-role="fieldcontain">
            <label for="tx_clave">
                Confirmar clave:
            </label>
            <input name="" id="tx_confirmar" placeholder="" value="" type="password">
        </div>
        <input data-theme="b" data-icon="plus" data-iconpos="right" value="Registrar"
        type="button" id="bt_registrar">
       
    </div>
	<?php include("inc/footer.php"); ?>
</div>
</body>
</html>
