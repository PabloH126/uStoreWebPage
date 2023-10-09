<?php
session_start();
require '../../security.php';
header('Content-Type: application/json');

$responseArray = [];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Gerentes/VerifyEmail?email=" . $_POST['email']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_COOKIE['SessionToken']
));

$response = curl_exec($ch);

if ($response === false) {
    $responseArray = [
        'status' => 'error',
        'message' => 'Error: ' . curl_error($ch)
    ];
    echo json_encode($responseArray);
} else {
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode == 409)
{
    $responseArray = [
        'status' => 'error',
        'message' => 'Email ya registrado en uStore'
    ];
    echo json_encode($responseArray);
}

$responseArray = [
    'status' => 'success',
    'message' => 'Email disponible'
];

echo json_encode($responseArray);

curl_close($ch);
exit;
/*
$data = [
    'password' => $_POST['password'],
    'email' => $_POST['email'],
    'primerNombre' => $_POST['primerNombre'],
    'primerApellido' => $_POST['primerApellido']
]
*/
?>