<?php
session_start();
header('Content-Type: application/json');
$responseArray = [];

//Validación de imagenes
$allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
$maxSize = 1 * 1024 * 1024; // 1 MB

$profileImage = $_FILES['newImageProfile'];

$imagenV = verificarImagen($profileImage);

if($imagenV === true){
    $data = [
        'image' => curl_file_create($profileImage['tmp_name'], $profileImage['type'], $profileImage['name'])
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/AdminsTienda/UpdateProfileImage");
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
        $responseArray['statusImagen'] = "error";
        $responseArray['message'] = "Hubo un error al mandar la solicitud a la api: " . curl_error($ch);
        echo json_encode($responseArray);
        exit;
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
    /*
    if($httpStatusCode != 200)
    {
        $responseArray['statusImagen'] = "error";
        $responseArray['message'] = "Hubo un error al mandar la solicitud a la api: " . $httpStatusCode;
    }
    */
    $data = json_decode($response);

    $responseArray['statusImagen'] = "success";
    $responseArray['imagenPerfil'] = $data['imageUrl'];
    
    curl_close($ch);
}
else
{
    $responseArray['statusImagen'] = "error";
    $responseArray['message'] = "Error la imagen de perfil no válida. Asegúrate de subir un archivo de imagen (JPEG, PNG o JPG) que no supere 1 MB de tamaño máximo y/o sea de un tipo de imagen válido.";
}
echo json_encode($responseArray);
exit;

function verificarImagen($imagen) {
    //Validación de imagenes
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $maxSize = 1 * 1024 * 1024; // 1 megabyte

    if(isset($imagen) && $imagen['error'] == 0) {
        if(in_array($imagen['type'], $allowedImageTypes) && $imagen['size'] <= $maxSize) {
            return true;
        } else {
            return false;
        }
    }
}

?>