<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Olvido de contraseña</title>

	<?php require("templates/template.styles_frms.php")?>
	<link rel="stylesheet" type="text/css" href="css_frms/olvidarContra.css">
</head>
<body>
<?php require("templates/template.header_is.php")?>
<div id="content">
	<div class="form">
		<form action="../correoContrasena.php" method="post">
			<h1>Olvidé mi contraseña</h1>
			<div>
				<label for="emailRec">Correo con el que registró la cuenta</label>
				<input class="input" type="email" name="emailRec" placeholder="ejemplo@gmail.com" required>
			</div>
			<div>
				<input class="submit" type="submit" value="Enviar correo">
			</div>
		</form>
	</div>
</body>
</html>