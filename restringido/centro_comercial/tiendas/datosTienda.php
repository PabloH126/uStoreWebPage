<?php
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

if (is_array($calificacionesTienda)) {
    $suma = 0;
    foreach ($calificacionesTienda as $calificacion) {
        $suma += $calificacion['calificacion'];
    }

    $promedio = $suma / count($calificacionesTienda);
} else {
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

$horarioApertura = DateTime::createFromFormat('H:i', $horarioDia['horarioApertura'], $zonaHoraria);
$horarioCierre = DateTime::createFromFormat('H:i', $horarioDia['horarioCierre'], $zonaHoraria);

$margenCierre = clone $horarioCierre;
$margenCierre->sub(new DateInterval('PT60M'));
?>