<?php

require 'vendor/autoload.php';

session_start();

if(isset($_SESSION['emailRec'])){
    $emailRecuperacion = $_SESSION['emailRec'];

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
// --------------------TEMPORAL------------------
header('Location: ../recuperacionCuenta.php');
?>
