<?php
    session_start();
    header('Content-Type: application/json');

    $responseArray = [];

    if ((!isset($_POST['contenidoMensaje']) || $_POST['contenidoMensaje'] == "undefined") 
     || (!isset($_POST["idChat"]) || $_POST["idChat"] == "undefined"))
    {
    $responseArray = [
        "status" => "error",
        "message" => "Datos necesarios no establecidos"
    ];
    echo json_encode($responseArray);
    exit;
    }

    $data = [
    "Contenido" => $_POST["contenidoMensaje"],
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
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Chat/CreateChat?idChat=" . $_POST["idChat"]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_COOKIE['SessionToken']
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

    $responseArray = [
        "status" => "success",
        "message" => "Mensaje creado con éxito"
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