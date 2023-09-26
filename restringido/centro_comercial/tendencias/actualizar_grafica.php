<?php
    header('Content-Type: application/json');
    session_start();
    $responseArray = [];

    $isTiendaValue = isset($_POST['isTienda']) ? $_POST['isTienda'] : 'false';
    $isTienda = ($isTiendaValue === 'true' || $isTiendaValue === true);

    $data = [
        "isTienda" => $isTienda,
        "categorias" => (isset($_POST['categorias']) ? $_POST['categorias'] : []),
        "periodoTiempo" => (isset($_POST['periodoTiempo']) ? $_POST['periodoTiempo'] : "semanal")
    ];

    echo json_encode(['status' => $data]);
        exit;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/TendenciasVenta/GetTendencias");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_COOKIE['SessionToken'],
        'Content-Type: application/json'
    )
    );
    
    $response = curl_exec($ch);
    
    if ($response === false) {
        echo json_encode(['status' => 'Error: ' . curl_error($ch)]);
        exit;
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
    
    if($httpStatusCode != 200)
    {
        echo json_encode(['status' => 'Error: ' . $httpStatusCode]);
        exit;
    }

    $tendencias = json_decode($response, true);
    
    curl_close($ch);

    $responseArray['status'] = "success";
    $responseArray['tendencia'] = $tendencias;
    
    echo json_encode($responseArray);
?>