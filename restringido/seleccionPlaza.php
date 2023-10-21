<?php
session_start(); 
require 'security.php';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Login/getClaims");
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
	header("location: ../index.php");
}
$dataClaims = json_decode($response, true);

curl_close($ch);

$_SESSION['nombre'] = $dataClaims['nombre'];
$_SESSION['email'] = $dataClaims['email'];
$_SESSION['idUser'] = $dataClaims['id'];
$_SESSION['UserType'] = $dataClaims['type'];

if ($_SESSION['UserType'] == "Gerente")
{
	$_SESSION['idTiendaGerente'] = $dataClaims['idTienda'];
}

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Malls/GetAllMalls");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
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
	$mallsError = "Error al intentar recuperar las plazas. Codigo de respuesta: " . $httpStatusCode;
}
$malls = json_decode($response, true);

curl_close($ch);

if(isset($_SESSION['idMall']))
{
	unset($_SESSION['idMall']);
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
	<?php require("templates/template.header_cs.php"); ?>
	<div class="content">
		<h1>Selección de plaza</h1>
		
			<?php
				if(isset($_SESSION['nombre']))
				{
			?>
					<h3>Bienvenido(a), <?php echo $_SESSION['nombre']; ?></h3>
			<?php
				}
				else
				{
			?>
					<h3>Error, vuelve a iniciar sesión</h3>
			<?php
				}
			?>
		<div class="lista">
		  	<?php 
				  if($mallsError != null)
				  { ?>
					<p><?php echo $mallsError;?></p>
			<?php 
				  }
				  else
				  { 
					foreach ($malls as $mall)
					{ ?>
						<div class="item">
							<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/lista_tiendas.php?id=<?php echo $mall['idCentroComercial']?>">
							<img width="80%" class="logo"
									onmouseout="this.src='<?php echo $mall['iconoCentroComercial']; ?>';" 
									onmouseover="this.src='<?php echo $mall['imagenCentroComercial']; ?>';"
									src="<?php echo $mall['iconoCentroComercial']; ?>">
							</a>
							<strong class="nombre"><?php echo $mall['nombreCentroComercial']; ?></strong>
							<span class="direccion"><?php echo $mall['direccionCentroComercial']; ?></span>
							<strong class="horario"><?php echo $mall['horarioCentroComercial']; ?></strong>
						</div>
			<?php	
					}
				  }
			?>

		</div>
	</div>
</body>

</html>