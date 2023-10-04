<?php
session_start();
header('Content-Type: application/json');

//Validación de imagenes
$allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
$maxSize = 1 * 1024 * 1024; // 1 MB

$profileImage = $_POST['newImageProfile'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/AdminsTienda/UpdateProfileImage");
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

if($httpStatusCode == 400)
{

}

curl_close($ch);
?>