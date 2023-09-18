<?php
session_start();
$responseArray = [];
header('Content-Type: application/json');

if (!isset($_POST['statusSolicitud']) || ($_POST['statusSolicitud'] != "activa" && $_POST['statusSolicitud'] != "rechazada" && $_POST['statusSolicitud'] != "completada"))
{
    $responseArray['status'] = 'error';
    $responseArray['message'] = "el estatus no ha sido especificado o no es valido";
    echo json_encode($responseArray);
    exit;
}
else if (!isset($_POST['idSolicitud']))
{
    $responseArray['status'] = 'error';
    $responseArray['message'] = "el id de la solicitud no ha sido especificado";
    echo json_encode($responseArray);
    exit;
}

$data = [
    'idSolicitud' => $_POST['idSolicitud'],
    'statusSolicitud' => $_POST['statusSolicitud']
];

$dataJson = json_encode($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Apartados/UpdateSolicitud");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_COOKIE['SessionToken'],
    'Content-Type: application/json',
    'Content-Length: ' . strlen($dataJson)
));

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if($httpStatusCode != 204)
{
    $responseArray['status'] = 'error';
    $responseArray['message'] = $httpStatusCode . ' ACTUALIZAR Solicitud';
}
else
{
    $responseArray['status'] = 'success';
}

echo json_encode($responseArray);
exit;
?>