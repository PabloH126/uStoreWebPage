<?php

require 'vendor/autoload.php';

session_start();
    $emailRecuperacion = $_POST['emailRec'];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Register/Recover");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $data = [
        'email' => $emailRecuperacion
    ];

    $jsonData = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData),
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        echo 'Error: ' . curl_error($ch);
    } else {
        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }
    
    $data = json_decode($response, true);

    curl_close($ch);

    $recuperacionLink = "https://ustoree.azurewebsites.net/Inicio_frms/envio_frms/actualizarContraA.php?token=" . $data['token'];
    
    $templateId = "d-018214066b7d401f965a271dd1dd520b";
    /*------ El nombre lo pasa la api -------*/
    /*$datos = array(
        'name' = $_SESSION['nombre'];
        token c:
    );*/
    
    if($httpStatusCode != 404)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("ustoreceo@gmail.com", "uStore");
        $email->setSubject("Recuperacion de cuenta");
        $email->addTo($emailRecuperacion);
        $email->setTemplateId($templateId);
        /*$email->addDynamicTemplateDatas($datos);*/
    
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    
        try {
            $response = $sendgrid->send($email);
            $response->statusCode() . "\n";
            $response->headers();
            $response->body() . "\n";
            
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
    
    header('Location: correoContrasena.php');

/*
if(isset($_POST['emailRec'])) {
    //Datos del remitente
    $header = "From: uStore <uStore@gmail.com>";
 
    // Destinatario y contenido del correo electrónico
    $para = $_POST['emailRec'];
    $_SESSION['correo'] = $para;
    
    $asunto = "Recuperación de cuenta";
    $contenido = "Hola,\n\nIngresa al siguiente link para recuperar tu cuenta:\n\nhttps://ustore00.000webhostapp.com/Inicio_frms/recuperacionCuenta.php";
 
    // Enviar el correo electrónico utilizando la función mail()
    mail($para, $asunto, $contenido, $header);
    header('Location: ../olvidarContra.php');
} else {
    echo "Error: No se pudieron enviar los datos del formulario";
}*/

?>
