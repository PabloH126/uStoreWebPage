<?php
    session_start();
    $idTienda = $_SESSION['idTienda'];
    $idMall = $_SESSION['idMall'];
    $idUser = $_SESSION['id'];

    $ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Productos/GetProductos?idTienda=" . $idTienda);
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
	<link rel="stylesheet" type="text/css" href="https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/css/confirmacion_eliminacion.css">
	<link rel="stylesheet" href="css/lista_productos.css">
	<link rel="stylesheet" type="text/css" href="../css/lista_tiendas.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="js/actualizar_stock.js"></script>
	
</head>
<body>
	<?php require("../../templates/template.menu.php")?>

	<div class="content">
		<div class="lista">
			<?php 
				if(isset($productosError))
				{ ?>
				<h3><?php echo $productosError;?></h3>
			<?php 
				}
				else
				{ 
				?>
					<div class="item" id="agregar">
						<a href="creacion_productos.php?id=<?php echo $_GET['id']; ?>"><span class="material-symbols-outlined">add</span></a>
					</div>
				<?php

				foreach ($productos as $producto)
				{ ?>
					<div class="item">
						<a href="perfil_producto.php?id=<?php echo $producto['idProductos']; ?>"><img width="60%" class="logo" src="<?php echo $producto['imageProducto']; ?>" ts=<?php echo time(); ?>></a>
						<strong class="nombre"><?php echo $producto['nombreProducto'];?></strong>
						<div class="switch">
							<label class="switch-label">
                    	        <input type="checkbox" class="switch-input" data-producto-id="<?php echo $producto['idProductos']; ?>" <?php echo $producto['stock'] > 0 ? 'checked' : ''; ?>>
                	            <span class="slider round"></span>
            	            </label>
        	                <span class="stock-status <?php echo $producto['stock'] > 0 ? 'stock-available' : 'stock-unavailable'; ?>">
    	                        <?php echo $producto['stock'] > 0 ? 'En stock' : 'Sin stock'; ?>
	                        </span>
                    	</div>
					</div>
				<?php
				}
				}
			?>
		</div>
	</div>
</body>
</html>