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
			<div class="form">
				<form class="izquierda">
					<div id="nombre">
						<label class="label" for="nombreTienda">Nombre de tienda</label>
						<input type="text" name="nombreTienda">
					</div>
					<div class="">
						<label class="label" for="logoTienda">Logo de tienda</label>
						<input type="file" name="logoTienda">
					</div>
					<div class="categorias">
						<label class="label">Categorías de la tienda</label>
						<div class="categoria">
							<input type="checkbox" name="categoria1T" value="1">
							<label for="categoria1T">Categoría 1</label>
						</div>
						<div class="categoria">
							<input type="checkbox" name="categoria2T" value="2">
							<label for="categoria2T">Categoría 2</label>
						</div>
					</div>
				</form>
				<form class="derecha">
					<div class="promociones">
						<label class="label">Imágenes promocionales</label>
						<div>
							<input type="file" name="imagen1">
							<input type="file" name="imagen2">
							<input type="file" name="imagen3">
						</div>
					</div>
					<div class="horario">
						<label class="label">Horario</label>
						<div>
							<div class="lunes">
								<label>Lunes</label>
								<div>
									<select>12</select>
									<select>00</select>
									<select>pm</select>
								</div>
								<label> - </label>
								<div>
									<select>11</select>
									<select>00</select>
									<select>pm</select>
								</div>
							</div>
							<div class="martes">
								<label>Martes</label>
								<div>
									<select></select>
									<select></select>
									<select></select>
								</div>
								<label> - </label>
								<div>
									<select></select>
									<select></select>
									<select></select>
								</div>
							</div>
						</div>
					</div>
				</form>
				<!-- <input id="guardar" type="submit" name="Guardar"> -->
			</div>
			
		</div>
	</div>
</body>
</html>