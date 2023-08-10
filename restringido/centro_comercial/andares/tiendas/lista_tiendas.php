<?php 
	session_start();
	require '../../../security.php';;

	$_SESSION['idMall'] = $_GET['id'];

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/GetTiendas?idCentroComercial=" . $_GET['id']);
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
	
	if ($httpStatusCode != 200) {
		$tiendasError = "Error al intentar recuperar las tiendas. Codigo de respuesta: " . $httpStatusCode;
	}
	$tiendas = json_decode($response, true);
	curl_close($ch);
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Selección de tienda</title>
	<?php require("../../templates/template.styles.php")?>
	<?php require("templates/template.secc_tiendas.php")?>
	<link rel="stylesheet" type="text/css" href="css/lista_tiendas.css">
</head>
<body>
	<?php require("../../templates/template.menu.php")?>

	<div class="content">
		<div class="lista">
			<?php 
				  if($mallsError != null)
				  { ?>
					<p><?php echo $tiendasError;?></p>
			<?php 
				  }
				  else
				  { 
					foreach ($tiendas as $tienda)
					{ ?>
			<div class="item">
				<a href=""><img width="60%" class="logo" src="<?php echo $tienda['logoTienda']; ?>"></a>
				<strong class="nombre"><?php echo $tienda['nombreTienda'];?></strong>
			</div>
			<?php
					}
				  }
			?>

			<div class="item" id="agregar">
				<a href="creacion_tiendas.php"><span class="material-symbols-outlined">add</span></a>
			</div>
		</div>
	</div>
</body>
</html>