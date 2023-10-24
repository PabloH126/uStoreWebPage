<?php
    session_start();
    header('Content-Type: application/json');
    $responseArray = [];
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Chat/GetChats?typeChat=Usuario");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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

    if ($httpStatusCode !== 200) {
        $responseArray = [
            "status" => "error",
            "message" => $httpStatusCode . ": " . $response
        ];
        echo json_encode($responseArray);
        exit;
    }

    curl_close($ch);

    $chatsUsuario = json_decode($response, true);
    
    $responseArray = [
        'status' => 'success',	
        'chatsUsuario' => $chatsUsuario
    ];
    echo json_encode($responseArray);
    exit;
?>