<?php 
/*	session_start();
	require '../security.php';

	$_SESSION['idMall'] = $_GET['id'];

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/GetTiendas?idCentroComercial=" . $_GET['id']);
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
	*/
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
			<h1>Solicitudes de apartado</h1>
			<a href="" class="bttn_cambio_seccion">Ver solicitudes activas</a>
		</div>

		<div>
			<div class="lista">
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
					<p>Imagen</p>
					<p>Oaaaaaaaaaaaaaaaaaaaaaaa</p>
					<p>$1000.00</p>
					<p>2 dias</p>
					<p>200/3</p>
					<p>2</p>
					<p>Si</p>
					<p>No</p>
				</div>
			</div>
			<div class="nota">*Ratio de usuario - Número de apartados exitosos/Total de apartados que ha solicitado</div>
		</div>
	</div>
</body>
</html>