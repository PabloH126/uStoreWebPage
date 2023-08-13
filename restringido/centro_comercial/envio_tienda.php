<?php
    session_start();
    //CREATE TIENDA

    $data = [
        'NombreTienda' => $_POST['nombreTienda'],
        'IdCentroComercial' => $_SESSION['idMall'],
    ];
    
    $logoTienda = $_FILES['logoTienda'];

    $ch = curl_init();

    $data['logoTienda'] = curl_file_create($logoTienda['tmp_name'], $logoTienda['type'], $logoTienda['name']);
    
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/CreateTienda");
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

    if($httpStatusCode != 201)
    {
        echo $httpStatusCode;
    }

    $dataTienda = json_decode($response, true);

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
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Horarios/CreateHorario");
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
        echo $httpStatusCode;
    }

    curl_close($ch);
//----------------------------------------------------------------------------------------// 


    //CREATE CATEGORIAS TIENDA
    
    $categorias = $_POST['categorias'];

    $arraysCategorias = array ();

    foreach($categorias as $cat)
    {
        $arraysCategorias[] = generateArrayCategorias($cat, $dataTienda);
    }

    $jsonData = json_encode($arraysCategorias);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Categorias/CreateCategoriaTienda");
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
        echo $httpStatusCode;
    }
    
    curl_close($ch);
//----------------------------------------------------------------------------------------//   


    //CREATE PERIODOS PREDETERMINADOS TIENDA
    $periodos = generateArrayPeriodosPredeterminados($dataTienda);

    $jsonData = json_encode($periodos);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/PeriodosPredeterminados/CreatePeriodos");
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
    
    curl_close($ch);

    if($httpStatusCode != 200)
    {
        echo $httpStatusCode;
    }
//----------------------------------------------------------------------------------------//   


    //CREATE IMAGENES BANNER TIENDA

    $imagen1 = $_FILES['imagen1'];
    $imagen2 = $_FILES['imagen2'];
    $imagen3 = $_FILES['imagen3'];

    $data = [];
    $data['primera'] = curl_file_create($imagen1['tmp_name'], $imagen1['type'], $imagen1['name']);
    $data['segunda'] = curl_file_create($imagen2['tmp_name'], $imagen2['type'], $imagen2['name']);
    $data['tercera'] = curl_file_create($imagen3['tmp_name'], $imagen3['type'], $imagen3['name']);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/CreateImagenNewTienda?idTienda=" . $dataTienda['idTienda']);
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
        echo $httpStatusCode;
    }

    $dataTienda = json_decode($response, true);

    curl_close($ch);
//----------------------------------------------------------------------------------------//   


    header('Location: https://ustoree.azurewebsites.net/restringido/centro_comercial/lista_tiendas.php?id=' . $dataTienda['idTienda']);


//----------------------------------------------------------------------------------------//     
    //FUNCIONES
    function generateArrayCategorias($cat, $dataTienda)
    {
        return array(
            "idTienda" => $dataTienda['idTienda'],
            "idCategoria" => $cat
        );
    }

    function generateArrayPeriodosPredeterminados($dataTienda)
    {
        $periodos = [];
        for($i = 1; $i <= 3; $i++)
        {
            $numero = $_POST['numeroPeriodo' . $i];
            $tiempo = $_POST['tiempoPeriodo' . $i];

            $apartadoPredeterminado = $numero . ' ' . $tiempo;
            $periodos[] = [
                'apartadoPredeterminado' => $apartadoPredeterminado,
                'idTienda' => $dataTienda['idTienda']
            ];
        } 

        return $periodos;
    }

    function generateArrayHorario($dia, $dataTienda)
    {
        if(isset($_POST['horas' . $dia . 'apertura']) && isset($_POST['minutos' . $dia . 'apertura']) && isset($_POST['am/pm' . $dia . 'apertura'])
         && isset($_POST['horas' . $dia . 'cierre']) && isset($_POST['minutos' . $dia . 'cierre']) && isset($_POST['am/pm' . $dia . 'cierre']))
        {
            return array(
                "dia" => $dia,
                "horarioApertura" => $_POST['horas' . $dia . 'apertura'] . ':' . $_POST['minutos' . $dia . 'apertura'] . ' ' . $_POST['am/pm' . $dia . 'apertura'],
                "horarioCierre" =>  $_POST['horas' . $dia . 'cierre'] . ':' . $_POST['minutos' . $dia . 'cierre'] . ' ' . $_POST['am/pm' . $dia . 'cierre'],
                "idTienda" => $dataTienda['idTienda']
            );
        }
    }
?>

