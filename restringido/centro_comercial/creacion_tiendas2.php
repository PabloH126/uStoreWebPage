<?php
    session_start();
    require '../security.php';

    //REQUEST DE LAS CATEGORIAS

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Categorias/GetCategorias");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_COOKIE['SessionToken']
    ));

    $response = curl_exec($ch);

    if ($response === false) {
        echo 'Error: ' . curl_error($ch);
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    $categorias = json_decode($response, true);

    curl_close($ch);

    //FUNCIONES DEL FORMULARIO

    function selectHorarios($dia)
    {
        echo '<tr>';
        echo '<td>' . $dia . '</td>';
        echo '<td><input type="time" name="' . $dia . '_apertura"></td>';
        echo '<td><input type="time" name="' . $dia . '_cierre"></td>';
        echo '</tr>';
    }

    function PeriodosSelect($periodo)
    {
        echo '<div class="numeroA">';
            echo '<select name="numero' . $periodo . '" id="numero' . $periodo . '">';
                echo '<option value="">numero</option>';
        for($i = 1; $i < 61; $i++)
        {
                echo '<option value="' . $i . '">' . $i . '</option>';
        }
            echo '</select>';
        echo '</div>';
        echo '<div class="tiempoA">';
            echo '<select name="tiempo' . $periodo . '" id="tiempo' . $periodo . '">';
                echo '<option value="">tiempo</option>';
                echo '<option value="minutos">Minutos</option>';
                echo '<option value="horas">Horas</option>';
                echo '<option value="dias">Días</option>';
            echo '</select>';
        echo '</div>';
    }

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Crear tienda</title>
    <?php require("templates/template.styles.php") ?>
    <?php require("tiendas/templates/template.secc_tiendas.php") ?>
    <link rel="stylesheet" type="text/css" href="tiendas/css/creacion_tiendas2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php require("templates/template.menu.php") ?>
    <div class="content">
        <h1>Creación de tienda</h1>
        <div class="lista">
            <form>
                <!-- Nombre de tienda-->
                <!-- <div class="item">
                    <p>1/6</p>
                    <div class="name">
                        <label for="nombreTienda"><strong>Nombre de la tienda</strong></label>
                        <input type="text" id="nombreTienda" required>
                    </div>
                    <div class="bttn" id="one">
                        <button><i class='bx bx-right-arrow-alt'></i></button>
                    </div>
                </div>

                <!-- Logo de tienda-->
                <div class="item">
                <!--    <p>2/6</p>
                    <div class="logoT">
                        <label><strong>Logo de la tienda</strong></label>
                        <div class="contentL">
                            <div class="box"> <img id="imagenSelec" alt=""></div>
                            <div class="ip">
                                <label for="logoTienda" id="labelL" >
                                <input type="file" id="logoTienda" name="logoTienda">
                            </div>
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button><i class='bx bx-left-arrow-alt'></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button><i class='bx bx-right-arrow-alt'></i></button>
                        </div>
                    </div>
                </div> 

                <!-- Categorias de tienda-->
                <!-- <div class="item">
                    <p>3/6</p>
                    <div class="categorias">
                        <label><strong>Categorías de la tienda</strong></label>
                        <div class="optionsC">
                            
                            <input type="checkbox" id="alimentosBebidas">
                            <div class="contentC">
                                
                                <label for="alimentosBebidas">alimentos y bebidas</label>
                            </div>

                            <input type="checkbox" id="departamentales">
                            <div class="contentC">
                                <label for="departamentales">departamentales</label>
                            </div>
                            
                            <input type="checkbox" id="bebes">
                            <div class="contentC">                                
                                <label for="bebes">bebes</label>
                            </div>
                            
                            <input type="checkbox" id="videojuegos">
                            <div class="contentC">
                                <label for="videojuegos">videojuegos</label>
                            </div>

                            <input type="checkbox" id="vida">
                            <div class="contentC">
                                <label for="vida">estilo de vida</label>
                            </div>
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button><i class='bx bx-left-arrow-alt'></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button><i class='bx bx-right-arrow-alt'></i></button>
                        </div>
                    </div>
                </div> 

                <!-- Horario de tienda-->
                <!-- <div class="item">
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
                                <tr>
                                    <td>Lunes</td>
                                    <td><input type="time" name="lunes_inicio"></td>
                                    <td><input type="time" name="lunes_fin"></td>
                                </tr>
                                <tr>
                                    <td>Martes</td>
                                    <td><input type="time" name="martes_inicio"></td>
                                    <td><input type="time" name="martes_fin"></td>
                                </tr>
                                <tr>
                                    <td>Miércoles</td>
                                    <td><input type="time" name="miercoles_inicio"></td>
                                    <td><input type="time" name="miercoles_fin"></td>
                                </tr>
                                <tr>
                                    <td>Jueves</td>
                                    <td><input type="time" name="jueves_inicio"></td>
                                    <td><input type="time" name="jueves_fin"></td>
                                </tr>
                                <tr>
                                    <td>Viernes</td>
                                    <td><input type="time" name="viernes_inicio"></td>
                                    <td><input type="time" name="viernes_fin"></td>
                                </tr>
                                <tr>
                                    <td>Sábado</td>
                                    <td><input type="time" name="sabado_inicio"></td>
                                    <td><input type="time" name="sabado_fin"></td>
                                </tr>
                                <tr>
                                    <td>Domingo</td>
                                    <td><input type="time" name="domingo_inicio"></td>
                                    <td><input type="time" name="domingo_fin"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="notas">
                            <span>* Si es día no laboral, dejar el día en 00:00 o en --:--.</span>
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button><i class='bx bx-left-arrow-alt'></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button><i class='bx bx-right-arrow-alt'></i></button>
                        </div>
                    </div>
                </div>

                <!-- Promociones de tienda -->
                <!-- <div class="item">
                    <p>5/6</p>
                    <div class="promociones">
                        <label><strong>Promociones de la tienda</strong></label>
                        <div class="imageP">
                            <div class="contentP">
                                <div class="box"><img src="" id="imagenSelec1" alt=""></div>
                                <div class="ip">
                                    <label for="fileInput1" >
                                    <input type="file" id="fileInput1" name="imagen1">
                                </div>
                            </div>
                            <div class="contentP">
                                <div class="box"><img src="" id="imagenSelec2" alt=""></div>
                                <div class="ip">
                                    <label for="fileInput2" >
                                    <input type="file" id="fileInput2" name="imagen2">
                                </div>
                            </div>
                            <div class="contentP">
                                <div class="box"><img src="" id="imagenSelec3" alt=""></div>
                                <div class="ip">
                                    <label for="fileInput3" >
                                    <input type="file" id="fileInput3" name="imagen3">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn back">
                            <button><i class='bx bx-left-arrow-alt'></i></button>
                        </div>
                        <div class="bttn" id="next">
                            <button><i class='bx bx-right-arrow-alt'></i></button>
                        </div>
                    </div>
                </div> 

                <!-- Periodos de apartado de la tienda -->
                <div class="item">
                    <p>6/6</p>
                    <div class="apartados">
                        <label><strong>Periodos de apartado</strong></label>
                        <div class="contentA">
                            <input type="number">
                            <input type="number">
                            <input type="number">
                        </div>
                    </div>
                    <div class="bttns">
                        <div class="bttn back" id="ult">
                            <button><i class='bx bx-left-arrow-alt'></i></button>
                        </div>
                        <div class="bttn" id="send">
                            <button>Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>