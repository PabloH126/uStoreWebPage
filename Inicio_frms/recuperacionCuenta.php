<?php
	session_start();
?>

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
		<form action="envio_frms/actualizarContraA.php?token=<?php echo $_GET['token']; ?>" method="post">
			<h1>Recuperación de cuenta</h1>
			<div>
				<label for="passA" pattern=".{8,}">Nueva contraseña</label>
				<input class="input" type="password" name="passA" placeholder="***********" required>
			</div>
			<div>
				<label for="repassA" pattern=".{8,}">Confirmación de contraseña</label>
				<input class="input" type="password" name="repassA" placeholder="***********" required>
			</div>
			<!--------------- PRUEBA --------------->
			<div class="formulario__mensaje <?php 
						echo (isset($_SESSION['TokenExpirado']) && $_SESSION['TokenExpirado'] == true) ? 'formulario__mensaje-activo' : '';
						// Limpia la variable de sesión una vez que se ha mostrado el mensaje
						if (isset($_SESSION['TokenExpirado']) && $_SESSION['TokenExpirado'] == true) {
							unset($_SESSION['TokenExpirado']);
						}
					?>" id="formulario__mensaje">
					<p style="color: #d51b1b"><i class="fa-solid fa-triangle-exclamation fa-bounce"
							style="color: #cc0000;"></i> Token Expirado :c</p>
				</div>



			<div class="formulario__grupo formulario__grupo-btn-enviar">
				<input class="submit" type="submit" value="Aceptar">
			</div>
		</form>
	</div>
</body>
</html>