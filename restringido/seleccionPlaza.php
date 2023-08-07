<?php
session_start(); 
require 'security.php';
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
	header("location: ../index.php");
}
$data = json_decode($response, true);

curl_close($ch);

$_SESSION['nombre'] = $data['nombre'];
$_SESSION['email'] = $data['email'];
$_SESSION['id'] = $data['id'];
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
	<?php require("templates/template.header_cs.php"); ?>
	<div class="content">
		<h1>Selección de plaza</h1>
		
			<?php
				if(isset($_SESSION['nombre']))
				{
			?>
					<h3>Bienvenido, <?php echo $_SESSION['nombre']; ?></h3>
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