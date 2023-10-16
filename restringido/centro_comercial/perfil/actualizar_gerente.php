<?php

$data = [
    'primerNombre' => $_POST['nombreGerente'],
    'primerApellido' => $_POST['apellidoGerente'],
    ''

]
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_COOKIE['SessionToken']
));

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

curl_close($ch);
?>