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
                <div class="item">
                    <p>1/6</p>
                    <div class="name">
                        <label for="nombreTienda"><strong>Nombre de la tienda</strong></label>
                        <input type="text" id="nombreTienda" required>
                    </div>
                    <div class="bttn">
                        <button>Siguiente</button>
                    </div>
                </div>
                    
<!--
                <fieldset>
                    <legend><div>2/6</div></legend>
                    <div>
                        <label for="nombreTienda"></label>
                        <input type="text" id="nombreTienda" required>
                    </div>
                    <div>atras</div>
                    <div>siguiente c:</div>
                </fieldset>

                <fieldset>
                    <legend><div>3/6</div></legend>
                    <div>
                        <label for="nombreTienda"></label>
                        <input type="text" id="nombreTienda" required>
                    </div>
                    <div>atras</div>
                    <div>siguiente c:</div>
                </fieldset>

                <fieldset>
                    <legend><div>4/6</div></legend>
                    <div>
                        <label for="nombreTienda"></label>
                        <input type="text" id="nombreTienda" required>
                    </div>
                    <div>atras</div>
                    <div>siguiente c:</div>
                </fieldset>

                <fieldset>
                    <legend><div>5/6</div></legend>
                    <div>
                        <label for="nombreTienda"></label>
                        <input type="text" id="nombreTienda" required>
                    </div>
                    <div>atras</div>
                    <div>siguiente c:</div>
                </fieldset>

                <fieldset>
                    <legend><div>6/6</div></legend>
                    <div>
                        <label for="nombreTienda"></label>
                        <input type="text" id="nombreTienda" required>
                    </div>
                    <div>atras</div>
                    <div>siguiente c:</div>
                    <button type="submit">Enviar</button>
                </fieldset>-->
            </form>
        </div>
    </div>
</body>