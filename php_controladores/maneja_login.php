<?php
include_once("../php_lib/comun.php");
include_once("../php_lib/cnn.php");

/* @var $mysqli mysqli */

ob_start();
$usuario = getVar("usuario",false);
$password = getVar("password",false);
$valido=true;
$ret=array();
if($usuario !== false && $password !== false){
	$usuario = $mysqli->real_escape_string($usuario);
	$password = $mysqli->real_escape_string($password);
	$resu = $mysqli->query("select usuario, usuarioID as usuarioid from usuarios where esta = 'A' and ".
		"(lower(trim(usuario)) = lower(trim('$usuario')) or lower(trim('$usuario')) = lower(trim(email))) ".
		" and clave = md5(concat('lacafe_12345678910','$password')) ");
	if($resu !== false){
		if($resu->num_rows > 0){
			$datos = $resu->fetch_object(); 
			$ret["err"] = false;
			$ret["msg"] = "ok";
			iniciasesion();
			$_SESSION['usuario'] = $datos->usuario;
			$_SESSION['usuarioid'] = $datos->usuarioid;
			session_write_close();
		}else{
			$ret["err"] = true;
			$ret["msg"] = "login incorrecto, verificar";
		}
	}else{
		$ret["err"] = true;
		$ret["msg"] = $mysqli->error;
	}
}else{
	$ret["err"] = true;
	$ret["msg"] = "login incorrecto, verificar";
}

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: text/html');
ob_end_clean();
echo json_encode($ret);
