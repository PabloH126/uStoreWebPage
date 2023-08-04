<?php
session_start();
if(!isset($_COOKIE['SessionToken']))
{
	header("location: ../index.php");
}

$token = $_COOKIE['SessionToken'];
list($header, $payload, $signature) = explode('.', $token);
$payload = base64_decode(str_pad(strtr($payload, '-_', '+/'), strlen($payload) % 4, '=', STR_PAD_RIGHT));
$payload = json_decode($payload);

$_SESSION['email'] = $payload->Email;
$_SESSION['nombre'] = $payload->name;
$_SESSION['id'] = $payload->sub;

echo $_SESSION['email'];
if($_SESSION['nombre'] == null)
{
    $_SESSION['nombre'] == "No hay nombre";
}
echo $_SESSION['id'];
?>