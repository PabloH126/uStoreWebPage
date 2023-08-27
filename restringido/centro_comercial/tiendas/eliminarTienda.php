<?php
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/DeleteTienda?id=" . $_SESSION['idTienda']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
        array(
            'Authorization: Bearer ' . $_COOKIE['SessionToken']
        )
    );

    $response = curl_exec($ch);

    if ($response === false) {
        echo 'Error: ' . curl_error($ch);
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    curl_close($ch);

    $responseArray = array();

    if ($httpStatusCode != 204) {
        $responseArray['status'] = 'error';
        $responseArray['message'] = $httpStatusCode;
    }
    else
    {
        $responseArray['status'] = 'success';
        $responseArray['idMall'] = $_SESSION['idMall'];
    }
    
    echo json_encode($responseArray);
?>