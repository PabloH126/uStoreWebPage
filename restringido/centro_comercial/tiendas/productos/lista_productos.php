 <?php 
	session_start();
	require '../../../security.php';

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
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Selección de productos</title>
	<?php require("../../templates/template.styles.php")?>
	<?php require("../templates/template.secc_tiendas.php")?>
	<link rel="stylesheet" type="text/css" href="../css/lista_tiendas.css">
</head>
<body>
	<?php require("../../templates/template.menu.php")?>

	<div class="content">
		<div class="lista">
			<?php 
				if($productosError != null)
				{ ?>
				<h3><?php echo $productosError;?></h3>
			<?php 
				}
				else
				{ 
				foreach ($productos as $producto)
				{ ?>
					<div class="item">
						<a href=""><img width="60%" class="logo" src="<?php echo 'imagen del producto'; ?>"></a>
						<strong class="nombre"><?php echo $producto['nombreProducto'];?></strong>
					</div>
			<?php
				}
			?>
					<div class="item" id="agregar">
						<a href=""><span class="material-symbols-outlined">add</span></a>
					</div>
			<?php
				}
			?>
		</div>
	</div>
</body>
</html>