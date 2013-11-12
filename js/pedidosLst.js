$(document).ready(function() {
	$(document).on('click', "#bt_pedidos", function(e) {
		e.preventDefault();
		location.href = "pedidos.php";
	});
	
	$(document).on('click', '#a_salir', function() {
		window.location.href = 'index.php';
	});
});