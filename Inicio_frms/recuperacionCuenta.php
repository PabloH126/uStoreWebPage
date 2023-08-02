<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Recuperación de cuenta</title>

	<?php require("templates/template.styles_frms.php")?>
	<link rel="stylesheet" type="text/css" href="css_frms/recuperacionCuenta.css">
</head>
<body>
<?php require("templates/template.header_is.php")?>
<div id="content">
	<div class="form">
		<form action="envio_frms/actualizarContraA.php" method="post">
			<h1>Recuperación de cuenta</h1>
			<div>
				<label for="passA">Nueva contraseña</label>
				<input class="input" type="password" name="passA" placeholder="***********" required>
			</div>
			<div>
				<label for="repassA">Confirmación de contraseña</label>
				<input class="input" type="password" name="repassA" placeholder="***********" required>
			</div>
			<div>
				<input class="submit" type="submit" value="Aceptar">
			</div>
		</form>
	</div>
</body>
</html>