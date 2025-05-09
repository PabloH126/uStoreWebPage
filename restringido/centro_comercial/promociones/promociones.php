<?php
session_start();
require '../../security.php';

if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
{

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
}

isset($_SESSION['idTiendaGerente']) ? ($_GET['id'] = $_SESSION['idTiendaGerente']) : '';

if (isset($_GET['id']))
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Publicaciones/GetPublicacionesRecientes?idTienda=" . $_GET['id']);
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
		$publicacionesError = "Error al intentar recuperar las publicaciones. Codigo de respuesta: " . $httpStatusCode;
	}
	$publicaciones = json_decode($response, true);
	curl_close($ch);
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Publicaciones de tienda</title>
	<?php require("../templates/template.styles.php") ?>
	<?php require("templates/template.secc_promociones.php") ?>
	<link rel="stylesheet" href="css/promociones.css">
</head>

<body>
	<?php require("../templates/template.menu.php") ?>

	<div class="content">
		<div class="title-options">
			<div id="content-menu-icon">
				<?php 
				if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
				{	?>
					<?php require("../templates/template.background_animated.php") ?>
					<i class='bx bx-store-alt store' id="menu-icon" data-toggle="menu"></i>
				<?php 
				} 
				?>
			</div>

			<?php 
			if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
			{	?>
				<div id="sub-menu">
					<?php foreach ($tiendas as $tienda)
					{
						echo '
						<div class="menu-option '. (isset($_GET['id']) && $_GET['id'] == $tienda['idTienda'] ? 'menuIconSelected' : '') .'">
							<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/promociones/promociones.php?id=' . $tienda['idTienda'] . '">' . $tienda['nombreTienda'] . '</a>
						</div>
						';
					};
					?>
				</div>
			<?php 
			} ?>
			<h1>Publicaciones de tienda</h1>
		</div>
		<?php
			if (!isset($_GET['id']))
			{
		?>
		<div>
			<span id="span-seleccion-tienda">Seleccione una tienda</span>
		</div>
		<?php
			}
			else if(isset($publicacionesError))
			{
		?>
		<div>
			<span><?php echo $publicacionesError; ?></span>
		</div>
		<?php
			}
			else
			{
		?>

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
		<?php } ?>
		<div class="crear-publicacion">
			<a title="Crear publicación"
			<?php 
			if(isset($_SESSION['UserType']) && $_SESSION['UserType'] == "Administrador")
			{	?>
				href="crear_publicacion.php"
			<?php
			} else{
			?>
				href="crear_publicacion_gerentes.php"
			<?php
			}
			?>
			 >
				<span class="material-symbols-outlined">add</span>
			</a>
		</div>	
	</div>
	<script src="../js/menu_desplegable.js"></script>
</body>

</html>