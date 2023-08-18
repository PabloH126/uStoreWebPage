<?php
session_start();

function getDatosTienda($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
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

    curl_close($ch);

    if ($httpStatusCode != 200) {
        echo $httpStatusCode;
    }

    return json_decode($response, true);
}

function getHorarioDia($horarios, $dia)
{
    foreach ($horarios as $horario) {
        if ($horario['dia'] == $dia) {
            return $horario;
        }
    }
}

$tiendas = getDatosTienda("https://ustoreapi.azurewebsites.net/api/Tiendas?id=" . $_GET['id']);
$categorias = getDatosTienda("https://ustoreapi.azurewebsites.net/api/Categorias/GetCategoriasTienda?idTienda=" . $_GET['id']);
$horarios = getDatosTienda("https://ustoreapi.azurewebsites.net/api/Horarios/GetHorarios?idTienda=" . $_GET['id']);
$imagenesTienda = getDatosTienda("https://ustoreapi.azurewebsites.net/api/Tiendas/GetImagenesTienda?idTienda=" . $_GET['id']);
$calificacionesTienda = getDatosTienda("https://ustoreapi.azurewebsites.net/api/Calificaciones/GetCalificacionesTienda?idTienda=" . $_GET['id']);

if(is_array($calificacionesTienda))
{
    $suma = 0;
    foreach($calificacionesTienda as $calificacion)
    {
        $suma += $calificacion['calificacion'];
    }

    $promedio = $suma / count($calificacionesTienda);
}
else
{
    $promedio = 0;
}

$rangoPrecio = (double) $tiendas['rangoPrecio'];

$zonaHoraria = new DateTimeZone('Etc/GMT+6');
$fechaActual = new DateTime('now', $zonaHoraria);
$formateo = new IntlDateFormatter(
    'es_MX',
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    $zonaHoraria,
    null,
    'EEEE'
);
$dia = $formateo->format($fechaActual);
$dia = mb_convert_case($dia, MB_CASE_TITLE, "UTF-8");

$horarioDia = getHorarioDia($horarios, $dia);
$horaApertura24 = date("H:i", strtotime($horarioDia['horarioApertura']));
$horaCierre24 = date("H:i", strtotime($horarioDia['horarioCierre']));
$margenCierre = $horaCierre24 . " -30 minutes";

echo $horarioDia['horarioCierre'] . "<br>";
echo $horarioDia['horarioApertura'] . "<br>";

echo $horaApertura24 . "<br>";
echo $horaCierre24 . "<br>";

echo $margenCierre . "<br>";

echo $dia . "<br>";
echo $fechaActual->format('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Perfil tienda</title>
    <?php require("../templates/template.styles.php") ?>
    <?php require("templates/template.secc_tiendas.php") ?>
    <link rel="stylesheet" href="css/perfil_tiendas.css">
    <!-- ICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php require("../templates/template.menu.php") ?>
    <div class="content">
        <div class="contentT">
            <div class="izquierda">
                <div class="topI">
                    <div class="icon">
                        <img src="<?php echo $tiendas['logoTienda']; ?>" alt="">
                    </div>
                    <div class="nameCat">
                        <div class="name">
                            <h1>
                                <?php echo $tiendas['nombreTienda']; ?>
                            </h1>
                        </div>
                        <div class="categorias">
                            <?php
                            foreach ($categorias as $cat) {

                                ?>
                                <div class="categoria">
                                    <label>
                                        <?php echo $cat['categoria1']; ?>
                                    </label>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="botI">
                    <div class="tit">
                        <h2>Promociones</h2>
                    </div>

                    <div class="slider-container">

                        <div class="slider" id="slider">
                            <?php
                            foreach ($imagenesTienda as $imagen) {
                                ?>
                                <section class="slider-img">
                                    <img src="<?php echo $imagen['imagenTienda'] ?>" alt="">
                                </section>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="btn-left"><i class='bx bx-chevron-left'></i></div>
                        <div class="btn-right"><i class='bx bx-chevron-right'></i></div>
                    </div>
                </div>
            </div>
            <div class="derecha">
                <div class="topD">
                    <div class="info">
                        <div class="calificacion">
                            <strong>
                                <?php 
                                    if($promedio != 0)
                                    {
                                        echo $promedio;
                                    }
                                    else
                                    {
                                        echo "N/A";
                                    }
                                ?>
                            </strong>
                            <div>estrellitas uwu</div>
                        </div>
                    </div>
                    <div class="info">
                        <div class="precio">
                            <div>Rango</div>
                            <?php
                                if($rangoPrecio <= 0)
                                {
                                    echo 'No hay productos';
                                }
                                else if($rangoPrecio < 1000)
                                {
                                    echo '<div>$</div>';
                                }
                                else if($rangoPrecio >= 1000 && $rangoPrecio < 5000)
                                {
                                    echo '<div>$$</div>';
                                }
                                else if($rangoPrecio >= 5000)
                                {
                                    echo '<div>$$$</div>';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="info">
                        <div class="horario">
                            <?php
                            if ($horarioDia['horarioApertura'] == "00:00 am" && $horarioDia['horarioCierre'] == "00:00 am") {
                                echo "<strong> Cerrado </strong>";
                            } else {
                                echo "<strong>" . $horarioDia['horarioApertura'] . ' - ' . $horarioDia['horarioCierre'] . "</strong>";
                                echo "<div> cerrao </div>";
                            }
                            ?>
                            <div id="submenu_horario">
                                <h4>Horario</h4>
                                <?php
                                foreach ($horarios as $horario) {
                                    if ($horario['horarioApertura'] == "00:00 am" && $horario['horarioCierre'] == "00:00 am") {
                                        ?>
                                        <span><strong>
                                                <?php echo $horario['dia']; ?>
                                            </strong>Cerrado</span>
                                        <?php
                                    } else {
                                        ?>
                                        <span><strong>
                                                <?php echo $horario['dia']; ?>
                                            </strong>
                                            <?php echo $horario['horarioApertura'] . ' - ' . $horario['horarioCierre']; ?>
                                        </span>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="botD">
                    <div class="tit">
                        <h2>Comentarios</h2>
                    </div>
                    <div class="comnts">
                        <div class="comentarios"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bttnProductos">
            <a>Ver todos los productos</a>
        </div>
    </div>
    <script src="js/slider.js"></script>
</body>

</html>