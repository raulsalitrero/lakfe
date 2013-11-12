<?php
include_once("../php_lib/comun.php");
include_once("../php_lib/cnn.php");

/* @var $mysqli mysqli */

ob_start();
$correo = postVar("correo",false);
$usuario = postVar("usuario",false);
$password = postVar("clave",false);
$valido=true;
$ret=array();
if($correo !== false && $usuario !== false && $password !== false){
	$correo = $mysqli->real_escape_string($correo);
	$usuario = $mysqli->real_escape_string($usuario);
	$password = $mysqli->real_escape_string($password);
	$resu = $mysqli->query("select usuario, usuarioID as usuarioid from usuarios where ".
		"(lower(trim(usuario)) = lower(trim('$usuario')) or lower(trim('$correo')) = lower(trim(email))) ");
	if($resu !== false){
		if($resu->num_rows > 0){
			$datos = $resu->fetch_object();

			$ret["err"] = true;
			$ret["msg"] = "El usuario o correo ya existe!!!";			
			
			iniciasesion();
			session_write_close();
		}else{
			$ret["err"] = false;
			$ret["msg"] = "ok";
			
			$sql = <<<EOQ
				
		INSERT INTO `firefox`.`usuarios` 
			(`usuario`, 
			`email`,
			`clave`)
			VALUES
			(?, ?, md5(concat('lacafe_12345678910',?)))
EOQ;

		if (!$query = $mysqli->prepare($sql)) {
			$ret["msg"] = $mysqli->error;
			$valido = false;
		}
		
		if ($valido) {
			if (!$query->bind_param("sss", trim($usuario), trim($correo), trim($password))) {
				$ret["msg"] = $query->error;
				$valido = false;
			}
		}
			if ($valido) {
				if (!$query->execute()) {
					$ret["msg"] = $query->error;
					$valido = false;
				}
			}
			if ($valido) {
				$ret["msg"] = "ok";
				$ret["err"] = false;
			}
		}
	}else{
		$ret["err"] = true;
		$ret["msg"] = $mysqli->error;
	}
}else{
	$ret["err"] = true;
	$ret["msg"] = "No se obtuvieron los parametros";
}

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: text/html');
ob_end_clean();
echo json_encode($ret);
