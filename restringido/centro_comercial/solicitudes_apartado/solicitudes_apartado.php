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
		$solicitudes = json_decode($response, true);
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
	<link rel="stylesheet" type="text/css" href="https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/css/notificacion_errores.css">
</head>
<body>
    <?php require("../templates/template.menu.php")?>

	<div class="content">
		<div class="title-options">
		
			<div id="content-menu-icon">
				<i class='bx bx-store-alt' id="menu-icon" data-toggle="menu"></i>
				<div class="content_number_notification">
					<div class="notifications_store"><p id="number_notification">99+</p></div>
				</div>

				<?php
					if (!isset($_GET['id']))
					{
				?>
				<div class="content-background-animated">
					<div id="background-animated"></div>
				</div>
				<?php 
					} 
				?>
			</div>
			
			<div id="sub-menu">
				<?php foreach ($tiendas as $tienda)
				{
					echo '
					<div class="menu-option">
						<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/solicitudes_apartado/solicitudes_apartado.php?id=' . $tienda['idTienda'] . '">' . $tienda['nombreTienda'] . '</a>
						<p class="notifications_store">99+</p>
					</div>
					';
				};
				?>
			</div>
			<h1>Solicitudes de apartado</h1>
			<div id="content-cambio-secc">
				<a href="solicitudes_activas.php" class="bttn_cambio_seccion">Ver solicitudes activas</a>
			</div>
			
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
			<div class="lista" id="lista">
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
				<span id="span-seleccion-tienda">No hay solicitudes pendientes en esta tienda</span>
				<?php
				if (isset($solicitudesError))
				{
					echo '<span id="span-seleccion-tienda">' .  $solicitudesError . '</span>';
				}
				/*else if (isset($messageSolicitud))
				{
					echo '<span id="span-seleccion-tienda">' .  $messageSolicitud . '</span>';
				}*/
				else
				{
				?>
				<?php
					foreach ($solicitudes as $solicitud)
					{
				?>
						<div class="item solicitudesItem">
							<img src="<?php echo $solicitud['imageProducto'];?>" alt="">
							<p><label><?php echo $solicitud['personalizado'] == true ? 'Personalizado' : '';?></label>
							<?php echo $solicitud['nombreProducto']?></p>
							<p>$<?php echo $solicitud['precioProducto']?></p>
							<p><?php echo $solicitud['periodoApartado']?></p>
							<p><?php echo $solicitud['ratioUsuario']?></p>
							<p><?php echo $solicitud['unidadesProducto']?></p>
							<p><i id="aprobar" data-solicitud-id="<?php echo $solicitud['idSolicitud']; ?>" style="color: green;" class='bx bxs-check-circle aprobar'></i></p>
							<p><i id="rechazar" data-solicitud-id="<?php echo $solicitud['idSolicitud']; ?>" style="color: #d30303;" class='bx bxs-x-circle rechazar'></i></p>
						</div>
				<?php
					}
				}
				?> 
			</div>
			<div class="nota">*Ratio de usuario - Número de apartados exitosos/Total de apartados que ha solicitado</div>
		</div>
		<?php
				}
		?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/microsoft-signalr/5.0.10/signalr.min.js"></script>
	<!--<script src="js/getSolicitudes.js"></script>-->
	<script src="../js/menu_desplegable.js"></script>
	<script src="js/updateSolicitud.js"></script>
</body>
</html>