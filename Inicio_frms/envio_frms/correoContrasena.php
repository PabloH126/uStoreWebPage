<?php

require 'vendor/autoload.php';

session_start();

if(isset($_SESSION['emailRec'])){
    $emailRecuperacion = $_SESSION['emailRec'];

    $templateId = "d-018214066b7d401f965a271dd1dd520b";
    /*------ El nombre lo pasa la api -------*/
    /*$datos = array(
        'name' = $_SESSION['nombreA'];
        token c:
    );*/

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("ustoreceo@gmail.com", "uStore");
    $email->setSubject("Recuperacion de cuenta");
    $email->addTo($emailRecuperacion/*, $_SESSION['nombreA']*/);
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

    header('Location: correoContrasena.php');
} else{
    echo("No jalo :c");
}

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
