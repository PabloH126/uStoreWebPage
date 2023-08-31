<?php
session_start();
$imagenes = [];
$responseArray = [];

verificarImagen('imagen1', $_FILES['imagen1'], $imagenes);
verificarImagen('imagen2', $_FILES['imagen2'], $imagenes);
verificarImagen('imagen3', $_FILES['imagen3'], $imagenes);
verificarImagen('imagen4', $_FILES['imagen4'], $imagenes);
verificarImagen('imagen5', $_FILES['imagen5'], $imagenes);

$idProducto = $_POST['idProducto']; // Recuperar el idProducto desde el formulario

//----------------------------------------------------------------------------------------//   

//CREATE IMAGENES DE PRODUCTO

foreach($imagenes as $key => $imagen) {
    $data = [
        'imagen' => curl_file_create($imagen['tmp_name'], $imagen['type'], $imagen['name'])
    ];
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Productos/CreateImageProducto?idProducto=" . $idProducto); // Usar el idProducto recuperado
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_COOKIE['SessionToken']
    ));
    
    $response = curl_exec($ch);
    
    if ($response === false) {
        echo 'ErrorSoli: ' . curl_error($ch);
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    if($httpStatusCode != 200) {
        $responseArray['statusImagenes'] = 'error';
        $responseArray['messageImagenes'] = $httpStatusCode . ' CREACION IMAGENES PRODUCTO <br>';
    } else {
        $responseArray['statusImagenes'] = 'success';
        $responseArray['messageImagenes'] = $httpStatusCode . ' CREACION IMAGENES PRODUCTO <br>';
    }

    curl_close($ch);
}

//----------------------------------------------------------------------------------------// 

//FUNCIONES

function verificarImagen($nombreImagen, $imagen, &$imagenes) { // Nota: &$imagenes para modificar el array original
    //Validación de imagenes
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $maxSize = 1 * 1024 * 1024; // 1megabyte

    if(isset($imagen) && $imagen['error'] == 0) {
        if(in_array($imagen['type'], $allowedImageTypes) && $imagen['size'] <= $maxSize) {
            $imagenes[$nombreImagen] = $imagen;
        } else {
            die("Error las imagenes de producto:" . $nombreImagen . " no válida. Asegúrate de subir un archivo de imagen (JPEG, PNG o JPG) que no supere los 5 MB de tamaño máximo y/o sea de un tipo de imagen válido.");
        }
    }
}

echo json_encode($responseArray);
?>