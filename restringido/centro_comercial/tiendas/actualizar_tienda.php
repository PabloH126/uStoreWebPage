<?php
    session_start();
    $responseArray = [];
    header('Content-Type: application/json');
    
    //Validación de imagenes
    $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $maxSize = 1 * 1024 * 1024; // 1 MB

    //UPDATE TIENDA
    $idTienda = $_POST['idTienda'];
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
        $responseArray['statusTienda'] = 'error';
        $responseArray['messageTienda'] = $httpStatusCode . ' ACTUALIZAR Tienda <br>';
    }
    else
    {
        $responseArray['idTienda'] = $idTienda;
        $responseArray['statusTienda'] = 'success';
    }

    $dataTienda = json_decode($response, true);

    $urlSalida = 'https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/perfil_tienda.php?id=' . $_GET['id'];

    curl_close($ch);
//----------------------------------------------------------------------------------------//   


    //UPDATE HORARIO

    $arraysHorario = array(
        generateArrayHorario('Lunes'),
        generateArrayHorario('Martes'),
        generateArrayHorario('Miércoles'),
        generateArrayHorario('Jueves'),
        generateArrayHorario('Viernes'),
        generateArrayHorario('Sábado'),
        generateArrayHorario('Domingo')
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
        $responseArray['statusHorarios'] = 'error';
        $responseArray['messageHorarios'] = $httpStatusCode . ' ACTUALIZACION HORARIO <br>';
    }
    else
    {
        $responseArray['statusHorarios'] = 'success';
        $responseArray['messageHorarios'] = $httpStatusCode . ' ACTUALIZACION HORARIO <br>';
    }

    curl_close($ch);
//----------------------------------------------------------------------------------------// 


    //UPDATE CATEGORIAS TIENDA
    
    $categorias = $_POST['categorias'];

    $arraysCategorias = array ();

    foreach($categorias as $index => $cat)
    {
        $arraysCategorias[] = generateArrayCategorias($cat);
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
        $responseArray['statusCatT'] = 'error';
        $responseArray['messageCatT'] = $httpStatusCode . 'CATEGORIAS TIENDA';
    }
    else
    {
        $responseArray['statusCatT'] = 'success';
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
        $responseArray['statusPeriodos'] = 'error';
        $responseArray['messagePeriodos'] = $httpStatusCode . ' ACTUALIZACION Periodos predeterminados <br>';
    }
    else
    {
        $responseArray['statusPeriodos'] = 'success';
        $responseArray['urlSalida'] = $urlSalida;
    }
//----------------------------------------------------------------------------------------//   
    //FUNCIONES
    function generateArrayCategorias($cat)
    {
        return [
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

    function generateArrayHorario($dia)
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