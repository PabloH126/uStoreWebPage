<?php
session_start();
header('Content-Type: application/json');
$idUser = [];

$idUser['idUser'] = $_SESSION['idUser'];
$idUser['idAdmin'] = $_SESSION['Admin'];
$idUser['typeUser'] = $_SESSION['UserType'];
echo json_encode($idUser);
exit;
?>