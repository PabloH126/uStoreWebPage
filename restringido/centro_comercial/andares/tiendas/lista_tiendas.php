<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Selección de tienda</title>
	<?php require("../../templates/template.styles.php")?>
	<?php require("templates/template.secc_tiendas.php")?>
	<link rel="stylesheet" type="text/css" href="css/lista_tiendas.css">
</head>
<body>
	<?php require("../../templates/template.menu.php")?>

	<div class="content">
		<div class="lista">
			<div class="item">
				<a href=""><img width="60%" class="logo" src="img/BurgerKing.png"></a>
				<strong class="nombre">Burger King</strong>
			</div>
			

			<div class="item" id="agregar">
				<a href="creacion_tiendas.php"><span class="material-symbols-outlined">add</span></a>
			</div>
		</div>
	</div>
</body>
</html>