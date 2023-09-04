<?php
session_start();
$imagenes = [];
$idImagenes = [];
verificarImagen(0, $_FILES['imagen1'], $_POST['idImagen1'], $imagenes, $idImagenes);
verificarImagen(1, $_FILES['imagen2'], $_POST['idImagen2'], $imagenes, $idImagenes);
verificarImagen(2, $_FILES['imagen3'], $_POST['idImagen3'], $imagenes, $idImagenes);
verificarImagen(4, $_FILES['imagen4'], $_POST['idImagen4'], $imagenes, $idImagenes);
verificarImagen(5, $_FILES['imagen5'], $_POST['idImagen5'], $imagenes, $idImagenes);

$idProducto = $_POST['idProducto']; // Recuperar el idProducto desde el formulario

//UPDATE IMAGENES PRODUCTO

$responseArray = [];
foreach($imagenes as $index => $imagen)
{
    $responseArray = mandarImagenApi($idProducto, $imagen, $idImagenes[$index]);
}

//FUNCIONES

function verificarImagen($index, $imagen, $idImagen, &$imagenes, &$idImagenes) {
    //Validación de imagenes
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $maxSize = 1 * 1024 * 1024; // 1 megabyte

    if(isset($imagen) && $imagen['error'] == 0) {
        if(in_array($imagen['type'], $allowedImageTypes) && $imagen['size'] <= $maxSize) {
            $imagenes[$index] = $imagen;
            $idImagenes[$index] = $idImagen;
        } else {
            die("Error en las imagenes de producto: La imagen " . $index . " no válida. Asegúrate de subir un archivo de imagen (JPEG, PNG o JPG) que no supere 1 MB de tamaño máximo y/o sea de un tipo de imagen válido.");
        }
    }
}

function mandarImagenApi($idTienda, $imagen, $idImagen) {
    $data = [
        'imagen' => curl_file_create($imagen['tmp_name'], $imagen['type'], $imagen['name'])
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/UpdateImagenTienda?idTienda=" . $idTienda . "&idImagenTienda=" . $idImagen);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
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

    if($httpStatusCode != 204) {
        return [
            'statusImagenes' => 'error',
            'messageImagenes' => $httpStatusCode . ' en ACTUALIZACION IMAGENES PRODUCTO'
        ];
    } else {
        return [
            'statusImagenes' => 'success',
            'messageImagenes' => $httpStatusCode . ' en ACTUALIZACION IMAGENES PRODUCTO'
        ];
    }
}

echo json_encode($responseArray);
?>