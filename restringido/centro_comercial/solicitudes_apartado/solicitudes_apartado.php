<?php 
	session_start();
	require '../../security.php';

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/GetTiendas?idCentroComercial=" . $_SESSION['idMall']);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Authorization: Bearer ' . $_COOKIE['SessionToken']
	));
	
	$response = curl_exec($ch);
	
	if ($response === false) {
		echo 'Error: ' . curl_error($ch);
	} else {
		$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	}
	
	if ($httpStatusCode == 400) {
		$tiendasError = "Error al intentar recuperar las tiendas. Codigo de respuesta: " . $httpStatusCode;
	}
	$tiendas = json_decode($response, true);
	curl_close($ch);

	if (isset($_GET['id']))
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Apartados/GetSolicitudesPendientes?idTienda=" . $_GET['id']);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $_COOKIE['SessionToken']
		));
		
		$response = curl_exec($ch);
		
		if ($response === false) {
			echo 'Error: ' . curl_error($ch);
		} else {
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}
		
		if ($httpStatusCode == 400) {
			$solicitudesError = "Error al intentar recuperar las solicitudes. Codigo de respuesta: " . $httpStatusCode;
		}
		else if ($httpStatusCode == 404)
		{
			$messageSolicitud = $response;
		}
		$data = json_decode($response, true);
		$solicitudes = $data['solicitudes'];
		$productos = $data['productos'];
		curl_close($ch);
	}
	
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Solicitudes de apartado</title>
    <?php require("../templates/template.styles.php")?>
	<?php require("templates/template.secc_apartados.php")?>
</head>
<body>
    <?php require("../templates/template.menu.php")?>

	<div class="content">
		<div class="title">
		<?php
			if (!isset($_GET['id']))
			{
		?>
			<div id="background-animated"></div>
		<?php 
			} 
		?>
			<i class='bx bx-store-alt' id="menu-icon" data-toggle="menu"></i>
			
			<div id="sub-menu">
				<?php foreach ($tiendas as $tienda)
				{
					echo '
					<div class="menu-option">
						<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/solicitudes_apartado/solicitudes_apartado.php?id=' . $tienda['idTienda'] . '">' . $tienda['nombreTienda'] . '</a>
					</div>
					';
				};
				?>
			</div>
			<h1>Solicitudes de apartado</h1>
			<a href="solicitudes_activas.php" class="bttn_cambio_seccion">Ver solicitudes activas</a>
		</div>
		<?php
			if (!isset($_GET['id']))
			{
		?>
		<div>
			<span id="span-seleccion-tienda">Seleccione una tienda</span>
		</div>
		<?php
			}
			else
			{
		?>
		<div>
			<div class="lista">
				<?php
				
				if (isset($solicitudesError))
				{
					echo '<span id="span-seleccion-tienda">' .  $solicitudesError . '</span>';
				}
				else if (isset($messageSolicitud))
				{
					echo '<span id="span-seleccion-tienda">' .  $messageSolicitud . '</span>';
				}
				else
				{
					foreach ($solicitudes as $solicitud)
					{
						foreach ($productos as $producto)
						{
							if($solicitud['idProductos'] == $producto['idProductos'])
							{
				?>
				<div class="item" id="encabezado">
					<p>Imagen del producto</p>
					<p>Nombre del producto</p>
					<p>Precio del producto</p>
					<p>Tiempo de apartado</p>
					<p>Ratio de usuario*</p>
					<p>Unidades</p>
					<p>Aceptar</p>
					<p>Denegar</p>
				</div>

				<div class="item">
					<img src="<?php echo $producto['imageProducto'];?>" alt="">
					<p><label><?php echo $solicitud['personalizado'] == true ? 'Personalizado' : '';?></label>
					<?php echo $producto['nombreProducto']?></p>
					<p><?php echo $producto['precioProducto']?></p>
					<p><?php echo $solicitud['periodoApartado']?></p>
					<p><?php echo $solicitud['ratioUsuario']?></p>
					<p><?php echo $solicitud['unidadesProducto']?></p>
					<p><i style="color: green;" class='bx bxs-check-circle'></i></p>
					<p><i style="color: #d30303;" class='bx bxs-x-circle'></i></p>
				</div>
				<?php
							}
						}
					}
				?> 
			</div>
			<div class="nota">*Ratio de usuario - Número de apartados exitosos/Total de apartados que ha solicitado</div>
		</div>
		<?php
				}
			}
		?>
	</div>
	<script src="../js/menu_desplegable.js"></script>
</body>
</html>