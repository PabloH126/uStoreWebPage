<?php
session_start();
require '../../security.php';
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

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Tendencias de venta</title>
	<?php require("../templates/template.styles.php") ?>
	<?php require("templates/template.secc_tendencias_venta.php") ?>
</head>

<body>
	<?php require("../templates/template.menu.php") ?>

	<div class="content">

		<?php require("../templates/template.aside.php") ?>

		<div class="grafic-area">
			<div class="title">
				<div>
					<h1>Tendencias de venta</h1>
				</div>
				<div id="filterList">
					<span class="material-symbols-outlined icon-filter" id="menu-icon">filter_list</span>
					<div id="sub-menu">
						<div class="menu-option"><a id="MayorMenor">Mayor a Menor</a></div>
						<div class="menu-option"><a id="MenorMayor">Menor a Mayor</a></div>
						<div class="menu-option"><a id="A-Z">Nombre: A-Z</a></div>
						<div class="menu-option"><a id="Z-A">Nombre: Z-A</a></div>
					</div>
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
					<div class="menu-option download-option"><a id="downloadPDF">PDF</a></div>
					<div class="menu-option download-option"><a id="downloadImage">PNG</a></div>
				</div>
			</div>
			<span id="span-seleccion-tienda">Selecciona una opción de filtro</span>
		</div>
		
	</div>
	<?php require("templates/template.scripts_tendencias.php") ?>
</body>

</html>