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
	*/
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Publicación de promociones</title>
	<?php require("../templates/template.styles.php") ?>
	<?php require("templates/template.secc_promociones.php") ?>
	<link rel="stylesheet" href="css/promociones.css">
</head>

<body>
	<?php require("../templates/template.menu.php") ?>

	<div class="content">
        <div class="content-ofertas">
            
            <div class="space-publication">
                <div class="header-publication">
                    <img src="https://i.blogs.es/c2d211/minato/840_560.jpeg" alt="mi poderosisimo minato">
                    <label class="name">mi poderosisimo minato como no</label>
                </div>
                <div class="body-publication">
                    <p>mi poderosisimo minato ❤ </p>
                    <img src="https://tierragamer.com/wp-content/uploads/2023/07/MinatoRasenganTierraGamer.png"
                        alt="otro poderosisimo minato como no">
                </div>
            </div>
            <hr>
            <div class="space-publication">
                <div class="header-publication">
                    <img src="https://i.blogs.es/c2d211/minato/840_560.jpeg" alt="mi poderosisimo minato">
                    <label class="name">mi poderosisimo minato como no</label>
                </div>
                <div class="body-publication">
                    <p>mi poderosisimo minato ❤ </p>
                    <img src="https://tierragamer.com/wp-content/uploads/2023/07/MinatoRasenganTierraGamer.png"
                        alt="otro poderosisimo minato como no">
                </div>
            </div>
        </div>
		<div class="crear-publicacion">
			<a title="Crear publicación" href="crear_publicacion.php">
				<span class="material-symbols-outlined">add</span>
			</a>
		</div>	
	</div>
</body>

</html>