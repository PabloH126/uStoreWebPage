<?php
    session_start();
    $responseArray = [];
    header('Content-Type: application/json');

    $categorias = $_POST['categorias'];
    if (count($categorias) > 8)
    {
        $responseArray['statusCatP'] = 'error';
        $responseArray['messageCatP'] = 'Hay más de 8 categorias seleccionadas';
        echo json_encode($responseArray);
        exit;
    }

    //UPDATE PRODUCTO
    $data = [
        "idProductos" => $_GET['id'],
        "nombreProducto" => $_POST['nombreProducto'],
        "precioProducto" => $_POST['precioProducto'],
        "cantidadApartado" => $_POST['cantidadApartar'],
        "descripcion" => $_POST['descripcionProducto']
    ];

    $jsonData = json_encode($data);

    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Productos/UpdateProducto");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
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

    if($httpStatusCode != 204)
    {
        $responseArray['statusProducto'] = 'error';
        $responseArray['messageProducto'] = $httpStatusCode . ' CREACION PRODUCTO <br>';
    }
    else
    {
        $responseArray['idProducto'] = json_decode($response, true);
        $responseArray['statusProducto'] = 'success';
        $responseArray['messageProducto'] = $_SESSION['idProducto'];
    }

    $urlSalida = 'https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/productos/perfil_producto.php?id=' . $_GET['id'];

    curl_close($ch);
//----------------------------------------------------------------------------------------// 


    //CREATE CATEGORIAS PRODUCTO
    
    $arraysCategorias = [];

    foreach($categorias as $cat)
    {
        $arraysCategorias[] = generateArrayCategorias($cat, $responseArray);
    }

    $jsonData = json_encode($arraysCategorias);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Categorias/UpdateCategoriasProducto");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
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

    if($httpStatusCode != 204)
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
    function generateArrayCategorias($cat, $responseArray)
    {
        return [
            "idProductos" => $_GET['id'],
            "idCategoria" => $cat
        ];
    }

    echo json_encode($responseArray);
?>