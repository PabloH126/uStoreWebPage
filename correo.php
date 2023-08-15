<?php
require 'vendor/autoload.php';

session_start();
if (isset($_SESSION['claveE'])) {
    // Información del correo electrónico del administrador
    $email_administrador = $_SESSION['emailA'];
    $templateId = "d-4d1b3a15ba034f30a0132dfa9f983906";

    $datos = array(
        'name' => $_SESSION['nombreA'],
        'clave' => $_SESSION['claveE']
    );

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("ustoreceo@gmail.com", "uStore");
    $email->setSubject("Confirmación de cuenta - Código de verificación");
    $email->addTo($email_administrador, $_SESSION['nombreA']);
    $email->setTemplateId($templateId);
    $email->addDynamicTemplateDatas($datos);

    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

    try {
        $response = $sendgrid->send($email);
        $response->statusCode() . "\n";
        $response->headers();
        $response->body() . "\n";

    } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
    }

    header('Location: Inicio_frms/claveAdmins.php');
} else {
    //Asignación de variables de datos
    $_SESSION['nombreA'] = $_POST['nombreA'];
    $_SESSION['apellidoA'] = $_POST['apellidoA'];
    $_SESSION['emailA'] = $_POST['emailA'];

    //Si las contraseñas tienen menos de 8 caracteres, redirige al index
    if(isset($_POST['passA']) && isset($_POST['repassA']) && ((strlen($_POST['passA']) < 8) or (strlen($_POST['repassA']) < 8)))
    {
        $_SESSION['PassNV'] == true;
        header("Location: index.php");
    }
    //confirmar que las contraseñas son iguales
    else if ($_POST['passA'] == $_POST['repassA']) {

        $contrasena = $_POST['passA'];
        $contra = md5(md5($contrasena));
        $_SESSION['passA'] = $contra;

        //Datos del remitente
        $header = "From: uStore <uStore@gmail.com>";

        // Generar una clave aleatoria
        $clave = substr(md5(mt_rand()), 0, 8);
        $clave_mayus = strtoupper($clave);
        $_SESSION['claveE'] = $clave_mayus;

        // Información del correo electrónico del administrador
        $email_administrador = $_POST['emailA'];
        $asunto = "Clave de registro";
        $templateId = "d-4d1b3a15ba034f30a0132dfa9f983906";

        $datos = array(
            'name' => $_POST['nombreA'],
            'clave' => $_SESSION['claveE']
        );

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("ustoreceo@gmail.com", "uStore");
        $email->setSubject("Confirmación de cuenta - Código de verificación");
        $email->addTo($email_administrador, $_POST['nombreA']);
        $email->setTemplateId($templateId);
        $email->addDynamicTemplateDatas($datos);

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

        try {
            $response = $sendgrid->send($email);
            $response->statusCode() . "\n";
            $response->headers();
            $response->body() . "\n";

        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }

        header('Location: Inicio_frms/claveAdmins.php');
    } else {
        echo "Error. las contraseñas no coninciden.";
    }
}

?>