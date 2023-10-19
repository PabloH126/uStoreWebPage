<?php
session_start();
header('Content-Type: application/json');
$responseArray = [];
if(!isset($_POST["idChat"]) || $_POST["idChat"] == "undefined")
{
    $responseArray = [
        "status" => "error",
        "message" => "idChat no establecido"
    ];
    echo json_encode($responseArray);
    exit;
}
else
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Chat/GetChat?idChat=" . $_POST['idChat']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
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

    if($httpStatusCode != 200)
    {
        $responseArray = [
            "status" => "error",
            "message" => $httpStatusCode . ": " . $response
        ];
        echo json_encode($responseArray);
        exit;
    }

    curl_close($ch);

    $dataChat = json_decode($response, true);
    $responseArray = [
        "status" => "success",
        "message" => $dataChat
    ];
    echo json_encode($responseArray);
    exit;
}
?>