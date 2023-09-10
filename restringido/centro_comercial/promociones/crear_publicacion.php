<?php
session_start();
require '../../security.php';
/*
//REQUEST DE LAS CATEGORIAS

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Categorias/GetCategorias");
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

$categorias = json_decode($response, true);

curl_close($ch);

//FUNCIONES DEL FORMULARIO

function HorariosSelect($dia)
{
    echo '<tr>';
    echo '<td>' . $dia . '</td>';
    echo '<td><input type="time" name="' . $dia . '_apertura"></td>';
    echo '<td><input type="time" name="' . $dia . '_cierre"></td>';
    echo '</tr>';
}

function PeriodosSelect($periodo)
{
    echo '<div class="apartadosT">';
    echo '<input type="number" name="numero' . $periodo . '" min="1" step="1">';
    echo '<select name="tiempo' . $periodo . '" id="tiempo' . $periodo . '">';
    echo '<option value="">Tiempo</option>';
    echo '<option value="minutos">Minutos</option>';
    echo '<option value="horas">Horas</option>';
    echo '<option value="dias">Días</option>';
    echo '</select>';
    echo '</div>';
}

function CategoriasSelect($categorias)
{
    foreach ($categorias as $categoria) {
        echo '<input type="checkbox" id="' . $categoria['categoria1'] . '" name="categorias[]" value="' . $categoria['idCategoria'] . '">';
        echo '<div class="contentC">';
        echo '<label for="' . $categoria['categoria1'] . '">' . $categoria['categoria1'] . '</label>';
        echo '</div>';
    }
}
***/
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
</head>

<body>
    <?php require("../templates/template.menu.php") ?>
    <div class="content">
        <h1>Crear publicación</h1>
        <div class="lista">
            <form action="envio_tienda.php" method="post" enctype="multipart/form-data" class="form-tiendas">

                <!-- Seleccion de la tienda -->
                <div class="item" id="item-1">
                    <p>1/3</p>
                    <div class="name">
                        <label for="precioProducto"><strong>Precio del producto</strong></label>
                        <strong>$</strong>
                        <input type="number" id="precioProducto" name="precioProducto" min="1" step="0.01">
                    </div>
                    <div class="bttn" id="one">
                        <button type="button" class="bttn-next" data-item="1" data-to_item="2"><i
                                class='bx bx-right-arrow-alt bttn-next' data-item="1" data-to_item="2"></i></button>
                    </div>
                </div>

                <!-- Contenido de la publicacion-->
                <div class="item active" id="item-1">
                    <p>2/3</p>
                    <div class="descripcion">
                        <label for="descripcionProducto"><strong>Contenido de la publicación</strong></label>
                        <textarea maxlength="300" id="descripcionProducto" name="descripcionProducto"></textarea>
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="2" data-to_item="1"><i
                                    class='bx bx-left-arrow-alt bttn-back' data-item="2" data-to_item="1"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="2" data-to_item="3"><i
                                    class='bx bx-right-arrow-alt bttn-next' data-item="2" data-to_item="3"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Imagen o imagenes de la publicacion -->
                <div class="item" id="item-2">
                    <p>2/2</p>
                    <div class="logoT">
                        <label><strong>Imagen de la publicación</strong></label>
                        <div class="contentL">
                            <div class="box">
                                <i class='bx bx-x delete-icon' data-input-id="logoTienda" data-img-id="imagenSelec"></i>
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
                        <span>* El peso de la imagen no debe superar 1 megabyte.</span>
                    </div>
                    <div class="bttns">
                        <div class="bttn back" id="ult">
                            <button type="button" class="bttn-back" data-item="3" data-to_item="2"><i
                                    class='bx bx-left-arrow-alt bttn-back' data-item="3" data-to_item="2"></i></button>
                        </div>
                        <div class="bttn" id="send">
                            <button type="submit">Publicar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="js/mostrarImg.js"></script>
    <script src="js/creacion_tiendas.js"></script>
    <script src="../js/slider_formularios.js"></script>
</body>

</html>