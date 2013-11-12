$(function() {
	var traePosts = function traePosts() {
		$.get('php_controladores/muro.php', {}, function(data) {
			if (!data.err) {
				var html = '<div class="post">' +
					'<div class="head"><span class="usuario"></span>' +
					'<span class="fecha"></span></div>' +
					'<div class="geo"></div>' +
					'<div class="texto"></div>' +
					'</div><br />',
					$posts = $('#Posts');
				$.each(data.datos, function(ix, el) {
					$el = $(html);
					$el.find('.usuario').text(el.usuario);
					$el.find('.fecha').text(el.fecha);
					if(el.geo){
						$el.find('.geo').data('latlong',el.geo.latitude + ',' + el.geo.longitude).
						text(el.geo.direccion);
					}
					$el.find('.texto').html(el.texto);
					$el.data("postid", el.postid).data("usuarioid", el.usuarioid);
					if(el.tienefoto){
						$el.find('.texto').before($('<img src="fotos/post_'+el.postid+'.jpg" />'));
					}
					$posts.append($el);
				});
			}
		}, 'json');
	};

	$(document).on('click', "#bt_pedidos", function(e) {
		e.preventDefault();
		location.href = "pedidos.php";
	});

	$(document).on('click', '#bt_del_foto', function() {
		$("#image-presenter img").remove();
	});

	$(document).on('click', '#bt_foto', function() {
		if (typeof(MozActivity) != "undefined") {
			var rec = new MozActivity({
				name: "record" // Possibly capture in future versions
			});

			rec.onsuccess = function() {
				$("#image-presenter img").remove();
				var img = document.createElement("img");
				img.src = window.URL.createObjectURL(this.result.blob);
				var imagePresenter = $("#image-presenter")
				imagePresenter.append(img);
				imagePresenter.css({
					"display": "block"
				});
			};

			rec.onerror = function() {
				alert("No taken picture returned");
			};
		} else if (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia) {
			var width = 280,
				height = 0,
				video = $('#pVideo')[0],
				canvas = $('#pCanvas')[0],
				tomada = false,
				takepicture = function takepicture() {
					if (!tomada) {
						tomada = true;
						canvas.width = width;
						canvas.height = height;
						canvas.getContext('2d').drawImage(video, 0, 0, width, height);
						$("#image-presenter img").remove();
						var data = canvas.toDataURL('image/jpeg', 0.9);
						var photo = document.createElement("img");
						photo.setAttribute('src', data);
						$('#image-presenter').append(photo);
						$(video).attr("src", "");
					}
				};
			um = new GumWrapper({
				video: 'pVideo'
			}, function(video) {
				var canvas = $('#pCanvas')[0];
				var video = $('#pVideo')[0];
				height = video.videoHeight / (video.videoWidth / width);
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				setTimeout(takepicture, 100);
			}, function() {
				alert("no se pudo abrir webcam");
			});
			um.play();
		}
	});

	$(document).on('change', '#ch_geo', function() {
		if ($(this).is(':checked')) {
			navigator.geolocation.getCurrentPosition(function(position) {
					$('#geo_pos').html("<strong>Latitud:</strong> " + position.coords.latitude + ", <strong>Longitud:</strong> " + position.coords.longitude);
					var $mapa = $('<img width="288" height="200"/>');
					$mapa.attr("src", "https://maps.googleapis.com/maps/api/staticmap?" +
						"center=" + position.coords.latitude + ", " + position.coords.longitude +
						"&zoom=16&size=288x200&markers=" + position.coords.latitude + ", " + position.coords.longitude +
						"&sensor=true&key=AIzaSyDCb8MeVPqM8xNh9E0dUkyiY_yCGnpDmBQ");
					$("#mapa img").remove();
					$("#mapa").append($mapa);
					$("#mapa").data("geo", {
						accuracy: position.coords.accuracy,
						altitude: position.coords.altitude,
						altitudeAccuracy: position.coords.altitudeAccuracy,
						heading: position.coords.heading,
						latitude: position.coords.latitude,
						longitude: position.coords.longitude,
						speed: position.coords.speed,
						timestamp: position.timestamp
					});
					$.get("http://maps.googleapis.com/maps/api/geocode/json?latlng="+position.coords.latitude +
						", "+ position.coords.longitude +"&sensor=true",{},function(data){
							if(data && data.results && data.results[0]){
								$("#mapa").prepend($('<div></div>').text(data.results[0].formatted_address));
								var geo = $("#mapa").data("geo");
								geo.direccion = data.results[0].formatted_address;
								$("#mapa").data("geo",geo);
							}
						},'json');	
				},
				function() {
					$('#geo_pos').html("Error Obteniendo tu posicion").removeData("geo");
				}, {
					timeout: 10000
				});
		} else {
			$('#geo_pos').html('');
			$("#mapa").html('');
			$('#mapa').removeData("geo");
		}
	});

	$(document).on('click ', '#bt_enviar', function(e) {
		var datos = {},
			cabeza = /^data:image\/(png|jpeg);base64,/;
		datos.texto = $.trim($('#texto').val());
		datos.foto = ($("#image-presenter img").length > 0) ? $("#image-presenter img").attr("src").replace(cabeza, '') : "";
		datos.geo = JSON.stringify($('#mapa').data("geo"));
		if (datos.texto == "") {
			alert("Debes escribir un mensaje");
			$('#texto').focus();
			e.preventDefault();
			e.stopPropagation();
			return false;
		}
		$.post("php_controladores/muro.php", datos, function(data) {
			if (!data.err) {
				alert("Se Guardo Tu Mensaje Exitosamente!!!");
				$('#Posts').html('');
				$('#geo_pos').html('');
				$("#mapa").html('');
				$("#image-presenter img").remove();
				$('#mapa').removeData("geo");
				$('#texto').val('');
				traePosts();
			} else {
				alert("Error:" + data.msg);
			}
		}, 'json');
	});
	$(document).on('click', '#a_salir', function() {
		window.location.href = 'index.php';
	});
	$(document).on('click', '#bt_refresh', function() {
		window.location.reload(true);
	});
	traePosts();
});