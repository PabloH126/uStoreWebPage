<?php
session_start();
if(!isset($_COOKIE['SessionData']))
{
	header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Selección de plaza</title>
	<?php require("templates/template.styles.php") ?>
	<link rel="stylesheet" type="text/css" href="css/seleccionPlaza.css">

</head>

<body>
	<?php require("templates/template.header_cs.php") ?>
	<div class="content">
		<h1>Selección de plaza</h1>
		
			<?php
				if(isset($_COOKIE['SessionData']))
				{
					$data = json_decode($_COOKIE['SessionData'], true);

					$nombre = $data['primerNombre'];
			?>
					<h3>Bienvenido, <?php echo $nombre ?></h3>
			<?php
				}
				else
				{
			?>
					<h3>Error, vuelve a iniciar sesion</h3>
			<?php
				}
			?>
		<div class="lista">
			<div class="item">
				<a href="centro_comercial/andares/tiendas/lista_tiendas.php"><img width="80%" class="logo"
						onmouseout="this.src='img/logo_andares.png';" onmouseover="this.src='img/img_andares1.jpg';"
						src="img/logo_andares.png"></a>
				<strong class="nombre">Andares</strong>
				<span class="direccion">Blvrd Puerta de Hierro 4965, Guadalajara, Jal.</span>
				<strong class="horario">11:00 - 21:00</strong>
			</div>
		</div>
	</div>
</body>

</html>