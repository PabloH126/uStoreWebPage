<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Recuperación de cuenta</title>

	<?php require("https://ustoree.azurewebsites.net/Inicio_frms/templates/template.styles_frms.php")?>
	<link rel="stylesheet" type="text/css" href="https://ustoree.azurewebsites.net/Inicio_frms/css_frms/recuperacionCuenta.css">
</head>
<body>
<?php require("https://ustoree.azurewebsites.net/Inicio_frms/templates/template.header_is.php")?>
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
			<div class="formulario__mensaje <?php 
						//Cuando el token esta expirado
						echo (isset($_SESSION['TokenExpirado']) && $_SESSION['TokenExpirado'] == true) ? 'formulario__mensaje-activo' : '';
						// Limpia la variable de sesión una vez que se ha mostrado el mensaje
						if (isset($_SESSION['TokenExpirado']) && $_SESSION['TokenExpirado'] == true) {
							unset($_SESSION['TokenExpirado']);
						}
					?>" id="formulario__mensaje">
					<p style="color: #d51b1b"><i class="fa-solid fa-triangle-exclamation fa-bounce"
							style="color: #cc0000;"></i> Link expirado</p>
			</div>
			<div class="formulario__mensaje <?php 
						//Cuando la contraseña es de menos de 8 caracteres
						echo (isset($_SESSION['ContraNV']) && $_SESSION['ContraNV'] == true) ? 'formulario__mensaje-activo' : '';
						// Limpia la variable de sesión una vez que se ha mostrado el mensaje
						if (isset($_SESSION['ContraNV']) && $_SESSION['ContraNV'] == true) {
							unset($_SESSION['ContraNV']);
						}
					?>" id="formulario__mensaje">
					<p style="color: #d51b1b"><i class="fa-solid fa-triangle-exclamation fa-bounce"
							style="color: #cc0000;"></i> La contraseña debe ser de al menos 8 caracteres</p>
			</div>

			<div class="formulario__mensaje <?php 
					//Cuando las contraseñas son diferentes
						echo (isset($_SESSION['ContrasenasDif']) && $_SESSION['ContrasenasDif'] == true) ? 'formulario__mensaje-activo' : '';
						// Limpia la variable de sesión una vez que se ha mostrado el mensaje
						if (isset($_SESSION['ContrasenasDif']) && $_SESSION['ContrasenasDif'] == true) {
							unset($_SESSION['ContrasenasDif']);
						}
					?>" id="formulario__mensaje">
					<p style="color: #d51b1b"><i class="fa-solid fa-triangle-exclamation fa-bounce"
							style="color: #cc0000;"></i> Las contraseñas no coinciden </p>
			</div>

			<div class="formulario__grupo formulario__grupo-btn-enviar">
				<input class="submit" type="submit" value="Aceptar">
			</div>
		</form>
	</div>
	<script src="https://kit.fontawesome.com/4995f75cde.js" crossorigin="anonymous"></script>
</body>
</html>