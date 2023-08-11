<?php 
	session_start();
	require '../../../security.php';
	
	function SelectHoras() {
		echo '<select name="horas" id="horas">';
		for ($i = 0; $i < 13; $i++) {
			echo '<option value="' . str_pad($i, 2, '0', STR_PAD_LEFT) . '">' . str_pad($i, 2, '0', STR_PAD_LEFT) . '</option>';
		}
		echo '</select>';
	}
	
	function SelectMinutos() {
		echo '<select name="minutos" id="minutos">';
		for ($i = 0; $i < 60; $i++) {
			echo '<option value="' . str_pad($i, 2, '0', STR_PAD_LEFT) . '">' . str_pad($i, 2, '0', STR_PAD_LEFT) . '</option>';
		}
		echo '</select>';
	}
	
	function SelectAMPM() {
		echo '<select name="am/pm" id="am/pm">';
		echo '<option value="am">am</option>';
		echo '<option value="pm">pm</option>';
		echo '</select>';
	}

	function diasSelect($dia) {
		echo '<div class="dia">';
			echo '<label>' . $dia . '</label>';

			echo '<div>';
				SelectHoras();
				SelectMinutos();
				SelectAMPM();
			echo '</div>';

			echo '<label> - </label>';
			
			echo '<div>';
				SelectHoras();
				SelectMinutos();
				SelectAMPM();
			echo '</div>';
		echo '</div>';
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Crear tienda</title>
	<?php require("../../templates/template.styles.php")?>
	<?php require("templates/template.secc_tiendas.php")?>
	<link rel="stylesheet" type="text/css" href="css/creacion_tiendas.css">
</head>
<body>
	<?php require("../../templates/template.menu.php")?>
	<div class="content">
		<h1>Creación de tienda</h1>
		<div class="lista">
			<form action="envio_tienda.php" method="post" enctype="multipart/form-data">
				<div class="forms">
					<div class="izquierda">
						<div id="nombre">
							<label class="label" for="nombreTienda"><strong>Nombre de tienda</strong></label>
							<input type="text" name="nombreTienda">
						</div>
						<div class="">
							<label class="label" for="logoTienda"><strong>Logo de tienda</strong></label>
							<input type="file" name="logoTienda">
						</div>
						<div class="categorias">
							<label class="label"><strong>Categorías de la tienda</strong></label>
							<div class="categoria">
								<input type="checkbox" name="categoria1T" value="1">
								<label for="categoria1T">Categoría 1</label>
							</div>
							<div class="categoria">
								<input type="checkbox" name="categoria2T" value="2">
								<label for="categoria2T">Categoría 2</label>
							</div>
						</div>	
					</div>
					<div class="derecha">
						<div class="promociones">
							<label class="label"><strong>Imágenes promocionales</strong></label>
							<div class="imageP">
								<label for="fileInput" >
								<input type="file" id="fileInput">
							</div>
							<div class="imageP">
								<label for="fileInput" >
								<input type="file" id="fileInput">
							</div>
							<div class="imageP">
								<label for="fileInput" >
								<input type="file" id="fileInput">
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
					</div>
				</div>
				<div class="boton">
					<input type="submit" name="" value="Guardar">
				</div>
			</form>
		</div>
	</div>
</body>
</html>