<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Crear tienda</title>
	<?php require("templates/template.styles.php")?>
	<?php require("tiendas/templates/template.secc_tiendas.php")?>
	<link rel="stylesheet" type="text/css" href="tiendas/css/creacion_tiendas2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                    <div class="bttn" id="one">
                        <button><i class='bx bx-right-arrow-alt'></i></button>
                    </div>
                </div>
                    
<!--
                <div class="item">
                    <p>2/6</p>
                    <div class="logoT">
                        <label for="logoTienda"><strong>Logo de la tienda</strong></label>
                        <div class="contentL">
                            <div class="box"> <img id="imagenSelec" alt=""></div>
                            <div class="ip">
                                <label for="logoTienda" id="labelL" >
                                <input type="file" id="logoTienda" name="logoTienda">
                            </div>
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn" id="back">
                            <button><i class='bx bx-left-arrow-alt'></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button><i class='bx bx-right-arrow-alt'></i></button>
                        </div>
                    </div>
                </div> -->

<!--
                <div class="item">
                    <p>1/6</p>
                    <div class="name">
                        <label for="nombreTienda"><strong>Nombre de la tienda</strong></label>
                        <input type="text" id="nombreTienda" required>
                    </div>
                    <div class="bttn">
                        <button><i class='bx bx-right-arrow-alt'></i></button>
                    </div>
                </div>

                <div class="item">
                    <p>1/6</p>
                    <div class="name">
                        <label for="nombreTienda"><strong>Nombre de la tienda</strong></label>
                        <input type="text" id="nombreTienda" required>
                    </div>
                    <div class="bttn">
                        <button><i class='bx bx-right-arrow-alt'></i></button>
                    </div>
                </div>

                <div class="item">
                    <p>1/6</p>
                    <div class="name">
                        <label for="nombreTienda"><strong>Nombre de la tienda</strong></label>
                        <input type="text" id="nombreTienda" required>
                    </div>
                    <div class="bttn">
                        <button><i class='bx bx-right-arrow-alt'></i></button>
                    </div>
                </div>

                <div class="item">
                    <p>1/6</p>
                    <div class="name">
                        <label for="nombreTienda"><strong>Nombre de la tienda</strong></label>
                        <input type="text" id="nombreTienda" required>
                    </div>
                    <div class="bttn">
                        <button><i class='bx bx-right-arrow-alt'></i></button>
                    </div>
                </div>-->
            </form>
        </div>
    </div>
</body>