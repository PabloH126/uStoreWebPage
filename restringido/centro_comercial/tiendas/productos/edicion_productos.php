<?php
session_start();
require '../../../security.php';

//REQUEST DE LAS CATEGORIAS

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Categorias/GetCategorias");
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
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Crear producto</title>
    <?php require("../../templates/template.styles.php") ?>
    <?php require("../templates/template.secc_tiendas.php") ?>
    <link rel="stylesheet" type="text/css" href="../css/creacion_tiendas.css">
    <link rel="stylesheet" type="text/css" href="https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/css/confirmacion_eliminacion.css">
    <link rel="stylesheet" href="css/creacion_productos.css">
</head>

<body>
    <?php require("../../templates/template.menu.php") ?>
    <div class="content">
        <h1>Creación de productos</h1>
        <div class="lista">
            <form action="envio_producto.php" method="post" enctype="multipart/form-data" class="form-tiendas">

                <!-- Nombre del producto-->
                <div class="item active" id="item-1">
                    <p>1/6</p>
                    <div class="name">
                        <label for="nombreProducto"><strong>Nombre del producto</strong></label>
                        <input type="text" id="nombreProducto" name="nombreProducto">
                    </div>
                    <div class="bttn" id="one">
                        <button type="button" class="bttn-next" data-item="1" data-to_item="2"><i
                                class='bx bx-right-arrow-alt bttn-next' data-item="1" data-to_item="2"></i></button>
                    </div>
                </div>

                <!-- Categorias del producto-->
                <div class="item" id="item-2">
                    <p>2/6</p>
                    <div class="categorias">
                        <label><strong>Categorías del producto</strong></label>
                        <div class="optionsC">
                            <?php CategoriasSelect($categorias); ?>
                        </div>
                        <div class="notas">
                            <span>* Se pueden seleccionar un máximo de 8 categorías.</span>
                        </div>
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

                <!--Precio del producto-->
                <div class="item" id="item-3">
                    <p>3/6</p>
                    <div class="name">
                        <label for="precioProducto"><strong>Precio del producto</strong></label>
                        <strong>$</strong>
                        <input type="number" id="precioProducto" name="precioProducto" min="1" step="0.01">
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="3" data-to_item="2"><i
                                    class='bx bx-left-arrow-alt bttn-back' data-item="3" data-to_item="2"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="3" data-to_item="4"><i
                                    class='bx bx-right-arrow-alt bttn-next' data-item="3" data-to_item="4"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Descripcion del producto-->
                <div class="item" id="item-4">
                    <p>4/6</p>
                    <div class="descripcion">
                        <label for="descripcionProducto"><strong>Descripción del producto</strong></label>
                        <textarea id="descripcionProducto" name="descripcionProducto"></textarea>
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="4" data-to_item="3"><i
                                    class='bx bx-left-arrow-alt bttn-back' data-item="4" data-to_item="3"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="4" data-to_item="5"><i
                                    class='bx bx-right-arrow-alt bttn-next' data-item="4" data-to_item="5"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Imagenes de producto -->
                <div class="item" id="item-5">
                    <p>5/6</p>
                    <div class="promociones">
                        <label><strong>Imágenes del producto</strong></label>
                        <div class="contentPP" id="contentPP">

                            <div class="imageP" id="imageP">
                                <div class="contentP">
                                    <div class="box">
                                        <i class='bx bx-x delete-icon' data-input-id="fileInput1" data-img-id="imagenSelec1"></i>
                                        <img src="" id="imagenSelec1" alt="">
                                    </div>
                                    <div class="ip">
                                        <label for="fileInput1">
                                            <input type="file" class="file-input" id="fileInput1" name="imagen1"
                                                accept="image/*">
                                    </div>
                                </div>
                                <div class="contentP">
                                    <div class="box">
                                        <i class='bx bx-x delete-icon' data-input-id="fileInput2" data-img-id="imagenSelec2"></i>
                                        <img src="" id="imagenSelec2" alt="">
                                    </div>
                                    <div class="ip">
                                        <label for="fileInput2">
                                            <input type="file" class="file-input" id="fileInput2" name="imagen2"
                                                accept="image/*">
                                    </div>
                                </div>
                                <div class="contentP">
                                    <div class="box">
                                        <i class='bx bx-x delete-icon' data-input-id="fileInput3" data-img-id="imagenSelec3"></i>
                                        <img src="" id="imagenSelec3" alt="">
                                    </div>
                                    <div class="ip">
                                        <label for="fileInput3">
                                            <input type="file" class="file-input" id="fileInput3" name="imagen3"
                                                accept="image/*">
                                    </div>
                                </div>

                                <div class="contentP" id="content-4">
                                    <div class="box">
                                        <i class='bx bx-x delete-icon' data-input-id="fileInput4" data-img-id="imagenSelec4"></i>
                                        <img src="" id="imagenSelec4" alt="">
                                    </div>
                                    <div class="ip">
                                        <label for="fileInput4">
                                            <input type="file" class="file-input" id="fileInput4" name="imagen4"
                                                accept="image/*">
                                    </div>
                                </div>

                                <div class="contentP" id="content-5">
                                    <div class="box">
                                        <i class='bx bx-x delete-icon' data-input-id="fileInput5" data-img-id="imagenSelec5"></i>
                                        <img src="" id="imagenSelec5" alt="">
                                    </div>
                                    <div class="ip">
                                        <label for="fileInput5">
                                            <input type="file" class="file-input" id="fileInput5" name="imagen5"
                                                accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="notas">
                        <span>* Máximo 5 imágenes.<br>
                        Cada imagen no debe superar 1Mb. </span>
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="5" data-to_item="4"><i
                                    class='bx bx-left-arrow-alt bttn-back' data-item="5" data-to_item="4"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="5" data-to_item="6"><i
                                    class='bx bx-right-arrow-alt bttn-next' data-item="5" data-to_item="6"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Cantidad designados para apartar -->
                <div class="item" id="item-6">
                    <p>6/6</p>
                    <div class="cantidadApartar">
                        <label for="cantidadApartar"><strong>Cantidad para apartar</strong></label>
                        <input type="number" id="cantidadApartar" name="cantidadApartar" min="0" step="1">
                    </div>
                    <div class="notas">
                        <span>* Este apartado se refiere a la cantidad de unidades del producto destinadas para
                            apartar.<br></span>
                        <span>En caso de que el producto no esté disponible para apartado, ingrese "0".</span>
                    </div>
                    <div class="bttns">
                        <div class="bttn back" id="ult">
                            <button type="button" class="bttn-back" data-item="6" data-to_item="5"><i
                                    class='bx bx-left-arrow-alt bttn-back' data-item="6" data-to_item="5"></i></button>
                        </div>
                        <div class="bttn" id="send">
                            <button type="submit">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="../../js/slider_formularios.js"></script>
    <script src="../../js/mostrarImg.js"></script>
    <script src="js/productosImg.js"></script>
    <script src="js/creacion_productos.js"></script>
</body>

</html>