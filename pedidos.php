<?php
	include("php_lib/comun.php");
  include("php_lib/cnn.php");
  
	iniciasesion();
	
	if(!isset($_SESSION['usuario'])){
		header( "Location:/lacafe/index.php");
		die();
	}
	
	$vQry = "SELECT a.articuloID as id, concat(LTRIM(a.descripcion),' DE ', LTRIM(at.descripcion)) as articulo, precio 
    FROM articulos a
    INNER JOIN articulosTipos at ON a.articuloTipoID = at.articuloTipoID
    WHERE a.esta = 'A'
    AND at.esta = 'A'";


  $resu = $mysqli->query($vQry);
  if(!$resu){
    echo $mysqli->error;
  }
  ob_start();
  while ($obj = $resu->fetch_object()) {
    ?> <option value="<?php echo htmlspecialchars($obj->id); ?>" data-precio="<?php echo htmlspecialchars($obj->precio); ?>"><?php echo htmlspecialchars($obj->articulo); ?></option>
    <?php
  }
          
  $dibujaopcs = ob_get_clean();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <title></title>
  
  
  
  <link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.3.2.min.css">
  
  <!-- Extra Codiqa features -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/pedidos.css">
  
  <!-- jQuery and jQuery Mobile -->
  	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.mobile-1.3.2.min.js"></script>   
    <script type="text/javascript" src="js/pedidos.js"></script>   

  <!-- Extra Codiqa features -->
  <script src="https://d10ajoocuyu32n.cloudfront.net/codiqa.ext.js"></script>
   
</head>
<body>
<!-- Home -->
<menu type="context" id="menuborrar">
  <menuitem label="Eliminar" id="mnieliminar" onclick="window.quitapedido()"
   ontouchstart="window.quitapedido()" icon="images/bote.png">
  </menuitem>
</menu>
<div data-role="page" id="page1">
    <div data-theme="" data-role="header">
        <h3>
            La Kfe - Pedidos
        </h3>
    </div>
    <a data-role="button" data-theme="a" id="bt_muro" href="#nada">
	   Muro
	</a>
    <div data-role="content">
        <div data-role="fieldcontain">
            <label for="selectmenu2">
                Seleccionar:
            </label>
            <select id="sl_articulos" name="sl_articulos">
              <option value="-1">.: Sin Seleccion :.</option>
                <?php echo $dibujaopcs; ?>
            </select>
        </div>
        <div data-role="fieldcontain">
            <label for="sl_cuantos">
                Cuantos:
            </label>
            <input id="sl_cuantos" name="slider" value="1" min="1" max="10" data-highlight="true"
            type="range">
        </div>
        <input data-theme="a" value="Agregar" type="button" id="bt_agregar">
		<hr />
		<div id="newschool">			
			<div class="drophere" style="z-index:1000; text-align:center; display:none;" title="Arrastrar aqui para cancelar">								<img src="images/bote.png" alt="bote" />
			</div>
			<hr />
			<ul data-role="listview" data-divider-theme="a" data-inset="true" >
				<li data-role="list-divider" role="heading" id="li_ppal">
					Mi Pedido&nbsp;<label id="lb_total">0.00</label>
				</li>
			</ul>
		</div>
    </div>
	<a data-role="button" data-theme="b" id="bt_marcar" href="#nada">
	   Marcar a la Kfe
	</a>
	<!-- <a href="pedidosLst.php" >Listados</a> -->
	<?php include("inc/footer.php"); ?>
</div>
</body>
</html>
