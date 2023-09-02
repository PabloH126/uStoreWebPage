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
			<div class="bttn_solicitudes_apartado">
				<a href="" id="bttn_solicitudes_apartado">Solicitudes de apartado</a>
			</div>
		</div>

		<div>
			<div class="lista">
				<div class="item">
					Imagen del producto
				</div>
			</div>
			<div class="nota">*Ratio de usuario - Número de apartados exitosos/Total de apartados que ha solicitado</div>
		</div>
	</div>
</body>
</html>