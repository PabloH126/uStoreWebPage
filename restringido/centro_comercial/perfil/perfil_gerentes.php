<?php
session_start();
require '../../security.php';

//GET DATOS PERFIL

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Perfil/GetPerfil");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
	$ch,
	CURLOPT_HTTPHEADER,
	array(
		'Authorization: Bearer ' . $_COOKIE['SessionToken']
	)
);

$response = curl_exec($ch);

if ($response === false) {
	echo 'Error: ' . curl_error($ch);
} else {
	$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode == 400) {
	$perfilError = "Error al intentar recuperar las tiendas. Codigo de respuesta: " . $httpStatusCode;
}
$perfil = json_decode($response, true);
curl_close($ch);

$fechaRegistro = DateTime::createFromFormat('Y-m-d\TH:i:s', $perfil['fechaRegistro'], new DateTimeZone('UTC'));
$fechaRegistro->setTimezone(new DateTimeZone('Etc/GMT+6'));

//GET GERENTES ADMINISTRADOR

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Gerentes/Gerentes");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
	$ch,
	CURLOPT_HTTPHEADER,
	array(
		'Authorization: Bearer ' . $_COOKIE['SessionToken']
	)
);

$response = curl_exec($ch);

if ($response === false) {
	echo 'Error: ' . curl_error($ch);
} else {
	$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode == 400) {
	$tiendasError = "Error al intentar recuperar las tiendas. Codigo de respuesta: " . $httpStatusCode;
}
$gerentes = json_decode($response, true);
curl_close($ch);

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Perfil</title>
	<?php require("../templates/template.styles.php"); ?>
	<link rel="stylesheet" type="text/css" href="css/lista_gerentes.css">
	<?php require("templates/template.secc_perfil_gerentes.php"); ?>
</head>

<body>
	<?php require("../templates/template.menu.php") ?>

	<div class="content">
		<?php
		if (isset($perfilError)) {
			echo $perfilError;
		} else {
			?>
			<?php require("templates/template.header_profile.php") ?>
			
				<div class="lista">

					<div class="item" id="agregar">
						<a href="https://ustoree.azurewebsites.net/restringido/centro_comercial/perfil/agregar_gerente.php"><span class="material-symbols-outlined">add</span></a>
					</div>

					<?php
					foreach ($gerentes as $gerente) {
					?>
					<div class="item gerentes">

						<a id="myLink"><img width="60%" class="logo" src="<?php echo $gerente['iconoPerfil'] ?>"></a>
						<div>
							<strong class="nombre"><?php echo $gerente['nombre']?></strong>
							<p><?php echo $gerente['email']?></p>
							<p><?php echo $gerente['tiendaName']?></p>
							<input type="hidden" class="idGerente" value="<?php echo $gerente['idGerente']; ?>"/>
						</div>
					</div>
					<?php
					}
					?>

				</div>
				<div class="edicionGerente">
					<i class='bx bx-pencil'></i>
				</div>
			<?php
		}
		?>
	</div>
	<input type="hidden" id="isPerfil">
	<script src="js/actualizar_imagen.js"></script>
	<script src="js/activar_edicion_gerente.js"></script>
</body>

</html>