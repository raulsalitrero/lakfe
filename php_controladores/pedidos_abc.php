<?php
include_once("../php_lib/comun.php");
include_once("../php_lib/cnn.php");

if(!isset($_SESSION['usuarioid'])){
	die('{"err":true,"msg":"Se Perdio la Sesion, Vuelva a Entrar"}');
}

ob_start();
$valido=true;
$ret=array();
if($usuario !== false){
	$usuario = $mysqli->real_escape_string($usuario);
	$resu = $mysqli->query("INSERT INTO pedidos (usuarioID) VALUES (?);"
	
	if($resu !== false){
		if($resu->num_rows > 0){
			$ret["err"] = false;
			$ret["msg"] = "ok";
			iniciasesion();
			$_SESSION['usuario'] = $usuario;
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
