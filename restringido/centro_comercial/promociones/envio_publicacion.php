<?php
session_start();
//Validación de imagenes
$allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
$maxSize = 1 * 1024 * 1024; // 1 megabyte

$data = [
    'contenido' => $_POST['descripcionProducto'],
    'idTienda' => $_POST['idTienda'],
    'idCentroComercial' => $_SESSION['idMall']
];

if(isset($_FILES['logoTienda']) && $_FILES['logoTienda']['error'] == 0)
{
    $imagenPublicacion = $_FILES['logoTienda'];

    if(in_array($imagenPublicacion['type'], $allowedImageTypes) && $imagenPublicacion['size'] <= $maxSize)
    {
        $data['imagen'] = curl_file_create($imagenPublicacion['tmp_name'], $imagenPublicacion['type'], $imagenPublicacion['name']);
    }
    else
    {
        curl_close($ch);
        die("Error: Imagen de publicacion no válida. Asegúrate de subir un archivo de imagen (JPEG, PNG o JPG) que no supere 1 MB de tamaño máximo y/o sea de un tipo de imagen válido.");
    }
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Publicaciones/CreatePublicacion");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_COOKIE['SessionToken']
));

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

$dataPublicacion = json_decode($response, true);

curl_close($ch);

if($httpStatusCode != 201 && $httpStatusCode != 200)
{
    echo $httpStatusCode . ' ' . $response . ' ' . $dataPublicacion;
}
else
{
    header("Location: https://ustoree.azurewebsites.net/restringido/centro_comercial/promociones/promociones.php");
    exit;
}
?>