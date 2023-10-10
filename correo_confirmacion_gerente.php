<?php
session_start();
require 'vendor/autoload.php';
header('Content-Type: application/json');

$responseArray = [];

if (isset($_SESSION['claveConfirm'])) {
    // Información del correo electrónico del gerente
    $email_gerente = $_SESSION['email'];
    $templateId = "d-4d1b3a15ba034f30a0132dfa9f983906";

    $datos = array(
        'name' => $_SESSION['nombre'],
        'clave' => $_SESSION['claveConfirm']
    );

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("ustoreceo@gmail.com", "uStore");
    $email->setSubject("Confirmación de cuenta - Código de verificación");
    $email->addTo($email_gerente, $_SESSION['nombre']);
    $email->setTemplateId($templateId);
    $email->addDynamicTemplateDatas($datos);

    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

    try {
        $response = $sendgrid->send($email);
        $response->statusCode() . "\n";
        $response->headers();
        $response->body() . "\n";
        exit;

    } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
        exit;
    }
} 
else 
{
    //Asignación de variables de datos
    $_SESSION['nombre'] = $_POST['nombre'];
    $_SESSION['email'] = $_POST['email'];

    //Datos del remitente
    $header = "From: uStore <uStore@gmail.com>";

    // Generar una clave aleatoria
    $clave = substr(md5(mt_rand()), 0, 8);
    $clave_mayus = strtoupper($clave);
    $_SESSION['claveConfirm'] = $clave_mayus;

    // Información del correo electrónico del administrador
    $email_administrador = $_POST['email'];
    $asunto = "Clave de registro";
    $templateId = "d-4d1b3a15ba034f30a0132dfa9f983906";

    $datos = array(
        'name' => $_POST['nombre'],
        'clave' => $_SESSION['claveConfirm']
    );

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("ustoreceo@gmail.com", "uStore");
    $email->setSubject("Confirmación de cuenta - Código de verificación");
    $email->addTo($email_administrador, $_POST['nombre']);
    $email->setTemplateId($templateId);
    $email->addDynamicTemplateDatas($datos);

    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

    try {
        $response = $sendgrid->send($email);
        $response->statusCode() . "\n";
        $response->headers();
        $response->body() . "\n";

        $responseArray = [
            'status' => 'success',
            'message' => 'Correo enviado a ' . $_SESSION['email']
        ];
        echo json_encode($responseArray);
        exit;

    } catch (Exception $e) {
        $responseArray = [
            'status' => 'error',
            'message' => 'Caught exception: ' . $e->getMessage() . "\n"
        ];
        echo json_encode($responseArray);
        exit;
    }
}
/*
$data = [
    'password' => $_POST['password'],
    'email' => $_POST['email'],
    'primerNombre' => $_POST['primerNombre'],
    'primerApellido' => $_POST['primerApellido']
]
*/
?>