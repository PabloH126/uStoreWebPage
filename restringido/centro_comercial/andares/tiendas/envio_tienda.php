<?php
    session_start();

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/CreateTienda");
    curl_setopt($ch, CURLOPT_POST)
?>