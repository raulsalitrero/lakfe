$(function(){
	var currentYear = (new Date).getFullYear();
	$('#lb_anio').text(currentYear);
	$('#tx_email').focus();
	
	$(document).on('change', '#tx_email', function() {		
		var v_usu = $.trim($('#tx_email').val());	
		
		var v_arroba = v_usu.lastIndexOf('@');
		v_usu = v_usu.substring(0,v_arroba);
		
		$('#tx_usuario').val(v_usu);
	});
	
	$(document).on('click', '#bt_registrar', function() {
		var v_email = $.trim($('#tx_email').val());
		var v_usuario = $.trim($('#tx_usuario').val());
		var v_clave = $.trim($('#tx_clave').val());
		var v_confirmar = $.trim($('#tx_confirmar').val());
		
		if(v_email == '') {
			alert('Correo no valido!!!');
			
			$('#tx_email').focus().select();
		} else if(v_usuario == ''){
			alert('Usuario no valido!!!');
			
			$('#tx_usuario').focus().select();
		} else if((v_clave == '') || (v_confirmar == '')){
			alert('Clave no valida!!!');
			
			$('#tx_clave').focus().select();
		} else if(v_clave != v_confirmar){
			alert('Las claves no son iguales!!!');
			
			$('#tx_clave').focus().select();
		} else {
			$.post("php_controladores/maneja_registro.php", {
				usuario: v_usuario,
				correo: v_email,
				clave : v_clave
			}, function(data) {
				if (!data.err) {
					alert('Se guardo correctamente!!!');
					
					window.location.href = 'index.php';
				}else{
					alert(data.msg);
				}
			},"json");
		}
	});
	
	$(document).on('click', '#a_salir', function() {
		window.location.href = 'index.php';
	});
});