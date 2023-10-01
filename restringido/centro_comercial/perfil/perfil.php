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
			<div class="header_info_profile">
				<div class="info_img_profile">
					<div class="img_profile">
						<img src="https://i.pinimg.com/564x/4f/cd/0d/4fcd0d0480073175756ac628a1cf959e.jpg" alt="imagen de perfil">
					</div>
					<div class="info_profil">
						<p>Nombre</p>
						<div>
							<p>correo</p>
							<p>fecha</p>
						</div>
					</div>
				</div>
				<div class="log-out">
					<img src="https://ustoree.azurewebsites.net/img/log_out.png" alt="Cerrar sesión">
				</div>
				
			</div>
			<div class="top_menu_profile">
				<button class="graficas_option">Gráficas</div>
				<button class="gerentes_option">Gerentes</div>
			</div>
        </div>
        <div>

        </div>
	</div>
	<script src="../js/menu_desplegable.js"></script>
</body>
</html>