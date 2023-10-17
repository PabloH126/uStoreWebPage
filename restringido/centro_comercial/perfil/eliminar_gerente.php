<?php
session_start();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Gerentes/DeleteAccount?idGerente=" . $_GET['id']);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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

$responseArray = [
    'status' => 'success',
    'message' => 'Gerente eliminado con éxito'
];

curl_close($ch);
echo json_encode($responseArray);
exit;
?>