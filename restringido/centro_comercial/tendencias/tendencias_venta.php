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
			<h1>Tendencias de venta</h1>
		</div>

		<aside>
            <ul class="list">
                
                <li class="list_item">
                    <div class="list_button list_button--click">
                        <!--imagen bonita de referencia-->
                        <p>Grafica de</p>
                        <i class='bx bxs-right-arrow'></i>
                    </div>

                    <ul class="list_show">
                        <li class="list_inside">
                            <p>Tiendas</p>
                            <p>Productos</p>
                        </li>
                    </ul>
                </li>
            </ul>
			
		</aside>

		<div>

		</div>
	</div>
	<script src="js/menu_desplegable.js"></script>
</body>

</html>