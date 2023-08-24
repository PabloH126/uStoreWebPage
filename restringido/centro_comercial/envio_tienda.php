<?php
    session_start();

    //CREATE TIENDA

    $data = [
        'NombreTienda' => $_POST['nombreTienda'],
        'IdCentroComercial' => $_SESSION['idMall'],
        'rangoPrecio' => 0,
        'apartados' => 0,
        'vistas' => 0
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
        echo $httpStatusCode . ' create tienda';
    }

    $dataTienda = json_decode($response, true);

    $urlSalida = 'https://ustoree.azurewebsites.net/restringido/centro_comercial/lista_tiendas.php?id=' . $_SESSION['idMall'];

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
        echo $httpStatusCode . ' create horario';
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
        echo $httpStatusCode . ' create categorias de tienda';
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
        echo $httpStatusCode . ' create periodos predeterminados';
    }
//----------------------------------------------------------------------------------------//   


    //CREATE IMAGENES BANNER TIENDA
    $imagenes = [];

    if(isset($_FILES['imagen1']) && $_FILES['imagen1']['error'] == 0)
    {
        $imagenes['imagen1'] = $_FILES['imagen1'];
    }

    if(isset($_FILES['imagen2']) && $_FILES['imagen2']['error'] == 0)
    {
        $imagenes['imagen2'] = $_FILES['imagen2'];
    }

    if(isset($_FILES['imagen3']) && $_FILES['imagen3']['error'] == 0)
    {
        $imagenes['imagen3'] = $_FILES['imagen3'];
    }    
    $data = [];

    foreach($imagenes as $key => $imagen)
    {
        $data = [
            'imagen' => curl_file_create($imagen['tmp_name'], $imagen['type'], $imagen['name'])
        ];
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Tiendas/CreateImagenTienda?idTienda=" . $dataTienda['idTienda']);
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
            echo $httpStatusCode . 'create imagenes tienda';
        }

        curl_close($ch);
    }

//----------------------------------------------------------------------------------------//       

    //FUNCIONES
    function generateArrayCategorias($cat, $dataTienda)
    {
        return [
            "idTienda" => $dataTienda['idTienda'],
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
                    'apartadoPredeterminado' => $apartadoPredeterminado,
                    'idTienda' => $dataTienda['idTienda']
                ];
            }
        } 

        return $periodos;
    }

    function generateArrayHorario($dia, $dataTienda)
    {
        if((isset($_POST[$dia . '_apertura']) && isset($_POST[$dia . '_cierre'])))
        {
            echo $dia . '_apertura <br>';
            echo $dia . '_cierre <br>';
            echo $_POST[$dia . '_apertura'] . '<br>';
            echo $_POST[$dia . '_cierre'] . '<br>';
            echo $dataTienda['idTienda']. '<br>';
            
            if($_POST[$dia . '_apertura'] != "00:00" || $_POST[$dia . '_cierre'] != "00:00")
            {
                return [
                    "dia" => $dia,
                    "horarioApertura" => $_POST[$dia . '_apertura'],
                    "horarioCierre" =>  $_POST[$dia . '_cierre'],
                    "idTienda" => $dataTienda['idTienda']
                ];
            }
        }
        else
        {
            return [
                "dia" => $dia,
                "horarioApertura" => "00:00",
                "horarioCierre" =>  "00:00",
                "idTienda" => $dataTienda['idTienda']
            ];
        }
    }
//----------------------------------------------------------------------------------------//  

    header('Location: ' . $urlSalida);
    exit;
?>