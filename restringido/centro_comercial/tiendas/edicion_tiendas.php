<?php
session_start();
require '../../security.php';
include 'datosTienda.php';

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

$categoriasDisponibles = json_decode($response, true);

curl_close($ch);


$categoriasTiendaId = array_column($categorias, 'idCategoria');


//FUNCIONES DEL FORMULARIO

function HorariosSelect($dia, $horarios)
{
    foreach($horarios as $horario)
    {
        if($horario['dia'] === $dia)
        {
            echo '<tr>';
            echo '<td>' . $dia . '</td>';
            echo '<td><input type="time" name="' . $dia . '_apertura" value="' . $horario['horarioApertura'] . '"></td>';
            echo '<td><input type="time" name="' . $dia . '_cierre" value="' . $horario['horarioCierre'] . '"></td>';
            echo '</tr>';
        }
    }
}

function PeriodosSelect($periodo, $periodosPredeterminados)
{
    list($cantidad, $tiempo) = explode(' ', $periodosPredeterminados['apartadoPredeterminado'], 2);

    $idApartadoPredeterminado = 0;

    if(isset($periodosPredeterminados['idApartadoPredeterminado']))
    {
        $idApartadoPredeterminado = $periodosPredeterminados['idApartadoPredeterminado'];
    }
    
    $selectedMinutos = ($tiempo === 'minutos') ? 'selected' : '';
    $selectedHoras = ($tiempo === 'horas') ? 'selected' : '';
    $selectedDias = ($tiempo === 'dias') ? 'selected' : '';

    echo '<div class="apartadosT">';
    echo '<input type="number" name="numero' . $periodo . '" min="1" step="1" value="' . $cantidad . '">';
    echo '<select name="tiempo' . $periodo . '" id="tiempo' . $periodo . '">';
    echo '<option value="">Tiempo</option>';
    echo '<option value="minutos" ' . $selectedMinutos . '>Minutos</option>';
    echo '<option value="horas" ' . $selectedHoras . '>Horas</option>';
    echo '<option value="dias" ' . $selectedDias . '>Días</option>';
    echo '</select>';
    echo '<input type="hidden" name="idApartadoPredeterminado' . $periodo . '" value="' . $idApartadoPredeterminado . '">';
    echo '</div>';
}

function CategoriasSelect($categoriasDisponibles, $categoriasTiendaId)
{
    foreach ($categoriasDisponibles as $categoria) {
        $isChecked = in_array($categoria['idCategoria'], $categoriasTiendaId) ? 'checked' : '';

        echo '<input type="checkbox" id="' . $categoria['categoria1'] . '" name="categorias[]" value="' . $categoria['idCategoria'] . '" ' . $isChecked . '>';
        
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
    <title>Edición de <?php echo $tiendas['nombreTienda']; ?></title>
    <?php require("../templates/template.styles.php") ?>
    <?php require("templates/template.secc_tiendas.php") ?>
    <link rel="stylesheet" type="text/css" href="../css/creacion_tiendas.css">
    <link rel="stylesheet" href="css/edicion_tiendas.css">
    <link rel="stylesheet" type="text/css" href="css/confirmacion_eliminacion.css"> 
    <link rel="stylesheet" type="text/css" href="css/mensaje_eliminacion.css">
    <link rel="stylesheet" type="text/css" href="css/notificacion_errores.css">
</head>

<body>
    <?php require("../templates/template.menu.php") ?>
    <div class="content">
        <h1>Edición de tienda</h1>
        <div class="lista">
            <form action="actualizar_tienda.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" class="form-tiendas">
                <!-- Nombre de tienda-->
                <div class="item active" id="item-1">
                    <p>1/6</p>
                    <div class="name">
                        <label for="nombreTienda"><strong>Nombre de la tienda</strong></label>
                        <input type="text" id="nombreTienda" name="nombreTienda" value="<?php echo $tiendas['nombreTienda']; ?>" >
                    </div>
                    <div class="bttns">
                        <div class="bttn" id="delete-store">
                            <button type="button" class="delete-store-btn" data-store-id="<?php echo $_GET['id']; ?>"><i class='bx bx-trash'></i></button>
                        </div>
                        <div class="bttn" id="one">
                            <button type="button" class="bttn-next" data-item="1" data-to_item="2"><i 
                                    class='bx bx-right-arrow-alt bttn-next' data-item="1" data-to_item="2"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Logo de tienda-->
                <div class="item" id="item-2">
                    <p>2/6</p>
                    <div class="logoT">
                        <label><strong>Logo de la tienda</strong></label>
                        <div class="contentL">
                            <div class="box">
                                <i class='bx bx-x delete-icon' data-input-id="logoTienda" data-img-id="imagenSelec"></i>
                                <img id="imagenSelec" alt="" src="<?php echo $tiendas['logoTienda']; ?>">
                            </div>
                            <div class="ip">
                                <label for="logoTienda" id="labelL">
                                <input type="file" class="file-input" id="logoTienda" name="logoTienda" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="notas">
                        <span>* El peso de la imagen del logo no debe superar 1 megabyte.</span>
                    </div>

                    <div class="bttns">
                        <div class="bttn" id="delete-store">
                            <button type="button" class="delete-store-btn" data-store-id="<?php echo $_GET['id']; ?>"><i class='bx bx-trash'></i></button>
                        </div>
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="2" data-to_item="1"><i class='bx bx-left-arrow-alt bttn-back' data-item="2" data-to_item="1"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="2" data-to_item="3"><i class='bx bx-right-arrow-alt bttn-next' data-item="2" data-to_item="3"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Categorias de tienda-->
                <div class="item" id="item-3">
                    <p>3/6</p>
                    <div class="categorias">
                        <label><strong>Categorías de la tienda</strong></label>
                        <div class="optionsC">
                            <?php CategoriasSelect($categoriasDisponibles, $categoriasTiendaId); ?>
                        </div>
                        <div class="notas">
                            <span>* Se pueden seleccionar un máximo de 8 categorías.</span>
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn" id="delete-store">
                            <button type="button" class="delete-store-btn" data-store-id="<?php echo $_GET['id']; ?>"><i class='bx bx-trash'></i></button>
                        </div>
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="3" data-to_item="2"><i class='bx bx-left-arrow-alt bttn-back' data-item="3" data-to_item="2"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="3" data-to_item="4"><i class='bx bx-right-arrow-alt bttn-next' data-item="3" data-to_item="4"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Horario de tienda-->
                <div class="item" id="item-4">
                    <p>4/6</p>
                    <div class="horarioT">
                        <label><strong>Horario de la tienda</strong></label>
                        <table>
                            <thead>
                                <tr>
                                    <th>Día</th>
                                    <th>Hora de apertura</th>
                                    <th>Hora de cierre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                HorariosSelect('Lunes', $horarios);
                                HorariosSelect('Martes', $horarios);
                                HorariosSelect('Miércoles', $horarios);
                                HorariosSelect('Jueves', $horarios);
                                HorariosSelect('Viernes', $horarios);
                                HorariosSelect('Sábado', $horarios);
                                HorariosSelect('Domingo', $horarios);
                                ?>
                            </tbody>
                        </table>
                        <div class="notas">
                            <span>* Si es día no laboral, dejar el día en 00:00 o en --:--.</span>
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn" id="delete-store">
                            <button type="button" class="delete-store-btn" data-store-id="<?php echo $_GET['id']; ?>"><i class='bx bx-trash'></i></button>
                        </div>
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="4" data-to_item="3"><i class='bx bx-left-arrow-alt bttn-back' data-item="4" data-to_item="3"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="4" data-to_item="5"><i class='bx bx-right-arrow-alt bttn-next' data-item="4" data-to_item="5"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Promociones de tienda -->
                <div class="item" id="item-5">
                    <p>5/6</p>
                    <div class="promociones">
                        <label><strong>Banners de la tienda</strong></label>
                        <div class="imageP">
                            <div class="contentP">
                                <div class="box">
                                    <i class='bx bx-x delete-icon' data-input-id="fileInput1" data-img-id="imagenSelec1" data-imgG-id="idImagen1"></i>
                                    <img src="<?php echo $imagenesTienda[0]['imagenTienda']; ?>" id="imagenSelec1" alt="">
                                </div>
                                <div class="ip">
                                    <label for="fileInput1" >
                                    <input type="file" class="file-input fileInputBanner" id="fileInput1" name="imagen1" accept="image/*">
                                    <input type="hidden" id="idImagen1" value="<?php echo isset($imagenesTienda[0]['idImagenesTiendas']) ? $imagenesTienda[0]['idImagenesTiendas'] : "0"; ?>" name="idImagen1" class="idImagenes">
                                </div>
                            </div>
                            <div class="contentP">
                                <div class="box">
                                    <i class='bx bx-x delete-icon' data-input-id="fileInput2" data-img-id="imagenSelec2" data-imgG-id="idImagen2"></i>
                                    <img src="<?php echo $imagenesTienda[1]['imagenTienda']; ?>" id="imagenSelec2" alt="">
                                </div>
                                <div class="ip">
                                    <label for="fileInput2" >
                                    <input type="file" class="file-input fileInputBanner" id="fileInput2" name="imagen2" accept="image/*">
                                    <input type="hidden" id="idImagen2" value="<?php echo isset($imagenesTienda[1]['idImagenesTiendas']) ? $imagenesTienda[1]['idImagenesTiendas'] : "0"; ?>" name="idImagen2" class="idImagenes">
                                </div>
                            </div>
                            <div class="contentP">
                                <div class="box">
                                    <i class='bx bx-x delete-icon' data-input-id="fileInput3" data-img-id="imagenSelec3" data-imgG-id="idImagen3"></i>
                                    <img src="<?php echo $imagenesTienda[2]['imagenTienda']; ?>" id="imagenSelec3" alt="">
                                </div>
                                <div class="ip">
                                    <label for="fileInput3" >
                                    <input type="file" class="file-input fileInputBanner" id="fileInput3" name="imagen3" accept="image/*">
                                    <input type="hidden" id="idImagen3" value="<?php echo isset($imagenesTienda[2]['idImagenesTiendas']) ? $imagenesTienda[2]['idImagenesTiendas'] : "0"; ?>" name="idImagen3" class="idImagenes">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="notas">
                        <span>* El peso de cada imagen no debe superar 1 megabyte.</span>
                    </div>
                    <div class="bttns">
                    <div class="bttn" id="delete-store">
                            <button type="button" class="delete-store-btn" data-store-id="<?php echo $_GET['id']; ?>"><i class='bx bx-trash'></i></button>
                        </div>
                        <div class="bttn back">
                            <button type="button" class="bttn-back" data-item="5" data-to_item="4"><i class='bx bx-left-arrow-alt bttn-back' data-item="5" data-to_item="4"></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button type="button" class="bttn-next" data-item="5" data-to_item="6"><i class='bx bx-right-arrow-alt bttn-next' data-item="5" data-to_item="6"></i></button>
                        </div>
                    </div>
                </div> 

                <!-- Periodos de apartado de la tienda -->
                <div class="item" id="item-6">
                    <p>6/6</p>
                    <div class="apartados">
                        <label><strong>Periodos de apartado</strong></label>
                        <div class="contentA">
                            <?php
                            PeriodosSelect('Periodo1', $periodosPredeterminados[0]);
                            PeriodosSelect('Periodo2', $periodosPredeterminados[1]);
                            PeriodosSelect('Periodo3', $periodosPredeterminados[2]);
                            ?>
                        </div>
                        <div class="notas">
                            <span>* Los campos en blanco y en "Tiempo", no se guardarán.</span>
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn" id="delete-store">
                            <button type="button" class=""><i class='bx bx-trash'></i></button>
                        </div>
                        <div class="bttn back" id="ult">
                            <button type="button" class="bttn-back" data-item="6" data-to_item="5"><i class='bx bx-left-arrow-alt bttn-back' data-item="6" data-to_item="5"></i></button>
                        </div>
                        <div class="bttn" id="send">
                            <button type="submit">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="notification-container"></div>
    <script src="../js/slider_formularios.js"></script>
    <!--<script src="../js/mostrarImg.js"></script>-->
    <script src="../js/edicion_tiendas.js"></script>
    <script src="../js/confirmacion_eliminacion.js"></script>
</body>

</html>