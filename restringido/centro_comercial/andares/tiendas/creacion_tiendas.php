<?php 
	session_start();
	require '../../../security.php';
	
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
						<div class="logoT">
							<label class="label" for="logoTienda"><strong>Logo de tienda</strong></label>
							<div class="contentL">
								<div class="box"></div>
								<div class="ip">
									<label for="logoTienda" >
									<input type="file" id="logoTienda" name="logoTienda">
								</div>
							</div>
						</div>
						<div class="categorias">
							<label class="label"><strong>Categorías de la tienda</strong></label>
							
							<div class="contentC">
								<div class="scrollable-box" id="checkbox-list">
									<label class="categoria" for="categoria1T">	
										<input type="checkbox" name="categoria1T" value="1">
										Categoría 1
									</label>

									<label class="categoria" for="categoria2T">	
										<input type="checkbox" name="categoria2T" value="2">
										Categoría 2
									</label>

									<label class="categoria" for="categoria3T">	
										<input type="checkbox" name="categoria3T" value="3">
										Categoría 3
									</label>

									<label class="categoria" for="categoria4T">	
										<input type="checkbox" name="categoria4T" value="4">
										Categoría 4
									</label>

									<label class="categoria" for="categoria5T">	
										<input type="checkbox" name="categoria5T" value="5">
										Categoría 5
									</label>

									<label class="categoria" for="categoria6T">	
										<input type="checkbox" name="categoria6T" value="6">
										Categoría 6
									</label>

									<label class="categoria" for="categoria7T">	
										<input type="checkbox" name="categoria7T" value="7">
										Categoría 7
									</label>

									<label class="categoria" for="categoria8T">	
										<input type="checkbox" name="categoria8T" value="8">
										Categoría 8
									</label>

									<label class="categoria" for="categoria9T">	
										<input type="checkbox" name="categoria9T" value="9">
										Categoría 9
									</label>
								</div>
							</div>
							
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
										<input type="file" id="fileInput">
									</div>
								</div>
								<div>
									<div class="box"></div>
									<div class="ip">
										<label for="fileInput" >
										<input type="file" id="fileInput">
									</div>
								</div>
								<div>
									<div class="box"></div>
									<div class="ip">
										<label for="fileInput" >
										<input type="file" id="fileInput">
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