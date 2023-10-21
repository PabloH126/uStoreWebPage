<?php
session_start();
require '../../security.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Crear publicación</title>
    <?php require("../templates/template.styles.php") ?>
    <?php require("templates/template.secc_promociones.php") ?>
    <link rel="stylesheet" href="../css/formularios_creacion.css">
    <link rel="stylesheet" href="css/crear_publicacion.css">
    <link rel="stylesheet" type="text/css" href="../tiendas/css/notificacion_errores.css">
</head>

<body>
    <?php require("../templates/template.menu.php") ?>
    <div class="content">
        <h1>Crear publicación</h1>
        <div class="lista">
            <form action="envio_publicacion.php" method="post" enctype="multipart/form-data" class="form-tiendas">

                <!-- Contenido de la publicacion-->
                <div class="item" id="item-1">
                    <p>1/2</p>
                    <div class="descripcion">
                        <label for="descripcionProducto"><strong>Contenido de la publicación</strong></label>
                        <textarea maxlength="300" id="descripcionProducto" name="descripcionProducto"></textarea>
                    </div>
                    <div class="bttn" id="one">
                        <button type="button" class="bttn-next" data-item="1" data-to_item="2"><i
                                class='bx bx-right-arrow-alt bttn-next' data-item="1" data-to_item="2"></i></button>
                    </div>
                </div>

                <!-- Imagen o imagenes de la publicacion -->
                <div class="item" id="item-2">
                    <p>2/2</p>
                    <div class="logoT">
                        <label><strong>Imagen de la publicación</strong></label>
                        <div class="contentL">
                            <div class="box">
                                <i class='bx bx-x delete-icon' data-input-id="logoTienda"
                                    data-img-id="imagenSelec"></i>
                                <img id="imagenSelec" alt="">
                            </div>
                            <div class="ip">
                                <label for="logoTienda" id="labelL">
                                    <input type="file" class="file-input fileLogoTienda" id="logoTienda"
                                        name="logoTienda" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="notas">
                        <span>* Este apartado es opcional.</span><br>
                        <span>* El peso de la imagen no debe superar 1 megabyte.</span>
                    </div>
                    <div class="bttns">
                        <div class="bttn back" id="ult">
                            <button type="button" class="bttn-back" data-item="2" data-to_item="1"><i
                                    class='bx bx-left-arrow-alt bttn-back' data-item="2"
                                    data-to_item="1"></i></button>
                        </div>
                        <div class="bttn" id="send">
                            <button type="submit" id="submitBtn">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="js/creacion_publicacion.js"></script>
</body>

</html>