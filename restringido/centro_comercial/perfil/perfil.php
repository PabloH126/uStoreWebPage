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
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
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

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Perfil</title>
	<?php require("../templates/template.styles.php"); ?>
	<?php require("templates/template.secc_perfil.php"); ?>
	<?php //require("../tendencias/templates/template.secc_tendencias_venta.php") ?>
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
						<div>
							<img src="<?php echo $perfil['imagenP']; ?>" alt="imagen de perfil">
							<svg width="1103" height="1071" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" overflow="hidden"><defs><clipPath id="clip0"><rect x="1265" y="204" width="1103" height="1071"/></clipPath><image width="695" height="675" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAArcAAAKjCAMAAAAwBNfIAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAADUExURQAAAKd6PdoAAAABdFJOU4CtXltGAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAB3UlEQVR4Xu3BAQEAAACCIP+vbkhAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABXaiuRAAGfIFB/AAAAAElFTkSuQmCC" preserveAspectRatio="none" id="img1"></image><clipPath id="clip2"><rect x="0" y="0" width="3055574" height="2967644"/></clipPath><image width="256" height="256" xlink:href="data:image/png;base64,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" preserveAspectRatio="none" id="img3"></image><clipPath id="clip4"><path d="M0.0806996-0.0340465 698269-0.0340465 698269 698269 0.0625 698269Z" fill-rule="evenodd" clip-rule="evenodd"/></clipPath></defs><g clip-path="url(#clip0)" transform="translate(-1265 -204)"><g transform="matrix(0.000360892 0 0 0.000360892 1265 204)"><g clip-path="url(#clip2)" transform="matrix(1.00024 0 0 1 0.0534668 -0.0422363)"><use width="100%" height="100%" xlink:href="#img1" transform="scale(4396.51 4396.51)"></use></g></g><g transform="matrix(0.000360892 0 0 0.000360892 1692 602)"><g clip-path="url(#clip4)"><use width="100%" height="100%" xlink:href="#img3" transform="matrix(2727.61 0 0 2727.61 0.0806996 -0.0340465)"></use></g></g></g></svg>
						</div>
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
			<div class="body">
				<canvas id="grafica"></canvas>	
				<span id="span-seleccion-tienda">Selecciona una opción de filtro</span>
			</div>

			<div class="floating_bttns">
				
				<div id="filterList">
					<i class='bx bx-menu' id="menu-icon" style="display: none"></i>
					<div id="sub-menu">
						<?php
						if(isset($tiendasError))
						{
							echo "Hubo un error al recuperar las sucursales";
						}
						else
						{
							foreach($tiendas as $tienda)
							{
								echo '<div class="menu-option" data-tienda-id="'. $tienda['idTienda'] .'"><a id="">'. $tienda['nombreTienda'] .'</a></div>';
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
</body>

</html>