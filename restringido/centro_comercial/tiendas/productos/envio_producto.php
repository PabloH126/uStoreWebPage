<?php
    session_start();

    $imagenes = [];

    verificarImagen('imagen1', $_FILES['imagen1'], $imagenes);
    verificarImagen('imagen2', $_FILES['imagen2'], $imagenes);
    verificarImagen('imagen3', $_FILES['imagen3'], $imagenes);
    verificarImagen('imagen4', $_FILES['imagen4'], $imagenes);
    verificarImagen('imagen5', $_FILES['imagen5'], $imagenes);
    
    //CREATE PRODUCTO
    
    $data = [
        "nombreProducto" => $_POST['nombreProducto'],
        "precioProducto" => $_POST['precioProducto'],
        "cantidadApartado" => $_POST['cantidadApartar'],
        "descripcion" => $_POST['descripcionProducto'],
        "stock" => 0,
        "idTienda" => $_SESSION['idTienda']
    ];

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

    if($httpStatusCode != 201)
    {
        echo $httpStatusCode . ' create producto';
    }

    $dataProducto = json_decode($response, true);

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
        echo $httpStatusCode . ' create categorias de producto';
    }
    
    curl_close($ch);

//----------------------------------------------------------------------------------------//   


    //CREATE IMAGENES DE PRODUCTO
    
    
    $data = [];

    foreach($imagenes as $key => $imagen)
    {
        $data = [
            'imagen' => curl_file_create($imagen['tmp_name'], $imagen['type'], $imagen['name'])
        ];
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/CreateImagenTienda?idTienda=" . $dataProducto['idProductos']);
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

        if($httpStatusCode != 200)
        {
            echo $httpStatusCode . 'create imagenes producto';
        }

        curl_close($ch);
    }


//----------------------------------------------------------------------------------------//       


    //FUNCIONES
    function generateArrayCategorias($cat, $dataProducto)
    {
        return [
            "idProductos" => $dataProducto['idProductos'],
            "idCategoria" => $cat
        ];
    }

    function verificarImagen($nombreImagen, $imagen, $imagenes)
    {
        //Validación de imagenes
        $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 5 * 1024 * 1024; // 5 MB

        if(isset($imagen) && $imagen['error'] == 0)
        {
            if(in_array($imagen['type'], $allowedImageTypes) && $imagen['size'] <= $maxSize)
            {
                $imagenes[$nombreImagen] = $imagen;
            }
            else
            {
                die("Error las imagenes de producto:" . $nombreImagen . "no válida. Asegúrate de subir un archivo de imagen (JPEG, PNG o JPG) que no supere los 5 MB de tamaño máximo y/o sea de un tipo de imagen válido.");
            }
        }
    }


?>