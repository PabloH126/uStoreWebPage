<?php
session_start();

$responseArray = [];

$imagenPerfil = $_FILES['logoTienda'];

$contrasena = $_POST['passwordGerente'];
$contra = md5(md5($contrasena));

$data = [
    'idCuentaGerente' => $_SESSION['idCuentaGerente'],
    'password' => $contra,
    'primerNombre' => $_POST['nombreGerente'],
    'primerApellido' => $_POST['apellidoGerente'],
    'idTienda' => $_POST['idTienda'],
];

unset($_SESSION['idCuentaGerente']);

$dataJson = json_encode($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Gerentes/UpdateGerente");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_COOKIE['SessionToken'],
    'Content-Type: application/json'
));

$response = curl_exec($ch);

if ($response === false) {
    $responseArray = [
        'status' => 'error',
        'message' => 'Error curl:' . curl_error($ch)
    ];
    echo json_encode($responseArray);
    curl_close($ch);
    exit;
} else {
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode != 204)
{
    $responseArray = [
        'status' => 'error',
        'message' => $response
    ];
    echo json_encode($responseArray);
    curl_close($ch);
    exit;
}

if (verificarImagen($imagenPerfil))
{
    $dataImagen = [
        'image' => curl_file_create($imagenPerfil['tmp_name'], $imagenPerfil['type'], $imagenPerfil['name'])
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://ustoreapi.azurewebsites.net/api/Gerentes/UpdateProfileImage?idGerente=' . $_GET['id']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataImagen);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_COOKIE['SessionToken']
    ));

    $response = curl_exec($ch);

    if ($response === false) {
        $responseArray = [
            'status' => 'error',
            'message' => curl_error($ch)
        ];
        echo json_encode($responseArray);
        curl_close($ch);
        exit;
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
    
    if ($httpStatusCode != 200)
    {
        $responseArray = [
            'status' => 'error',
            'message' => $response
        ];
        echo json_encode($responseArray);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    $responseArray = [
        'status' => 'success',
        'message' => 'Gerente e imagen de perfil actualizados con éxito'
    ];

    curl_close($ch);
    echo json_encode($responseArray);
    exit;
}
else
{
    $responseArray = [
        'status' => 'success',
        'message' => 'Gerente creado con éxito'
    ];

    curl_close($ch);
    echo json_encode($responseArray);
    exit;
}

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
    else
    {
        return false;
    }
}
?>