<?php
	include("php_lib/comun.php");
	include("php_lib/cnn.php");
  
	iniciasesion();
	
	if(!isset($_SESSION['usuario'])){
		header( "Location:/lacafe/index.php");
		die();
	}
	
	$vQry = "SELECT u.usuarioID as id, u.usuario
    FROM usuarios u    
    WHERE u.esta = 'A'";

  $resu = $mysqli->query($vQry);
  if(!$resu){
    echo $mysqli->error;
  }
  ob_start();
  while ($obj = $resu->fetch_object()) {
    ?> <option value="<?php echo htmlspecialchars($obj->id); ?>"><?php echo htmlspecialchars($obj->usuario); ?></option>
    <?php
  }
  
  $dibujaopcs = ob_get_clean();
  
  $vQry = "SELECT p.pedidoID, p.usuarioID, p.fecha, p.esta, pd.articuloID, a.descripcion, p.usuarioID, u.usuario, 0 as total
	FROM pedidos p
	INNER JOIN pedidosDetalle pd ON p.pedidoID = pd.pedidoID
	INNER JOIN articulos a ON pd.articuloID = a.articuloID
	INNER JOIN usuarios u ON p.usuarioID = u.usuarioID
WHERE p.esta = 'A'
AND pd.esta = 'A'
AND a.esta = 'A'
AND u.esta = 'A'";

$resu = $mysqli->query($vQry);
  if(!$resu){
    echo $mysqli->error;
  }
  ob_start();          
  
	while ($obj = $resu->fetch_object()) {
    ?> <tr><td><?php echo htmlspecialchars($obj->fecha); ?></td><td><?php echo htmlspecialchars($obj->usuario); ?></td><td><?php echo htmlspecialchars($obj->total); ?></td>
    <?php
  }
  $dibujatrs = ob_get_clean();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.3.2.min.css">
	<link rel="stylesheet" type="text/css" href="css/codiqa.ext.css">
    <title>Listado de pedidos</title>
	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.mobile-1.3.2.min.js"></script>    
    <script type="text/javascript" src="js/manejador.js"></script>
    <script type="text/javascript" src="js/codiqa.ext.js"></script>
    <script type="text/javascript" src="js/pedidosLst.js"></script>
    <base target="_blank">
</head>
<body>
	<form id="form1" action="#" method="get">
		<div data-role="page" id="page1">		
			<div data-theme="a" data-role="header">
				<h3 id="dv_lacafe">
					Pedidos hechos
				</h3>
			</div>
			 <a data-role="button" data-theme="a" id="bt_pedidos" href="#nada">
			  Mis Pedidos
			 </a>
			 <div data-role="content">
				Del:<input type="date" style="width:100px;" maxlength="10" id="tx_del" value="<?php echo date('d/m/Y'); ?>"/>
				Al:<input type="date" style="width:100px;" maxlength="10" id="tx_al" value="<?php echo date('d/m/Y'); ?>" />
				<div data-role="fieldcontain">
				<label for="selectmenu2">
					Usuario:
				</label>
				<select id="sl_articulos" name="sl_usuarios">
				  <option value="-1">.: Sin Seleccion :.</option>
					<?php echo $dibujaopcs; ?>
				</select>
			</div>			
		 </div>
		  <input data-theme="a" value="Buscar" type="button" id="bt_buscar">
		<hr />
		<table id="tb_ppal" border="0">
			<tr>
				<th>Fecha</th>
				<th>Usuario</th>
				<th>Total</th>
			</tr>
			<?php echo $dibujatrs; ?>
		</table>
		<?php include("inc/footer.php"); ?>
		</div>
		
	</form>
</body>
</html>