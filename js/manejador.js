$(function() {
	$('#bt_entrar').click(function() {
		$.get("php_controladores/maneja_login.php", {
			usuario: $('#tx_usuario').val(),
			password: $('#tx_clave').val()
		}, function(data) {
			if (!data.err) {
				window.location.href = 'muro.php';
			}else{
				alert(data.msg);
			}
		},"json");
	});
	
	$('#tx_clave').keypress(function (e) {
		if (e.which == 13) {
			$('#bt_entrar').click();
		}
	});

	$('#del_photo').click(function(){
		$("#image-presenter img").remove();
	});
	$('#bt_geo').click(function() {
		var geolocationDisplay = $('#geo-presenter');
		navigator.geolocation.getCurrentPosition(function(position) {
				geolocationDisplay.html("<strong>Latitude:</strong> " + position.coords.latitude + ", <strong>Longitude:</strong> " + position.coords.longitude);
				$.post("php_controladores/maneja_dato.php", {
					datos: JSON.stringify({
						Clave: "Geo",
						Valor: {
							accuracy: position.coords.accuracy,
							altitude: position.coords.altitude,
							altitudeAccuracy: position.coords.altitudeAccuracy,
							heading: position.coords.heading,
							latitude: position.coords.latitude,
							longitude: position.coords.longitude,
							speed: position.coords.speed,
							timestamp: position.timestamp
						}
					})
				}, function(data) {
					if (data.err) {
						alert(data.msg);
					}
				})
			},
			function(position) {
				geolocationDisplay.html("Failed to get your current location");
			});
	});

	$('#bt_foto').click(function() {
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
			var width = 320,
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
						var data = canvas.toDataURL('image/png');
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
	
	$(document).on('click', '#a_registro', function() {
		window.location.href = 'registro.php';
	});
	
	$('#tx_usuario').focus();
});