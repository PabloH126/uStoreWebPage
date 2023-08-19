<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Crear tienda</title>
	<?php require("templates/template.styles.php")?>
	<?php require("tiendas/templates/template.secc_tiendas.php")?>
	<link rel="stylesheet" type="text/css" href="tiendas/css/creacion_tiendas2.css">
</head>
<body>
<?php require("templates/template.menu.php")?>
	<div class="content">
		<h1>Creación de tienda</h1>
        <div class="lista">
            <form>
                <fieldset>
                    <legend><div>1/6</div></legend>
                    
                    <label for="nombreTienda"></label>
                    <input type="text" id="nombreTienda" required>
                </fieldset>
                
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>