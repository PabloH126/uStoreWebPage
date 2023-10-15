<?php

session_start();

if (isset($_POST['emailAL']) && isset($_POST['passAL'])) {
    $email = $_POST['emailAL'];
    $pass = $_POST['passAL'];
    if(isset($_POST['rememberA']))
    {
        $Remember = true;
    }
    else
    {
        $Remember = false;
    }
    $passEncryptIngres = md5(md5($pass));

    $ch = curl_init();

    // Configura la URL de la API
    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Login/AdminAuthenticate");
    // Configura el cURL para indicar una solicitud POST
    curl_setopt($ch, CURLOPT_POST, 1);
    // Configura cURL para devolver el resultado en lugar de imprimirlo
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Configura los datos que se enviarán en el cuerpo de la solicitud
    $data = [
        'Email' => $email,
        'Password' => $passEncryptIngres,
        'Remember' => $Remember
    ];

    $jsonData = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    // Configura las cabeceras de la solicitud para indicar que estamos enviando JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData),
    ]);

    // Realiza la solicitud
    $response = curl_exec($ch);
    if ($response === false) {
        // La solicitud falló
        echo 'Error: ' . curl_error($ch);
    } else {
        // La solicitud fue exitosa, obtenemos el código de estado HTTP
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    $data = json_decode($response, true);

    // Cierra el manejador de cURL
    curl_close($ch);

    if ($httpStatusCode == 200) {
        if ($data !== null) {
            if($Remember == 1)
            {
                $ExpiryTime = time() + (60 * 60 * 24 * 7);
            }
            else
            {
                $ExpiryTime = time() + (60 * 60 * 3);
            }
            
            setcookie('SessionToken', $data['token'], $ExpiryTime, '/');

            if($data['idTienda'])
            {
                $idTienda = $data['idTienda'];
            }

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Login/getClaims");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $_COOKIE['SessionToken']
            )
            );

            $responseClaims = curl_exec($ch);

            if ($responseClaims === false) 
            {
                echo 'Error: ' . curl_error($ch);
            }
            else {
                // La solicitud fue exitosa, obtenemos el código de estado HTTP
                $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            }

            $data = json_decode($response, true);
            
            if($data == null)
            {
                echo $httpStatusCode;
            }
            curl_close($ch);

            $_SESSION['nombre'] = $data['nombre'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['id'] = $data['id'];
            $_SESSION['UserType'] = $data['type'];
            echo $_SESSION['UserType'];
            // redirigir al usuario a la página de inicio
            exit;
            if($_SESSION['UserType'] == "Administrador")
            {
                header("location: ../../restringido/seleccionPlaza.php");
            }
            else
            {
                header('location: https://ustoree.azurewebsites.net/restringido/centro_comercial/tiendas/perfil_tienda.php?id=' . $idTienda);
            }
            exit;
        } else {
            echo "Error al decodificar JSON";
        }
    } else {
        $_SESSION['fallo'] = 1;
        header("location: ../../index.php");
        exit;
    }
}

?>