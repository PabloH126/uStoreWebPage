<?php
session_start();
header('Content-Type: application/json');
$idUser = [];

$idUser['idUser'] = $_SESSION['idUser'];
echo json_encode($idUser);
exit;
?>