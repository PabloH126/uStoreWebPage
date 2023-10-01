<?php
session_start();
require '../../security.php';
/*
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

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Publicaciones/GetPublicacionesRecientes?idTienda=" . $_GET['id']);
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
		$publicacionesError = "Error al intentar recuperar las publicaciones. Codigo de respuesta: " . $httpStatusCode;
	}
	$publicaciones = json_decode($response, true);
	curl_close($ch);
}
*/
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Perfil</title>
	<?php require("../templates/template.styles.php") ?>
	<?php require("templates/template.secc_perfil.php") ?>
</head>

<body>
	<?php require("../templates/template.menu.php") ?>

	<div class="content">
        <div class="header_profile">
			<div class="info_profile">

			</div>
			<div class="top_menu_profile">

			</div>
        </div>
        <div>

        </div>
	</div>
	<script src="../js/menu_desplegable.js"></script>
</body>
</html>