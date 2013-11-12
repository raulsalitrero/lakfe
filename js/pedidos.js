$(function() {
	var currentYear = (new Date).getFullYear();
	$('#lb_anio').text(currentYear);

	$(document).on('click', '#bt_muro', function(e) {
		e.preventDefault();
		location.href = "muro.php";
	});

	$(document).on('click', '#bt_marcar', function(e) {
		if (typeof(MozActivity) != "undefined") {
			var call = new MozActivity({
				name: "dial",
				data: {
					number: "+46777888999"
				}
			});
		}
	});

	$('#bt_agregar').click(function() {
		var v_articuloID = $('#sl_articulos :selected').val();
		var v_descrip = $('#sl_articulos :selected').text();
		if (v_articuloID == '-1') {
			alert(v_descrip);
		} else {
			var v_cuantos = $('#sl_cuantos').val();
			var v_precio = $('#sl_articulos :selected').data('precio');
			var v_total = parseFloat(v_precio, 10) * parseFloat(v_cuantos, 10);
			var v_titulo = '(' + v_cuantos + ' * $' + v_precio + ' = $' + v_total + ') ' + v_descrip;
			var v_ID = '#a_' + v_articuloID;

			if ($(v_ID).length == 1) {
				$(v_ID).text(v_titulo);
				$(v_ID).data('cantidad', v_cuantos);
			} else {
				var ht = '<li data-theme="c" class="li_items dragme" contextmenu="menuborrar">';
				ht += '	<a href="#nada" class="a_lista" id="a_' + v_articuloID + '" data-transition="slide" data-id="a_' + v_articuloID + '" data-cantidad="' + v_cuantos + '" data-precio="' + v_precio + '" title="Arrastrar para cancelar" style="font-family: Helvetica,Arial,sans-serif; font-weight: bold; color:#000; text-decoration: none; padding:10px; text-align:center !important;">';
				ht += v_titulo;
				ht += '	</a>';
				ht += '</li>';

				$('#li_ppal').after($(ht));

				drags();
			}
			
			if($('.a_lista').length > 0) {
				$('.drophere').fadeIn('Slow');
			} else {
				$('.drophere').fadeOut('Slow');
			}

			calculaTotal();
		}
	});

	function cerrarPedido() {
		$.get("php_controladores/pedidos_abc.php", {
			articuloID: v_articuloID,
			cantidad: v_cuantos
		}, function(data) {
			if (!data.err) {
				window.location.href = 'muro.php';
			} else {
				alert(data.msg);
			}
		}, "json");
	}

	function calculaTotal() {
		var v_total = 0;
		$('.a_lista').each(function() {
			v_total += parseFloat($(this).data('precio'), 10) * parseFloat($(this).data('cantidad'), 10);
		});

		$('#lb_total').text('( $' + v_total + ' pesos )');
	}

	function drags() {
		$('#newschool .dragme')
			.attr('draggable', 'true')
			.off('dragstart').on('dragstart', function(ev) {
				var dt = ev.originalEvent.dataTransfer;
				//dt.setData("Text", "Dropped in zone!");					
				$('.drophere').show();
				return true;
			})
			.off('dragend').on('dragend', function(ev) {
				$(this).remove();
				$('.drophere').hide();
				calculaTotal();
				
				if($('.a_lista').length > 0) {
					$('.drophere').fadeIn('Slow');
				} else {
					$('.drophere').fadeOut('Slow');
				}
				
				return false;
			});
		$('#newschool .drophere')
			.off('dragenter').on('dragenter', function(ev) {
				$(ev.target).addClass('dragover');

				return false;
			})
			.off('dragleave').on('dragleave', function(ev) {
				$(ev.target).removeClass('dragover');
				$('.drophere').hide();
				return false;
			})
			.off('dragover').on('dragover', function(ev) {
				$('.drophere').show();
				return false;
			})
			.off('drop').on('drop', function(ev) {
				var dt = ev.originalEvent.dataTransfer;
				// alert(dt.getData('Text'));				
				$('.drophere').fadeOut('Slow');
				

				return false;
			});
	}

	$(document).on('click', '#a_salir', function() {
		window.location.href = 'index.php';
	});

	var activo=false;
	$(document).on('mousedown touchstart','li.li_items',function(){
		activo = $(this);
	});

	window.quitapedido = function quitapedido(e){
		$li = activo;
		$li.remove();
		
		if($('.a_lista').length > 0) {
			$('.drophere').fadeIn('Slow');
		} else {
			$('.drophere').fadeOut('Slow');
		}
	};

	$(document).on('click touchstart', '#mnieliminar', window.quitapedido);
});