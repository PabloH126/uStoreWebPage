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
?>