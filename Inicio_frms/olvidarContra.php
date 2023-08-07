<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Olvido de contraseña</title>

	<?php require("templates/template.styles_frms.php")?>
	<link rel="stylesheet" type="text/css" href="css_frms/olvidarContra.css">
	<link rel="stylesheet" type="text/css" href="css_frms/frms.css">
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
			<div class="formulario__mensaje-exito <?php 
						echo (isset($_SESSION['CNV']) && $_SESSION['CNV'] == false) ? 'formulario__mensaje-exito-activo' : ''; 
						// Limpia la variable de sesión una vez que se ha mostrado el mensaje
						if (isset($_SESSION['CNV']) && $_SESSION['CNV'] == false) {
							unset($_SESSION['CNV']);
						}
					?>">
			<p><i class="fa-solid fa-circle-check"></i> Correo enviado</p>
			</div>
			<div class="formulario__mensaje 
					<?php 
						echo (isset($_SESSION['CNV']) && $_SESSION['CNV'] == true) ? 'formulario__mensaje-activo' : ''; 
						// Limpia la variable de sesión una vez que se ha mostrado el mensaje
						if (isset($_SESSION['CNV']) && $_SESSION['CNV'] == true) {
							unset($_SESSION['CNV']);
						}
					?>" 
					id="formulario__mensaje">
					<p style="color: #d51b1b"><i class="fa-solid fa-triangle-exclamation fa-bounce"
							style="color: #cc0000;"></i> Correo no registrado </p>
				</div>
			
			<div class="formulario__grupo formulario__grupo-btn-enviar">
				<input class="submit" type="submit" value="Enviar correo">
			</div>
		</form>
	</div>
	<script src="https://kit.fontawesome.com/4995f75cde.js" crossorigin="anonymous"></script>
</body>
</html>