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

$fechaRegistro = DateTime::createFromFormat('Y-m-d\TH:i:s', $perfil['fechaRegistro'], new DateTimeZone('UTC'));
$fechaRegistro->setTimezone(new DateTimeZone('Etc/GMT+6'));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Categorias/GetCategorias");
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

$categorias = json_decode($response, true);

curl_close($ch);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/GetTiendas?idCentroComercial=" . $_SESSION['idMall']);
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
	$tiendasError = "Error al intentar recuperar las tiendas. Codigo de respuesta: " . $httpStatusCode;
}
$tiendas = json_decode($response, true);
curl_close($ch);

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Perfil</title>
	<?php require("../templates/template.styles.php"); ?>
	<?php require("templates/template.secc_perfil.php"); ?>
	<?php //require("../tend/template.perfil_graficas.php.secc_tendencias_venta.php") ?>
</head>

<body>
	<?php require("../templates/template.menu.php") ?>

	<div class="content">
		<?php
		if (isset($perfilError)) {
			echo $perfilError;
		} else {
			?>
			<?php require("templates/template.header_profile.php") ?>
			<div class="aside_profile">
				<?php require("../templates/template.aside.php") ?>
				<div class="body">
					<canvas id="grafica"></canvas>
					<span id="span-seleccion-tienda">Selecciona una opción de filtro</span>
				</div>

				<div class="floating_bttns">

					<div id="filterList">
						<div id="divIconBackground" style="display: none">
							<div class="content-background-animated">
								<div id="background-animated"></div>
							</div>
							<i class='bx bx-menu' id="menu-icon"></i>
						</div>
						<div id="sub-menu">
							<?php
							if (isset($tiendasError)) {
								echo "Hubo un error al recuperar las sucursales";
							} else {
								foreach ($tiendas as $tienda) {
									echo '<div class="menu-option" data-tienda-id="' . $tienda['idTienda'] . '"><a id="">' . $tienda['nombreTienda'] . '</a></div>';
								}
							}
							?>
						</div>
					</div>

					<div class="crear-publicacion" id="btnCrearPubli">
						<a title="Descargar">
							<i class='bx bxs-download' id="menu-icon2"></i>
						</a>
						<div id="sub-menu2">
							<div class="menu-option"><a id="downloadPDF">PDF</a></div>
							<div class="menu-option"><a id="downloadImage">PNG</a></div>
						</div>
					</div>
				</div>

			</div>
			<?php
		}
		?>
	</div>
	<input type="hidden" id="isPerfil">
	<?php require("templates/template.scripts_perfil_grafica.php"); ?>
	<script src="js/actualizar_imagen.js"></script>
</body>

</html>