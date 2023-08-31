<?php
    session_start();

    $responseArray = [];

    if(isset($_POST['idProducto']) && isset($_POST['stock'])) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Productos/UpdateStockProducto?idProducto=" . $_POST['idProducto'] . '&stock=' . $_POST['stock']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $_COOKIE['SessionToken']
        ));
        
        $response = curl_exec($ch);
        
        if ($response === false) {
            echo 'Error: ' . curl_error($ch);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        }

        if($httpStatusCode != 204)
        {
            $responseArray['status'] = 'error';
            $responseArray['message'] = $httpStatusCode;
        }

        curl_close($ch);
        
        $responseArray['status'] = 'success';
        $responseArray['message'] = 'Stock actualizado correctamente';
        
    }
    else
    {
        $responseArray['status'] = 'error';
        $responseArray['message'] = 'Datos no recibidos correctamente';
    }
    
    echo json_encode($responseArray);
?>