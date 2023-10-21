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

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Apartados/GetNumeroSolicitudes");
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
			$numeroSolicitudesError = "Error al intentar recuperar las tiendas. Codigo de respuesta: " . $httpStatusCode;
		}
		$numeroSolicitudes = json_decode($response, true);
		curl_close($ch);

	}

	if (isset($_GET['id']))
	{
		$ch = curl_init();
		isset($_SESSION['idTiendaGerente']) ? ($_GET['id'] = $_SESSION['idTiendaGerente']) : '';
		echo $_GET['id'];
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
				<?php 
				if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
				{	?>
					<?php require("../templates/template.background_animated.php") ?>
					<i class='bx bx-store-alt store' id="menu-icon" data-toggle="menu"></i>
					
					<?php
						$sumaSolicitudes = 0;
						foreach ($numeroSolicitudes as $idTienda => $numeroSoli)
						{
							$sumaSolicitudes += $numeroSoli;
						}

						echo '<div class="content_number_notification" ' . ($sumaSolicitudes == 0 ? 'style="display: none"' : '') . '>';
						echo '<div class="notifications_store"><p id="number_notification">' . $sumaSolicitudes . '</p></div>';
						echo '</div>';
					?>
				<?php } ?>
			</div>
			<?php 
			if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
			{	?>
				<div id="sub-menu">
					<?php foreach ($tiendas as $tienda)
					{
						echo '<div class="menu-option '. (isset($_GET['id']) && $_GET['id'] == $tienda['idTienda'] ? 'menuIconSelected' : '') .'" data-tienda-id="' . $tienda['idTienda'] . '">
								<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/solicitudes_apartado/solicitudes_apartado.php?id=' . $tienda['idTienda'] . '">' . $tienda['nombreTienda'] . '</a>';

						$numeroSolicitud = 0;
						foreach ($numeroSolicitudes as $idTienda => $numeroSoli)
						{
							if ($idTienda == $tienda['idTienda'])
							{
								$numeroSolicitud = $numeroSoli;
								break;
							}
						}

						echo '<p class="notifications_store numero_solicitudes_tienda" ' . ($numeroSolicitud == 0 ? 'style="display: none"' : '') . '>' . $numeroSolicitud . '</p>';
						
						echo '</div>';
					};
					?>
				</div>
			<?php 
			} ?>

			<div id="titles_page">
				<h1>Solicitudes de apartado</h1>
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
				} ?>
				</h3>
			</div>
			
			<div id="content-cambio-secc">
				<a href="solicitudes_activas.php<?php echo isset($_GET['id']) ? '?id='. $_GET['id'] : ''; ?>" class="bttn_cambio_seccion">Ver solicitudes activas</a>
			</div>
			
		</div>
		<?php
			if (!isset($_GET['id']))// && (isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador"))
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
							<p><i id="aprobar" data-solicitud-id="<?php echo $solicitud['idSolicitud']; ?>" style="color: green;" class='bx bxs-check-circle aprobar bttn_solicitudes'></i></p>
							<p><i id="rechazar" data-solicitud-id="<?php echo $solicitud['idSolicitud']; ?>" style="color: #d30303;" class='bx bxs-x-circle rechazar bttn_solicitudes'></i></p>
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
	<script src="../js/menu_desplegable.js"></script>
	<script src="js/updateSolicitud.js"></script>
</body>
</html>