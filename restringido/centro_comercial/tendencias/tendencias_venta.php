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
	curl_close($ch);*/

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
		<div class="title">
			<div>
				<h1>Tendencias de venta</h1>
			</div>
			<div>
				<span class="material-symbols-outlined icon-filter" id="menu-icon">filter_list</span>
				<div id="sub-menu">
					<div class="menu-option"><a id="MayorMenor">Mayor a Menor</a></div>
					<div class="menu-option"><a id="downloadImage">Nombre: A-Z / Z-A </a></div>
				</div>
			</div>
		</div>

		<aside>
            <ul class="list">
                
                <li class="list_item">
                    <div class="list_button list_button--click">
                        <span class="material-symbols-outlined">bar_chart</span>
                        <p>Gráfica</p>
                        <i class='bx bx-chevron-right row'></i>
                    </div>

                    <ul class="list_show">
                        <li class="list_inside">
							<button class="bttnp p normal">Tiendas</button>
							<button class="bttnp p normal">Productos</button>
                        </li>
                    </ul>
                </li>

				<li class="list_item">
                    <div class="list_button list_button--click">
						<i class='bx bxs-category' ></i>
                        <p>Categorías</p>
                        <i class='bx bx-chevron-right row'></i>
                    </div>

                    <ul class="list_show">
                        <li class="list_inside">
							<form action="">
								<label for="categoria1"><input id="categoria1" type="checkbox"><p class="p">Categoria 1</p></label>
								<label for="categoria2"><input id="categoria2" type="checkbox"><p class="p">Categoria 2</p></label>
								<label for="categoria3"><input id="categoria3" type="checkbox"><p class="p">Categoria 3</p></label>
								<label for="categoria4"><input id="categoria4" type="checkbox"><p class="p">Categoria 4</p></label>
								<label for="categoria5"><input id="categoria5" type="checkbox"><p class="p">Categoria 5</p></label>
							</form>
                        </li>
                    </ul>
                </li>

				<li class="list_item">
                    <div class="list_button list_button--click">
						<i class='bx bxs-time-five'></i>
                        <p>Tiempo</p>
                        <i class='bx bx-chevron-right row'></i>
                    </div>

                    <ul class="list_show">
                        <li class="list_inside">
							<button class="bttnp p normal">Semanal</button>
							<button class="bttnp p normal">Quincenal</button>
							<button class="bttnp p normal">Mensual</button>
                        </li>
                    </ul>
                </li>
            </ul>
		</aside>
		<div class="body">
			<canvas id="grafica"></canvas>

			<div class="crear-publicacion">				
				<a title="Descargar">
					<i class='bx bxs-download' id="menu-icon"></i>
				</a>
			</div>	
			
			<div id="sub-menu">
				<div class="menu-option"><a id="downloadPDF">PDF</a></div>
				<div class="menu-option"><a id="downloadImage">PNG</a></div>
			</div>
			
		</div>
	</div>
	<?php require("templates/template.scripts_tendencias.php") ?>
</body>

</html>