<?php 
	session_start(); 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Clave de confirmación</title>
	<?php require("templates/template.styles_frms.php")?>
	<link rel="stylesheet" type="text/css" href="css_frms/claveAdmins.css">
</head>
<body>
<?php require("templates/template.header_is.php")?>
<div id="content">
	<div class="form">
		<form style="text-align: center;" action="envio_frms/registroAdmin.php" method="post" id="ClaveAdmin">
			<h1>Clave de administrador</h1>
			<div class="formulario__grupo" id="grupo_clave">
				<input id="clave" class="input" type="text" name="claveA" placeholder="AA35B8SP" required>
				<p style="margin-bottom: 7px;"><a href="../correo.php">No me llegó ningún correo</a></p>

				<i class="formulario__validacion-estado fa-solid fa-circle-xmark fa-bounce"></i>
			</div>
			<p class="formulario__input-error" style="color: #d51b1b">La clave no es correcta</p>

			<div class="formulario__mensaje
				<?php
					echo (isset($_SESSION['falloClave']) && $_SESSION['falloClave'] == 1) ? 'formulario__mensaje-activo' : ''; 
					// Limpia la variable de sesión una vez que se ha mostrado el mensaje
					if (isset($_SESSION['falloClave']) && $_SESSION['fallo'] == 1) {
						unset($_SESSION['falloClave']);
					}
				?>" 
				id="formulario__mensaje">
				<p style="color: #d51b1b"><i class="fa-solid fa-triangle-exclamation fa-bounce" style="color: #cc0000;"></i> Clave incorrecta</p>
			</div>

			<div class="formulario__grupo formulario__grupo-btn-enviar">
				<input class="submit" type="submit" value="Registrarse"/>
			</div>
		</form>
	</div>
	<script src="https://kit.fontawesome.com/4995f75cde.js" crossorigin="anonymous"></script>
</body>
</html>
