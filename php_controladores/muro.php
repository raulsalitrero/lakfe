<?php
include_once("../php_lib/comun.php");
include_once("../php_lib/cnn.php");
include_once("../php_lib/HTMLPurifier.standalone.php");
error_reporting(-1);
iniciasesion();
if(!isset($_SESSION['usuarioid'])){
	die('{"err":true,"msg":"Se Perdio la Sesion, Vuelva a Entrar"}');
}
$postear = false;
if (is_string($met = $_SERVER["REQUEST_METHOD"])) {
    if ($met == "POST") {
        $postear = true;
    }
}
/* @var $mysqli mysqli */

ob_start();
if($postear){
	$usuarioid = intval($_SESSION['usuarioid']);
	$ret = array();
	$valido = true;
	$ret["err"] = false;

	$texto = postVar("texto",null);
	$texto = empty($texto) ? false: $texto;
	$geo = postVar("geo","");
	$foto = postVar("foto","");
	$tienefoto = ($foto !== "") ? 1 : 0;
	if($texto === false){
		$ret["err"] = true;
		$ret["msg"] = "Falta El Mensaje";
		$valido = false;
	}
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	$texto = $purifier->purify($texto);
	if(trim($texto) === ""){
		$ret["err"] = true;
		$ret["msg"] = "Falta El Mensaje";
		$valido = false;
	}

	$texto = $mysqli->real_escape_string($texto);
	$geo = $mysqli->real_escape_string($geo);
	if($valido){
		$sql = <<<EOQ
		   
		INSERT INTO `firefox`.`posts` 
		    (`texto`, 
		    `fecha`, 
		    `usuarioId`, 
		    `tienefoto`, 
		    `geo`)
		    VALUES
		    ('$texto', 
		    now(), 
		    $usuarioid, 
		    $tienefoto, 
		    '$geo')
EOQ;

		$id = false;
	    if (!$res = $mysqli->query($sql)) {
	        $ret["msg"] = $mysqli->error;
	        $ret["err"] = true;
	        $valido = false;
	    }else{
	    	$id = $mysqli->insert_id;
	    }
	}

	if($valido && $foto !== ""){
		$encodedData = str_replace(' ','+',$foto);
		$decodedData = base64_decode($encodedData);
		$fp = fopen("../fotos/post_".$id.".jpg", 'w');
		fwrite($fp, $decodedData);
		fclose($fp);
	}
}else{
	$sql = <<<eoq
			SELECT
			usuario,
			texto, 
			DATE_FORMAT(fecha, '%e/%b/%Y a las %k:%i') AS fecha, 
			posts.usuarioId AS usuarioid, 
			tienefoto, 
			geo,
			id
			FROM posts INNER JOIN usuarios ON usuarios.usuarioid=posts.usuarioid
			ORDER BY fecha DESC LIMIT 100
eoq;
	if(!$resu = $mysqli->query($sql)){
		$ret["msg"] = $mysqli->error;
		$ret["err"] = true;
	    $valido = false;
	}
	$resultados = array();
	while ($datos = $resu->fetch_object()) {
		$dato = array();
		$dato['usuario'] = limpiar($datos->usuario);
		$dato['texto'] = limpiar($datos->texto);
		$dato['fecha'] = limpiar($datos->fecha);
		$dato['usuarioid'] = limpiar($datos->usuarioid);
		$dato['tienefoto'] = limpiar($datos->tienefoto);
		$dato['geo'] = limpiar($datos->geo);
		$dato['postid'] = limpiar($datos->id);
		$geo = $dato['geo'];
		$geo = @json_decode($geo);
		$dato['geo'] = $geo;
		$dato['tienefoto'] = $dato['tienefoto'] > 0;
		$resultados[] = $dato;
	}
	$ret["msg"] = "ok";
	$ret["err"] = false;
	$ret["datos"] = $resultados;
}
ob_end_clean();
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($ret);