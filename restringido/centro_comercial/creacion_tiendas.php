<?php 
	session_start();
	require '../security.php';
	
	function SelectHoras($dia, $periodo) {
		echo '<select name="horas' . $dia . $periodo . '" id="horas">';
		for ($i = 0; $i < 13; $i++) {
			echo '<option value="' . str_pad($i, 2, '0', STR_PAD_LEFT) . '">' . str_pad($i, 2, '0', STR_PAD_LEFT) . '</option>';
		}
		echo '</select>';
	}
	
	function SelectMinutos($dia, $periodo) {
		echo '<select name="minutos' . $dia . $periodo . '" id="minutos">';
		for ($i = 0; $i < 60; $i++) {
			echo '<option value="' . str_pad($i, 2, '0', STR_PAD_LEFT) . '">' . str_pad($i, 2, '0', STR_PAD_LEFT) . '</option>';
		}
		echo '</select>';
	}
	
	function SelectAMPM($dia, $periodo) {
		echo '<select name="am/pm' . $dia . $periodo . '" id="am/pm">';
		echo '<option value="am">am</option>';
		echo '<option value="pm">pm</option>';
		echo '</select>';
	}

	function diasSelect($dia) {
		echo '<div class="dia">';
			echo '<label>' . $dia . '</label>';

			echo '<div>';
				SelectHoras($dia, 'apertura');
				SelectMinutos($dia, 'apertura');
				SelectAMPM($dia, 'apertura');
			echo '</div>';

			echo '<label> - </label>';
			
			echo '<div>';
				SelectHoras($dia, 'cierre');
				SelectMinutos($dia, 'cierre');
				SelectAMPM($dia, 'cierre');
			echo '</div>';
		echo '</div>';
	}


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Categorias/GetCategorias");
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
	
	$categorias = json_decode($response, true);

	curl_close($ch);
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Crear tienda</title>
	<?php require("templates/template.styles.php")?>
	<?php require("tiendas/templates/template.secc_tiendas.php")?>
	<link rel="stylesheet" type="text/css" href="tiendas/css/creacion_tiendas.css">
</head>
<body>
	<?php require("templates/template.menu.php")?>
	<div class="content">
		<h1>Creación de tienda</h1>
		<div class="lista">
			<form action="envio_tienda.php" method="post" enctype="multipart/form-data">
				<div class="forms">
					<div class="izquierda">
						<div id="nombre">
							<label class="label" for="nombreTienda"><strong>Nombre de tienda</strong></label>
							<input type="text" name="nombreTienda" required>
						</div>
						<div class="logoYApartados">
							<div class="logoT">
								<label class="label" for="logoTienda"><strong>Logo de la tienda</strong></label>
								<div class="contentL">
									<div class="box"></div>
									<div class="ip">
										<label for="logoTienda" >
										<input type="file" id="logoTienda" name="logoTienda" required>
									</div>
								</div>
							</div>
							<div class="Apartados">
								<label for=""><strong>Tiempo default de apartados</strong></label>

							</div>
						</div>
						
						<div class="categorias">
							<label class="label"><strong>Categorías de la tienda</strong required></label>
							
							<div class="contentC">
								<div class="scrollable-box" id="checkbox-list">
									<?php 
										foreach ($categorias as $categoria) 
										{
									?>
									<label class="categoria" for="categoria<?php echo $categoria['idCategoria'] ?>T">	
										<input type="checkbox" name="categorias[]" value="<?php echo $categoria['idCategoria'] ?>">
										<?php echo $categoria['categoria1'] ?>
									</label>
									<?php
										}
									?>
								</div>
							</div>
						</div>	
						<div class="notas">
							<span>* Imágenes en formato de imagen JPG, PNG o JPEG</span>
						</div>
					</div>
					<div class="derecha">
						<div class="promociones">
							<label class="label"><strong>Imágenes promocionales</strong></label>
							<div class="imageP">
								<div>
									<div class="box"></div>
									<div class="ip">
										<label for="fileInput" >
										<input type="file" id="fileInput" name="imagen1" required>
									</div>
								</div>
								<div>
									<div class="box"></div>
									<div class="ip">
										<label for="fileInput" >
										<input type="file" id="fileInput" name="imagen2" required>
									</div>
								</div>
								<div>
									<div class="box"></div>
									<div class="ip">
										<label for="fileInput" >
										<input type="file" id="fileInput" name="imagen3" required>
									</div>
								</div>
							</div>
						</div>
						<div class="horario">
							<label class="label"><strong>Horario</strong></label>
							<div class="dias">
								<?php 
									diasSelect("Lunes");
									diasSelect("Martes");
									diasSelect("Miércoles");
									diasSelect("Jueves");
									diasSelect("Viernes");
									diasSelect("Sábado");
									diasSelect("Domingo");
								?>
							</div>
						</div>
						<div class="notas">
							<span>* Si es día no laboral, dejar su configuración en su forma inicial.</span>
							
						</div>
					</div>
				</div>
				<div class="boton">
					<input type="submit" name="" value="Guardar">
				</div>
			</form>
		</div>
	</div>
	<script src="js/creacion_tiendas.js"></script>
</body>
</html>