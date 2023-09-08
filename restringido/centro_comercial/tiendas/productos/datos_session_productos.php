<?php
    session_start();
    $idTienda = 'holi';//$_SESSION['idTienda'];
    $idMall = $_SESSION['idMall'];
    $idUser = $_SESSION['id'];
    var_dump($_SESSION);

    $ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Productos/GetProductos?idTienda=" . $_GET['id']);
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
		$productosError = "Error al intentar recuperar los productos. Codigo de respuesta: " . $httpStatusCode;
	}

	$productos = json_decode($response, true);
	curl_close($ch);

    echo $productos;
?>