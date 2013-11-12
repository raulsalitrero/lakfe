<?php
  include("php_lib/comun.php");
    iniciasesion();
  if(!isset($_SESSION['usuario'])){
    header( "Location:/lacafe/index.php");
    die();
  }
  ?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title></title>
    <link rel="stylesheet" href="css/jquery.mobile-1.3.2.min.css">
    <!-- Extra Codiqa features -->
    <link rel="stylesheet" href="css/muro.css">
    <!-- jQuery and jQuery Mobile -->
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery.mobile-1.3.2.min.js"></script>
    <script src="js/gumwrapper.js"></script>
    <!-- Extra Codiqa features -->
    <script src="js/muro.js"></script>
  </head>
  <body>
    <!-- Home -->
    <div data-role="page" id="Main">
      <div id="Cabeza" data-theme="a" data-role="header" class="Cabeza">
        <h3>
          La Kfe - Muro
        </h3>
      </div>
      <a data-role="button" data-theme="a" id="bt_pedidos" href="#nada">
      Mis Pedidos
      </a>
      <a data-role="button" data-theme="b" id="bt_refresh" href="#nada">
      Actualizar Pagina
      </a>
      <div data-role="content" id="contenido" data-mini="true">
        <div id="Posts">
        </div>
        <form id="Forma" action="php_controladores/muro.php" method="POST" class="Forma">
          <div data-role="collapsible-set" data-theme="b">
            <div data-role="collapsible" id="dv_Forma" data-collapsed="false" data-mini="true" data-inset="false">
              <h3>
                Nuevo Post
              </h3>
              <div class="hidden" style="display:none">
                <video id="pVideo"></video>
                <canvas id="pCanvas"></canvas>
              </div>
              <div id="image-presenter"></div>
              <a data-role="button" id="bt_foto" data-inline="true" data-theme="a" href="#nada">
              Tomar Foto
              </a>
              <a data-role="button" id="bt_del_foto" data-inline="true" data-theme="a" href="#nada">
              Quitar Foto
              </a>
              <div id="opciones" data-role="fieldcontain">
                <fieldset data-role="controlgroup" data-type="vertical" data-mini="true">
                  <input id="ch_geo" name="ch_geo" data-theme="b" type="checkbox">
                  <label for="ch_geo">
                  Incluir Donde estoy?
                  </label>
                </fieldset>
              </div>
              <div id="geo_pos"></div>
              <div id="mapa"></div>
              <div data-role="fieldcontain" class="texto">
                <label for="texto">
                Que estas Pensando?
                </label>
                <textarea name="texto" id="texto" placeholder=""></textarea>
              </div>
              <a data-role="button" id="bt_enviar" data-theme="a" data-mini="true" href="#nada" class="bt_enviar">
              Compartir
              </a>
            </div>
          </div>
		  <?php include("inc/footer.php"); ?>
        </form>
      </div>
    </div>
  </body>
</html>