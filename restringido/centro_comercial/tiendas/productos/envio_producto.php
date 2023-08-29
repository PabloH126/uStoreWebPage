<?php
    session_start();
    $responseArray = [];
    //CREATE PRODUCTO
    
    $data = [
        "nombreProducto" => $_POST['nombreProducto'],
        "precioProducto" => $_POST['precioProducto'],
        "cantidadApartado" => $_POST['cantidadApartar'],
        "descripcion" => $_POST['descripcionProducto'],
        "stock" => 0,
        "idTienda" => $_SESSION['idTienda']
    ];

    foreach ($data as $key => $value)
    {
        echo $key . ' : ' . $value . '<br>';
    }
    
    $jsonData = json_encode($data);

    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Productos/CreateProducto");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_COOKIE['SessionToken'],
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    ));
    
    $response = curl_exec($ch);
    
    if ($response === false) {
        echo 'Error: ' . curl_error($ch);
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    if($httpStatusCode != 200)
    {
        $responseArray['statusProducto'] = 'error';
        $responseArray['messageProducto'] = $httpStatusCode . ' CREACION PRODUCTO <br>';
    }
    else
    {
        $_SESSION['idProducto'] = json_decode($response, true);
        $responseArray['statusProducto'] = 'success';
        $responseArray['messageProducto'] = $_SESSION['idProducto'];
    }

    $urlSalida = 'https://ustoree.azurewebsites.net/restringido/centro_comercial/lista_productos.php?id=' . $_SESSION['idTienda'];

    curl_close($ch);
//----------------------------------------------------------------------------------------// 


    //CREATE CATEGORIAS PRODUCTO
    
    $categorias = $_POST['categorias'];

    $arraysCategorias = [];

    foreach($categorias as $cat)
    {
        $arraysCategorias[] = generateArrayCategorias($cat, $dataProducto);
    }

    $jsonData = json_encode($arraysCategorias);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Categorias/CreateCategoriaProducto");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_COOKIE['SessionToken'],
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    ));
    
    $response = curl_exec($ch);
    
    if ($response === false) {
        echo 'Error: ' . curl_error($ch);
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    if($httpStatusCode != 200)
    {
        $responseArray['statusCatP'] = 'error';
        $responseArray['messageCatP'] = $httpStatusCode . 'CATEGORIAS PRODUCTO';
    }
    else
    {
        $responseArray['statusCatP'] = 'success';
        $responseArray['urlSalida'] = $urlSalida;
    }
    
    curl_close($ch);

//----------------------------------------------------------------------------------------//       


    //FUNCIONES
    function generateArrayCategorias($cat, $dataProducto)
    {
        return [
            "idProductos" => $dataProducto['idProductos'],
            "idCategoria" => $cat
        ];
    }

?>