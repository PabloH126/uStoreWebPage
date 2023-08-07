<?php
session_start();
/*if(!isset($_COOKIE['SessionToken']))
{
    header("location: ../index.php");
}
*/
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Login/getClaims");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $_COOKIE['SessionToken']
)
);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode != 200) {
    echo $httpStatusCode;
    echo $response;
}
$data = json_decode($response, true);

curl_close($ch);

$_SESSION['nombre'] = $data['nombre'];
$_SESSION['email'] = $data['email'];
$_SESSION['id'] = $data['id'];
?>