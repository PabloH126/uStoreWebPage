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
	<?php require("../tendencias/templates/template.secc_tendencias_venta.php") ?>
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
							<p>Registrado desde: <?php echo $fechaRegistro->format('d-m-Y'); ?></p>
						</div>
					</div>
				</div>
				<div class="log-out">
					<a href="https://ustoree.azurewebsites.net/logOut.php"><img src="https://ustoree.azurewebsites.net/img/log_out.png" alt="Cerrar sesión"></a>
				</div>

			</div>
			<div class="top_menu_profile">
				<button class="graficas_option">Gráficas</button>
				<button class="gerentes_option">Gerentes</button>
			</div>
		</div>
		<div class="aside_profile">
			<?php require("../templates/template.aside.php") ?>

			<div id="filterList">
				<span class="material-symbols-outlined icon-filter" id="menu-icon">filter_list</span>
				<div id="sub-menu">
					<div class="menu-option"><a id="MayorMenor">Mayor a Menor</a></div>
					<div class="menu-option"><a id="MenorMayor">Menor a Mayor</a></div>
					<div class="menu-option"><a id="A-Z">Nombre: A-Z</a></div>
					<div class="menu-option"><a id="Z-A">Nombre: Z-A</a></div>
				</div>
			</div>
			<div class="body">
				<canvas id="grafica"></canvas>

				<div class="crear-publicacion" id="btnCrearPubli">				
					<a title="Descargar">
						<i class='bx bxs-download' id="menu-icon2"></i>
					</a>
				</div>	

				<div id="sub-menu2">
					<div class="menu-option"><a id="downloadPDF">PDF</a></div>
					<div class="menu-option"><a id="downloadImage">PNG</a></div>
				</div>
			</div>
			<span id="span-seleccion-tienda">Selecciona una opción de filtro</span>
		</div>
		<?php
		}
		?>
	</div>
	<script src="../js/menu_aside.js"></script>
	<script src="../js/menu_desplegable.js"></script>
	<script src="../tendencias/js/grafica.js"></script>
</body>

</html>