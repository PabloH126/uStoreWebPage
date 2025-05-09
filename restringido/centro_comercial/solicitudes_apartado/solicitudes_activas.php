<?php 
	session_start();
	require '../../security.php';

	if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
	{
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

	}

	isset($_SESSION['idTiendaGerente']) ? ($_GET['id'] = $_SESSION['idTiendaGerente']) : '';

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
				<?php 
				if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
				{	
					?>
					<?php require("../templates/template.background_animated.php") ?>
					<i class='bx bx-store-alt store' id="menu-icon" data-toggle="menu"></i>	
				<?php } ?>
			</div>

			<?php 
				if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
				{	
			?>
				<div id="sub-menu">
					<?php foreach ($tiendas as $tienda)
					{
						echo '
						<div class="menu-option '. (isset($_GET['id']) && $_GET['id'] == $tienda['idTienda'] ? 'menuIconSelected' : '') .'">
							<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/solicitudes_apartado/solicitudes_activas.php?id=' . $tienda['idTienda'] . '">' . $tienda['nombreTienda'] . '</a>
						</div>
						';
					};
					?>
				</div>
			<?php } ?>

			<div id="titles_page">
				<h1>Solicitudes activas</h1>
				<h3>
					<?php 
					if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
					{	
						foreach($tiendas as $tienda)
						{
							if($tienda['idTienda'] == $_GET['id'])
							{
								echo $tienda['nombreTienda'];
								break;
							}
						}
					}
					?>
				</h3>
			</div>

			<div id="content-cambio-secc">
				<a href="solicitudes_apartado.php<?php echo isset($_GET['id']) ? '?id='. $_GET['id'] : ''; ?>" class="bttn_cambio_seccion">Solicitudes de apartado</a>
			</div>
		</div>
				<?php
			if (!isset($_GET['id']) && (isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador"))
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
					<p>Unidades</p>
					<p>Tiempo restante</p>
					<p>Recogió</p>
					<p>Borrar</p>
				</div>
				<span id="span-seleccion-tienda">No hay solicitudes activas en esta tienda</span>
				<?php
				if (isset($solicitudesError))
				{
					echo '<span id="span-seleccion-tienda">' .  $solicitudesError . '</span>';
				}
				else
				{
				?>
				<?php
					$tiempoActual = new DateTime('now', new DateTimeZone('Etc/GMT+6'));
					foreach ($solicitudes as $solicitud)
					{
						$simpleFecha = substr($solicitud['fechaVencimiento'], 0, 19);
						$tiempoVencimiento = DateTime::createFromFormat('Y-m-d\TH:i:s', $simpleFecha, new DateTimeZone('UTC'));
						$tiempoVencimiento->setTimezone(new DateTimeZone('Etc/GMT+6'));
						if ($solicitud['statusSolicitud'] == "recogida")
						{
							$intervalo = "recogida";
						}
						else
						{
							if($tiempoVencimiento > $tiempoActual)
							{
								$intervalo = $tiempoActual->diff($tiempoVencimiento);
								$intervalo = $intervalo->format('%a:%H:%I:%S');
							}
							else
							{
								$intervalo = "0";
							}
						}
						$tiempoVencimiento = $tiempoVencimiento->format('Y-m-d H:i:s');
				?>
						<div class="item solicitudesItem">
							<img src="<?php echo $solicitud['imageProducto'];?>" alt="">
							<p><label><?php echo $solicitud['personalizado'] == true ? 'Personalizado' : '';?></label>
							<?php echo $solicitud['nombreProducto']; ?></p>
							<p>$<?php echo $solicitud['precioProducto']; ?></p>
							<p><?php echo $solicitud['unidadesProducto']; ?></p>
							
							<p style="color: green" class="timer" data-time="<?php echo $intervalo ?>"></p>
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
	<script src="js/updateSolicitudActiva.js"></script>
</body>
</html>