<?php
session_start();
$imagenes = [];
verificarImagen('imagen1', $_FILES['imagen1'], $imagenes);
verificarImagen('imagen2', $_FILES['imagen2'], $imagenes);
verificarImagen('imagen3', $_FILES['imagen3'], $imagenes);

$idTienda = $_POST['idTienda']; // Recuperar el idTienda desde el formulario

//CREATE IMAGENES BANNER TIENDA

$responseArray = [];
foreach($imagenes as $key => $imagen)
{
    $responseArray = mandarImagenApi($idTienda, $imagen, $imagenes);
}

//FUNCIONES

function verificarImagen($nombreImagen, $imagen, $imagenes) {
    //Validación de imagenes
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $maxSize = 1 * 1024 * 1024; // 1 megabyte

    if(isset($imagen) && $imagen['error'] == 0) {
        if(in_array($imagen['type'], $allowedImageTypes) && $imagen['size'] <= $maxSize) {
            $imagenes[$nombreImagen] = $imagen;
        } else {
            die("Error las imagenes de producto:" . $nombreImagen . " no válida. Asegúrate de subir un archivo de imagen (JPEG, PNG o JPG) que no supere 1 MB de tamaño máximo y/o sea de un tipo de imagen válido.");
        }
    }
}

function mandarImagenApi($idTienda, $imagen) {
    $data = [
        'imagen' => curl_file_create($imagen['tmp_name'], $imagen['type'], $imagen['name'])
    ];
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/CreateImagenTienda?idTienda=" . $idTienda);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_COOKIE['SessionToken']
    ));
    
    $response = curl_exec($ch);
    
    if ($response === false) {
        return [
            'statusImagenes' => 'error',
            'messageImagenes' => 'Error en la solicitud cURL: ' . curl_error($ch)
        ];
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    curl_close($ch);

    if($httpStatusCode != 200) {
        return [
            'statusImagenes' => 'error',
            'messageImagenes' => $httpStatusCode . ' en CREACION IMAGENES TIENDA'
        ];
    } else {
        return [
            'statusImagenes' => 'success',
            'messageImagenes' => $httpStatusCode . ' en CREACION IMAGENES TIENDA'
        ];
    }
}

echo json_encode($responseArray);
?>