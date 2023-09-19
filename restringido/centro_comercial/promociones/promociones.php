<?php
session_start();
require '../../security.php';

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Publicaciones/GetPublicacionesRecientes?idMall=" . $_SESSION['idMall']);
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
	$publicaciones = json_decode($response, true);
	curl_close($ch);
	
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
		<div id="select-store">
			<?php
				if (!isset($_GET['id']))
				{
			?>
				<div id="background-animated"></div>
			<?php 
				} 
			?>

			<i class='bx bx-store-alt' id="menu-icon" data-toggle="menu"></i>
			
			<div id="sub-menu">
				<?php foreach ($tiendas as $tienda)
				{
					echo '
					<div class="menu-option">
						<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/solicitudes_apartado/solicitudes_apartado.php?id=' . $tienda['idTienda'] . '">' . $tienda['nombreTienda'] . '</a>
					</div>
					';
				};
				?>
			</div>
		</div>


        <div class="content-ofertas">
            <?php
			foreach($publicaciones as $publicacion)
			{
			?>
			<div class="space-publication">
                <div class="header-publication">
                    <img src="<?php echo $publicacion['logoTienda']; ?>" alt="logoTienda">
                    <label class="name"><?php echo $publicacion['nombreTienda']; ?></label>
                </div>
                <div class="body-publication">
                    <p><?php echo $publicacion['contenido']; ?></p>
					<?php
					if(isset($publicacion['imagen']))
					{
					?>
                    <img src="<?php echo $publicacion['imagen']; ?>"
                        alt="imagenPublicacion">
					<?php
					}
					?>
                </div>
            </div>
            <hr>
			<?php
			}
			?>
        </div>
		<div class="crear-publicacion">
			<a title="Crear publicación" href="crear_publicacion.php">
				<span class="material-symbols-outlined">add</span>
			</a>
		</div>	
	</div>
</body>

</html>