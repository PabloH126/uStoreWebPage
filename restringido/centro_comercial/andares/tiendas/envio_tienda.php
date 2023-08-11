<?php
    session_start();

    $logoTienda = $_FILES['logoTienda'];
    $ch = curl_init();
    
    $data = array(
        'NombreTienda' => $_POST['nombreTienda'],
        'IdCentroComercial' => $_SESSION['idMall'],
        'logoTienda' => new CURLFile($logoTienda['tmp_name'], $logoTienda['type'], $logoTienda['name'])
    );
    
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/CreateTienda");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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

    function generateArrayHorario($dia)
    {
        if(isset($_POST['horas' . $dia . 'apertura']) && isset($_POST['minutos' . $dia . 'apertura']) && isset($_POST['am/pm' . $dia . 'apertura'])
         && isset($_POST['horas' . $dia . 'cierre']) && isset($_POST['minutos' . $dia . 'cierre']) && isset($_POST['am/pm' . $dia . 'cierre']))
        {
            array(
                "dia" => $dia,
                "horarioApertura" => $_POST['horas' . $dia . 'apertura'] . ':' . $_POST['minutos' . $dia . 'apertura'] . ' ' . $_POST['am/pm' . $dia . 'apertura'],
                "horarioCierre" =>  $_POST['horas' . $dia . 'cierre'] . ':' . $_POST['minutos' . $dia . 'cierre'] . ' ' . $_POST['am/pm' . $dia . 'cierre'],
                "idTienda" => 
            );
        }
    }
?>

