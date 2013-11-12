<?php
function postVar($clave, $defa = null){
	if(isset($_POST[$clave])){
		if(get_magic_quotes_gpc()){
			return stripslashes($_POST[$clave]);
		}else{
			return $_POST[$clave];
		}
	}else{
		return $defa;
	}
}

function getVar($clave, $defa = null){
	if(isset($_GET[$clave])){
		if(get_magic_quotes_gpc()){
			return stripslashes($_GET[$clave]);
		}else{
			return $_GET[$clave];
		}
	}else{
		return $defa;
	}
}

function cookieVar($clave, $defa = null){
	if(isset($_COOKIE[$clave])){
		if(get_magic_quotes_gpc()){
			return stripslashes($_COOKIE[$clave]);
		}else{
			return $_COOKIE[$clave];
		}
	}else{
		return $defa;
	}
}


function limpiar($var){
	if(get_magic_quotes_gpc()){
		return stripslashes($var);
	}else{
		return $var;
	}
}

function destruirsesion($ruta = '/') {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 100000, $ruta);
    }
    session_destroy();
}

function iniciasesion($tiempo = 3600, $nombre = 'SES_CAFE', $ruta = '/') {
    session_set_cookie_params($tiempo, $ruta);
    session_name($nombre);
    session_start();
    // resetear la cookie al cargar la pagina
    if (isset($_COOKIE[$nombre])) {
        setcookie($nombre, $_COOKIE[$nombre], time() + $tiempo, $ruta);
        //header("Set-Cookie: $nombre=" . $_COOKIE[$nombre] . "; Path=$ruta; Max-Age=$tiempo");
    } else {
        setcookie($nombre, session_id(), time() + $tiempo, $ruta);
        //header("Set-Cookie: $nombre=" . session_id() . "; Path=$ruta; Max-Age=$tiempo");
    }
}