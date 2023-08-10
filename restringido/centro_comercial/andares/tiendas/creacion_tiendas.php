<?php 
	session_start();
	require '../../../security.php';;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/CreateTienda");
	curl_setopt($ch, CURLOPT_POST, 1);
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
			<form>
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
							<div>
								<input type="file" name="imagen1">
								<input type="file" name="imagen2">
								<input type="file" name="imagen3">
							</div>
						</div>
						<div class="horario">
							<label class="label"><strong>Horario</strong></label>
							<div>
								<div class="lunes">
									<label>Lunes</label>
									<div>
										<select name="horas" id="horas">
										<?php 
											for($i = 00; $i < 13; $i++)
											{
										?>
											<option value="<?php echo $i; ?>"></option>	
										</select>
										<?php 
											}
										?>
										<select name="minutos" id="minutos">
										<?php
										 	for($i = 00; $i < 60; $i++)
											{
										?>
											<option value="<?php echo $i; ?>"></option>	
										</select>
										<?php 
											} 
										?>
										<select name="am/pm" id="am/pm">
											<option value="am"></option>
											<option value="pm"></option>
										</select>
									</div>
									<label> - </label>
									<div>
										<select name="horas" id="horas">
										<?php 
											for($i = 00; $i < 13; $i++)
											{
										?>
											<option value="<?php echo $i; ?>"></option>	
										</select>
										<?php 
											}
										?>
										<select name="minutos" id="minutos">
										<?php
										 	for($i = 00; $i < 60; $i++)
											{
										?>
											<option value="<?php echo $i; ?>"></option>	
										</select>
										<?php 
											} 
										?>
										<select name="am/pm" id="am/pm">
											<option value="am"></option>
											<option value="pm"></option>
										</select>
									</div>
								</div>
								<div class="martes">
									<label>Martes</label>
									<div>
										<select name="horas" id="horas">
										<?php 
											for($i = 00; $i < 13; $i++)
											{
										?>
											<option value="<?php echo $i; ?>"></option>	
										</select>
										<?php 
											}
										?>
										<select name="minutos" id="minutos">
										<?php
										 	for($i = 00; $i < 60; $i++)
											{
										?>
											<option value="<?php echo $i; ?>"></option>	
										</select>
										<?php 
											} 
										?>
										<select name="am/pm" id="am/pm">
											<option value="am"></option>
											<option value="pm"></option>
										</select>
									</div>
									<label> - </label>
									<div>
										<select name="horas" id="horas">
										<?php 
											for($i = 00; $i < 13; $i++)
											{
										?>
											<option value="<?php echo $i; ?>"></option>	
										</select>
										<?php 
											}
										?>
										<select name="minutos" id="minutos">
										<?php
										 	for($i = 00; $i < 60; $i++)
											{
										?>
											<option value="<?php echo $i; ?>"></option>	
										</select>
										<?php 
											} 
										?>
										<select name="am/pm" id="am/pm">
											<option value="am"></option>
											<option value="pm"></option>
										</select>
									</div>
								</div>
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