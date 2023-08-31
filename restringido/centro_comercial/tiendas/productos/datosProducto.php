<?php
session_start();

//-----------------------------------------------------TODOS LOS PRODUCTOS-------------------------------------------------------------//
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Productos/GetProductos?idTienda=" . $_GET['id']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
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

if ($httpStatusCode == 400) {
    $productosError = "Error al intentar recuperar los productos. Codigo de respuesta: " . $httpStatusCode;
}

$productos = json_decode($response, true);
curl_close($ch);

//---------------------------------------------------------UN PRODUCTO-------------------------------------------------------------//
if($productos == null)
{
    $producto = getDatosProducto("https://ustoreapi.azurewebsites.net/api/Productos?id=" . $_GET['id']);
    $categorias = getDatosProducto("https://ustoreapi.azurewebsites.net/api/Categorias/GetCategoriasProducto?idProducto=" . $_GET['id']);
    $imagenesProducto = getDatosProducto("https://ustoreapi.azurewebsites.net/api/Productos/GetImagenesProducto?idProducto=" . $_GET['id']);
    $calificacionesProducto = getDatosProducto("https://ustoreapi.azurewebsites.net/api/Calificaciones/GetCalificacionesProducto?idProducto=" . $_GET['id']);


    if (is_array($calificacionesProducto)) {
        $suma = 0;
        foreach ($calificacionesProducto as $calificacion) {
            $suma += $calificacion['calificacion'];
        }

        $promedio = $suma / count($calificacionesProducto);
    } else {
        $promedio = 0;
    }
}
function getDatosProducto($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
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

?>