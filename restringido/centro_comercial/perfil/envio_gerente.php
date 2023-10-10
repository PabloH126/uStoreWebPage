<?php
session_start();
header('Content-Type: application/json');
$responseArray = [];

if($_POST['codigoConfirm'] != $_SESSION['claveConfirm'])
{
    $responseArray = [
        'status' => 'error',
        'message' => 'Código de confirmacion incorrecto'
    ];
    echo json_encode($responseArray);
    exit;
}

unset($_SESSION['claveConfirm']);

$data = [
    'password' => $_POST['passwordGerente'],
    'email' => $_POST['correoGerente'],
    'primerNombre' => $_POST['nombreGerente'],
    'primerApellido' => $_POST['apellidoGerente']
];

$dataJson = json_encode($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://ustoreapi.azurewebsites.net/api/Register/RegisterGerente?idTienda=' . $_POST['idTienda']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_COOKIE['SessionToken']
));

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode != 201)
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
    'message' => 'Gerente creado con éxito'
];

curl_close($ch);
echo json_encode($responseArray);
exit;
?>