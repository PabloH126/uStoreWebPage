<?php
	session_start();

	if(!isset($_SESSION['fallo']) && !isset($_SESSION['emailRegistrado']))
	{
		session_unset();
		session_destroy();
	}

	if(isset($_COOKIE['SessionToken']))
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Login/getClaims");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $_COOKIE['SessionToken']
		)
		);

		$response = curl_exec($ch);

		if ($response === false) {
			echo 'Error: ' . curl_error($ch);
		} else {
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}

		if ($httpStatusCode != 200) {
			header("location: index.php");
		}

		curl_close($ch);
		$dataClaims = json_decode($response, true);
		
		$_SESSION['nombre'] = $dataClaims['nombre'];
		$_SESSION['email'] = $dataClaims['email'];
		$_SESSION['idUser'] = $dataClaims['id'];
		$_SESSION['UserType'] = $dataClaims['type'];

		if($_SESSION['UserType'] == "Administrador")
		{
			header("location: restringido/seleccionPlaza.php");
		}
		else
		{
			$_SESSION['idTiendaGerente'] = $dataClaims['idTienda'];
			header('location: https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/perfil_tienda.php?id=' . $_SESSION['idTiendaGerente']);
		}
		
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<title>Inicio de sesión y registro</title>
	
	<link rel="shortcut icon" type="text/css" href="img/icono_uStore1.png">
	<link rel="stylesheet" type="text/css" href="css_general/base.css">
	
	<link rel="stylesheet" type="text/css" href="Inicio_frms/css_frms/frms.css">
	<link rel="stylesheet" type="text/css" href="Inicio_frms/css_frms/index.css">

	<!----------GOOGLE FONTS -------->

	<!-------------Source Code Pro------->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@300&display=swap" rel="stylesheet">

	<!--ICONS FORMS-->
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body>
	<div id="contentI">
		
		<!--LOGIN DE ADMINISTRADORES-->
		<div class="form">
			<form action="Inicio_frms/envio_frms/inicioSesion_Admin.php" method="post" id="InicioSesionAdmin">
				<h1>Iniciar sesión</h1>
				<div>
					<span class="material-symbols-outlined">mail</span>
					<div id="box">
						<label for="emailAL">Correo electrónico</label>
						<input class="input" type="email" id="emailAL" name="emailAL" placeholder="ejemplo@gmail.com" required>
					</div>
				</div>
				<div>
					<span class="material-symbols-outlined">lock</span>
					<div id="box">
						<label for="passAL">Contraseña</label>
						<input class="input" type="password" id="passAL" name="passAL" placeholder="***********" required>
					</div>
				</div>
				<label class="checkbox">
					<input type="checkbox" checked="checked" name="rememberA">
					Recordarme
				</label>

				<div class="formulario__mensaje 
					<?php 
						echo (isset($_SESSION['fallo']) && $_SESSION['fallo'] == 1) ? 'formulario__mensaje-activo' : ''; 
						// Limpia la variable de sesión una vez que se ha mostrado el mensaje
						if (isset($_SESSION['fallo']) && $_SESSION['fallo'] == 1) {
							unset($_SESSION['fallo']);
						}
					?>" 
					id="formulario__mensaje">
					<p style="color: #d51b1b"><i class="fa-solid fa-triangle-exclamation fa-bounce"
							style="color: #cc0000;"></i> Credenciales incorrectas</p>
				</div>

				<div>
					<input class="submit" type="submit" value="Ingresar">
				</div>

				<div id="enlace">
					<a href="Inicio_frms/olvidarContra.php">¿Olvidaste tu contraseña?</a>
				</div>
			</form>
		</div>


		<!--REGISTRO DE ADMINISTRADORES-->
		<div class="form" id="formR">
			<form action="correo.php" method="post" id="RegistroAdmin">
				<h1>Registrarse</h1>

				<div class="formulario__grupo" id="grupo__nombre">
					<label for="nombreA" class="formulario__label">Primer nombre</label>
					<div class="formulario__grupo-input">
						<input class="input" class="input" type="text" name="nombreA" id="nombreA" placeholder="Nancy"
							required>
						<i class="formulario__validacion-estado fa-solid fa-circle-xmark fa-bounce"></i>
					</div>
					<p class="formulario__input-error" style="color: #d51b1b">El nombre no es válido</p><br>
				</div>

				<div class="formulario__grupo" id="grupo__apellido">
					<label for="apellidoA" class="formulario__label">Primer apellido</label>
					<div class="formulario__grupo-input">
						<input class="input" class="input" type="text" name="apellidoA" id="apellidoA"
							placeholder="Bañuelos" required>
						<i class="formulario__validacion-estado fa-solid fa-circle-xmark fa-bounce"></i>
					</div>
					<p class="formulario__input-error" style="color: #d51b1b">El apellido no es válido</p><br>
				</div>

				<div class="formulario__grupo" id="grupo__email">
					<label for="emailA" class="formulario__label">Correo electrónico</label>
					<div class="formulario__grupo-input">
						<input class="input" type="email" name="emailA" id="emailA" placeholder="ejemplo@gmail.com"
							required>
						<i class="formulario__validacion-estado fa-solid fa-circle-xmark fa-bounce"></i>
					</div>
					<p class="formulario__input-error" style="color: #d51b1b">El correo no es válido</p><br>
				</div>

				<div class="formulario__grupo" id="grupo__password">
					<label for="passA" pattern=".{8,}" class="formulario__label">Contraseña</label>
					<div class="formulario__grupo-input">
						<input class="input" class="input" type="password" name="passA" id="passA"
							placeholder="***********" required>
						<i class="formulario__validacion-estado fa-solid fa-circle-xmark fa-bounce"></i>
					</div>
					<p class="formulario__input-error" style="color: #d51b1b">La contraseña debe contener al menos 8
						caracteres</p><br>
				</div>

				<div class="formulario__grupo" id="grupo__repassword">
					<label for="repassA" pattern=".{8,}" class="formulario__label">Confirmación de contraseña</label>
					<div class="formulario__grupo-input">
						<input class="input" type="password" name="repassA" id="repassA" placeholder="***********"
							required>
						<i class="formulario__validacion-estado fa-solid fa-circle-xmark fa-bounce"></i>
					</div>
					<p class="formulario__input-error" style="color: #d51b1b">Las contraseñas no coinciden</p><br>
				</div>
				<div class="formulario__mensaje" id="formulario__mensajeEmail">
					<p style="color: #d51b1b"><i class="fa-solid fa-triangle-exclamation fa-bounce"
							style="color: #cc0000;"></i> Email ya registrado</p>
				</div>
				<div class="formulario__grupo formulario__grupo-btn-enviar">
					<input class="submit" type="submit" value="Enviar correo de confirmación" id="submitRegistro">
				</div>
			</form>
		</div>
	</div>
	<div id="animacion"></div>
	<script src="Inicio_frms/js_frms/RegistroAdmin.js"></script>
	<script src="Inicio_frms/js_frms/index.js"></script>
	<script src="https://kit.fontawesome.com/4995f75cde.js" crossorigin="anonymous"></script>
</body>
</html>