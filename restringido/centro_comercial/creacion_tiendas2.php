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
        <div>
            <form>
                <fieldset>
                    <legend>Información de Contacto</legend>
                    
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" rows="4" required></textarea>
                </fieldset>
                
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>