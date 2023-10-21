<?php
session_start();
header('Content-Type: application/json');

$responseArray = [];

if((!isset($_POST["idMiembro2"]) || $_POST["idMiembro2"] == "undefined") ||
   (!isset($_POST["typeMiembro2"]) || $_POST["typeMiembro2"] == "undefined") ||
   (!isset($_POST["contenidoMensaje"]) || $_POST["contenidoMensaje"] == "undefined"))
   {
    $responseArray = [
        "status" => "error",
        "message" => "Datos necesarios no establecidos"
    ];
    echo json_encode($responseArray);
    exit;
   }

$data = [
    "Contenido" => $_POST["contenidoMensaje"]
];

$imagenMensaje = $_FILES["imagen"];

if (isset($imagenMensaje))
{
    if(verificarImagen($imagenMensaje))
    {
        $data = [
            'image' => curl_file_create($imagenMensaje['tmp_name'], $imagenMensaje['type'], $imagenMensaje['name'])
        ];
    }
    else
    {
        $responseArray = [
            "status" => "error",
            "message" => "Imagen no valida"
        ];
        echo json_encode($responseArray);
        exit;
    }   
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://ustoreapi.azurewebsites.net/api/Chat/CreateChat?idMiembro2=' . $_POST["idMiembro2"] . '&typeMiembro2=' . $_POST["typeMiembro2"]);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_COOKIE['SessionToken'],
    'Content-Type: multipart/form-data'
));

$response = curl_exec($ch);

if ($response === false) {
    $responseArray = [
        "status" => "error",
        "message" => 'Error: ' . curl_error($ch)
    ];
    echo json_encode($responseArray);
    exit;
} else {
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode != 200)
{
    $responseArray = [
        "status" => "error",
        "message" => $httpStatusCode . ": " . $response
    ];
    echo json_encode($responseArray);
    exit;
}

curl_close($ch);

$dataResponse = json_decode($response, true);

$responseArray = [
    "status" => "success",
    "message" => "Chat creado con éxito",
    "idChat" => $dataResponse['idChat']
];
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