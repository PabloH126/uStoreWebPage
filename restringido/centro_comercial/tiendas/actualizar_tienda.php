<?php
    session_start();

    //Validación de imagenes
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $maxSize = 5 * 1024 * 1024; // 5 MB
    $imagenes = [];
    $idImagenes = [];

    if(isset($_FILES['imagen1']) && $_FILES['imagen1']['error'] == 0)
    {
        if(in_array($_FILES['imagen1']['type'], $allowedImageTypes) && $_FILES['imagen1']['size'] <= $maxSize)
        {
            $imagenes[1] = $_FILES['imagen1'];
            $idImagenes[1] = $_POST['idImagen1'];
        }
        else
        {
            die("Error las imagenes de promociones: Imagen 1 no válida. Asegúrate de subir un archivo de imagen (JPEG, PNG o JPG) que no supere los 5 MB de tamaño máximo y/o sea de un tipo de imagen válido.");
        }
    }

    if(isset($_FILES['imagen2']) && $_FILES['imagen2']['error'] == 0)
    {
        if(in_array($_FILES['imagen2']['type'], $allowedImageTypes) && $_FILES['imagen2']['size'] <= $maxSize)
        {
            $imagenes[2] = $_FILES['imagen2'];
            $idImagenes[2] = $_POST['idImagen2'];
        }
        else
        {
            die("Error las imagenes de promociones: Imagen 2 no válida. Asegúrate de subir un archivo de imagen (JPEG, PNG o JPG) que no supere los 5 MB de tamaño máximo y/o sea de un tipo de imagen válido.");
        }
    }

    if(isset($_FILES['imagen3']) && $_FILES['imagen3']['error'] == 0)
    {
        if(in_array($_FILES['imagen3']['type'], $allowedImageTypes) && $_FILES['imagen3']['size'] <= $maxSize)
        {
            $imagenes[3] = $_FILES['imagen3'];
            $idImagenes[3] = $_POST['idImagen3'];
        }
        else
        {
            die("Error las imagenes de promociones: Imagen 3 no válida. Asegúrate de subir un archivo de imagen (JPEG, PNG o JPG) que no supere los 5 MB de tamaño máximo y/o sea de un tipo de imagen válido");
        }
    }

    //UPDATE TIENDA

    $data = [
        'idTienda' => $_GET['id'],
        'nombreTienda' => $_POST['nombreTienda']
    ];
    
    $ch = curl_init();

    if(isset($_FILES['logoTienda']) && $_FILES['logoTienda']['error'] == 0)
    {
        $logoTienda = $_FILES['logoTienda'];
        if(in_array($logoTienda['type'], $allowedImageTypes) && $logoTienda['size'] <= $maxSize)
        {
            $data['logoTienda'] = curl_file_create($logoTienda['tmp_name'], $logoTienda['type'], $logoTienda['name']);
        }
        else
        {
            curl_close($ch);
            die("Error: Logo de tienda no válido. Asegúrate de subir un archivo de imagen (JPEG, PNG o JPG) que no supere los 5 MB de tamaño máximo y/o sea de un tipo de imagen válido.");
        }
    }
    
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/UpdateTienda");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
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

    if($httpStatusCode != 204)
    {
        echo $httpStatusCode . ' update tienda';
    }

    $dataTienda = json_decode($response, true);

    $urlSalida = 'https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/perfil_tienda.php?id=' . $_GET['id'];

    curl_close($ch);
//----------------------------------------------------------------------------------------//   


    //CREATE HORARIO

    $arraysHorario = array(
        generateArrayHorario('Lunes', $dataTienda),
        generateArrayHorario('Martes', $dataTienda),
        generateArrayHorario('Miércoles', $dataTienda),
        generateArrayHorario('Jueves', $dataTienda),
        generateArrayHorario('Viernes', $dataTienda),
        generateArrayHorario('Sábado', $dataTienda),
        generateArrayHorario('Domingo', $dataTienda)
    );

    $jsonData = json_encode($arraysHorario);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Horarios/UpdateHorario");
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
        echo $httpStatusCode . ' update horario';
    }

    curl_close($ch);
//----------------------------------------------------------------------------------------// 


    //CREATE CATEGORIAS TIENDA
    
    $categorias = $_POST['categorias'];
    $idCTs = $_POST['idCTs'];

    $arraysCategorias = array ();

    foreach($categorias as $index => $cat)
    {
        $idCT = $idCTs[$index];
        $arraysCategorias[] = generateArrayCategorias($cat, $idCT, $dataTienda);
    }

    $jsonData = json_encode($arraysCategorias);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Categorias/UpdateCategoriasTienda");
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
        echo $httpStatusCode . ' update categorias de tienda';
    }
    
    curl_close($ch);
//----------------------------------------------------------------------------------------//   


    //CREATE PERIODOS PREDETERMINADOS TIENDA
    $periodos = generateArrayPeriodosPredeterminados($dataTienda);

    $jsonData = json_encode($periodos);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/PeriodosPredeterminados/UpdatePeriodo");
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
    
    curl_close($ch);

    if($httpStatusCode != 204)
    {
        echo $httpStatusCode . ' update periodos predeterminados';
    }
//----------------------------------------------------------------------------------------//   


    //CREATE IMAGENES BANNER TIENDA
    
    
    $data = [];

    foreach($imagenes as $index => $imagen)
    {
        $data = [
            'imagen' => curl_file_create($imagen['tmp_name'], $imagen['type'], $imagen['name'])
        ];
        echo $index . '<br>';
        echo $_POST['idImagen1'] . '<br>';
        echo $_POST['idImagen2'] . '<br>';
        echo $_POST['idImagen3'] . '<br>';
        echo $idImagenes[$index];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/UpdateImagenTienda?idTienda=" . $_GET['id'] . "&idImagenTienda=" . $idImagenes[$index]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
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

        if($httpStatusCode != 204)
        {
            echo $httpStatusCode . 'update imagenes tienda';
        }

        curl_close($ch);
    }

//----------------------------------------------------------------------------------------//       

    //FUNCIONES
    function generateArrayCategorias($cat, $idCT, $dataTienda)
    {
        return [
            "idCT" => $idCT,
            "idTienda" => $_GET['id'],
            "idCategoria" => $cat
        ];
    }

    function generateArrayPeriodosPredeterminados($dataTienda)
    {
        $periodos = [];
        for($i = 1; $i <= 3; $i++)
        {
            $numero = str_pad($_POST['numeroPeriodo' . $i], 2, 0, STR_PAD_LEFT);
            $tiempo = $_POST['tiempoPeriodo' . $i];
            
            if($numero != "" && $tiempo != "")
            {
                $apartadoPredeterminado = $numero . ' ' . $tiempo;
                $periodos[] = [
                    'idApartadoPredeterminado' => $_POST['idApartadoPredeterminadoPeriodo' . $i],
                    'apartadoPredeterminado' => $apartadoPredeterminado,
                    'idTienda' => $_GET['id']
                ];
            }
        } 

        return $periodos;
    }

    function generateArrayHorario($dia, $dataTienda)
    {
        if(((isset($_POST[$dia . '_apertura']) && $_POST[$dia . '_apertura'] != "") 
            && (isset($_POST[$dia . '_cierre']) && $_POST[$dia . '_cierre'] != "")
            && ($_POST[$dia . '_apertura'] != "00:00" || $_POST[$dia . '_cierre'] != "00:00")))
        {
            return [
                "dia" => $dia,
                "horarioApertura" => $_POST[$dia . '_apertura'],
                "horarioCierre" =>  $_POST[$dia . '_cierre'],
                "idTienda" => $_GET['id']
            ];
        }
        else
        {
            return [
                "dia" => $dia,
                "horarioApertura" => "00:00",
                "horarioCierre" =>  "00:00",
                "idTienda" => $_GET['id']
            ];
        }
    }
//----------------------------------------------------------------------------------------//  

    header('Location: ' . $urlSalida);
    exit;
?>