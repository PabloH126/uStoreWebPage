<?php
    session_start();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Register/RegisterUser");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_GET['token']
    ));
    
    $response = curl_exec($ch);
    
    if ($response === false) {
        echo 'Error: ' . curl_error($ch);
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    curl_close($ch);

    if ($httpStatusCode != 201)
    {
       $_SESSION['errorRegistroUser'] = $httpStatusCode . ': ' . $response;
    }

    header("location: https://ustoree.azurewebsites.net/users/confirmacion_user.php");
?>