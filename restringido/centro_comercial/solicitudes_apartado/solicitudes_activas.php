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

		curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Apartados/GetSolicitudesActivas?idTienda=" . $_GET['id']);
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
	<link rel="stylesheet" href="css/solicitudes_activas.css">
</head>
<body>
    <?php require("../templates/template.menu.php")?>

	<div class="content">
		<div class="title-options">
			<div id="content-menu-icon">
				<?php require("../templates/template.background_animated.php") ?>
				<i class='bx bx-store-alt store' id="menu-icon" data-toggle="menu"></i>	
			</div>

			<div id="sub-menu">
				<?php foreach ($tiendas as $tienda)
				{
					echo '
					<div class="menu-option">
						<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/solicitudes_apartado/solicitudes_activas.php?id=' . $tienda['idTienda'] . '">' . $tienda['nombreTienda'] . '</a>
					</div>
					';
				};
				?>
			</div>
			<div id="titles_page">
				<h1>Solicitudes activas</h1>
				<h3>
					<?php 
						foreach($tiendas as $tienda)
						{
							if($tienda['idTienda'] == $_GET['id'])
							{
								echo $tienda['nombreTienda'];
								break;
							}
						}
					?>
				</h3>
			</div>
			<div id="content-cambio-secc">
				<a href="solicitudes_apartado.php" class="bttn_cambio_seccion">Solicitudes de apartado</a>
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
			<div class="lista">
				<div class="item" id="encabezado">
					<p>Imagen del producto</p>
					<p>Nombre del producto</p>
					<p>Precio del producto</p>
					<p>Unidades</p>
					<p>Tiempo restante</p>
					<p>Recogió</p>
					<p>Borrar</p>
				</div>
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
				?>
				<?php
					$tiempoActual = new DateTime('now', new DateTimeZone('Etc/GMT+6'));
					foreach ($solicitudes as $solicitud)
					{
						//$tiempoVencimiento = DateTime::createFromFormat('Y-m-d H:i:s.v', $solicitud['fechaVencimiento'], new DateTimeZone('UTC'));
						//
						$simpleFecha = substr($solicitud['fechaVencimiento'], 0, 19);
						$tiempoVencimiento = DateTime::createFromFormat('Y-m-d\TH:i:s', $simpleFecha, new DateTimeZone('UTC'));
						$tiempoVencimiento->setTimezone(new DateTimeZone('Etc/GMT+6'));
						$tiempoVencimiento = $tiempoVencimiento->format('Y-m-d H:i:s');

				?>
						<div class="item">
							<img src="<?php echo $solicitud['imageProducto'];?>" alt="">
							<p><label><?php echo $solicitud['personalizado'] == true ? 'Personalizado' : '';?></label>
							<?php echo $solicitud['nombreProducto']?></p>
							<p>$<?php echo $solicitud['precioProducto']?></p>
							<p><?php echo $solicitud['unidadesProducto']?></p>
							<p><?php echo $tiempoVencimiento;?></p>
							<p><i id="aprobar" data-solicitud-id="<?php echo $solicitud['idSolicitud']; ?>" style="color: green;" class='bx bxs-check-circle aprobar bttn_solicitudes'></i></p>
							<p><i id="rechazar" data-solicitud-id="<?php echo $solicitud['idSolicitud']; ?>" style="color: #d30303;" class='bx bxs-x-circle rechazar bttn_solicitudes'></i></p>
						</div>
				<?php
					}
				}
			}
				?> 
			</div>
		</div>
	</div>
	<script src="../js/menu_desplegable.js"></script>
	<script src="js/updateSolicitud.js"></script>
</body>
</html>