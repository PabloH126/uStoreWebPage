<?php
session_start();
require '../../security.php';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Perfil/GetPerfil");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
	$ch,
	CURLOPT_HTTPHEADER,
	array(
		'Authorization: Bearer ' . $_COOKIE['SessionToken']
	)
);

$response = curl_exec($ch);

if ($response === false) {
	echo 'Error: ' . curl_error($ch);
} else {
	$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode == 400) {
	$perfilError = "Error al intentar recuperar las tiendas. Codigo de respuesta: " . $httpStatusCode;
}
$perfil = json_decode($response, true);
curl_close($ch);

$simpleFecha = substr($perfil['fechaRegistro'], 0, 19);
$fechaRegistro = DateTime::createFromFormat('Y-m-d\TH:i:s', $simpleFecha, new DateTimeZone('UTC'));
$fechaRegistro->setTimezone(new DateTimeZone('Etc/GMT+6'));
$fechaRegistro->format('d-m-Y');

if (isset($_GET['id'])) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Publicaciones/GetPublicacionesRecientes?idTienda=" . $_GET['id']);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt(
		$ch,
		CURLOPT_HTTPHEADER,
		array(
			'Authorization: Bearer ' . $_COOKIE['SessionToken']
		)
	);

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
		<?php
		if (isset($perfilError))
		{
			echo $perfilError;
		}
		else
		{
		?>
		<div class="header_profile">
			<div class="header_info_profile">
				<div class="info_img_profile">
					<div class="img_profile">
						<img src="<?php echo $perfil['imagenP']; ?>"
							alt="imagen de perfil">
					</div>
					<div class="info_profil">
						<p><?php echo $perfil['nombre']; ?></p>
						<div>
							<p><?php echo $perfil['correo']; ?></p>
							<p><?php echo $fechaRegistro; ?></p>
						</div>
					</div>
				</div>
				<div class="log-out">
					<img src="https://ustoree.azurewebsites.net/img/log_out.png" alt="Cerrar sesión">
				</div>

			</div>
			<div class="top_menu_profile">
				<button class="graficas_option">Gráficas</button>
				<button class="gerentes_option">Gerentes</button>
			</div>
		</div>
		<div class="aside_profile">
			<?php require("../templates/template.aside.php") ?>

			<div class="body">
				<canvas id="grafica"></canvas>
			</div>
		</div>
		<?php
		}
		?>
	</div>
	<script src="../js/menu_aside.js"></script>
	<script src="../js/menu_desplegable.js"></script>
</body>

</html>