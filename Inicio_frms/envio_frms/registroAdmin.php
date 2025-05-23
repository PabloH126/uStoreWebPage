<?php 

session_start();

$responseArray = [];

if(isset($_POST['claveA'])){

	$nombreA = $_SESSION['nombreA'];
	$apellidoA = $_SESSION['apellidoA'];
	$email = $_SESSION['emailA'];
	$contra = $_SESSION['passA'];
    
	//Verificar si el codigo es valido
	$codigo_valido = validar_codigo($_POST['claveA']);

	if($codigo_valido) {
        
        //Se quita del session la clave enviada
        unset($_SESSION['claveE']);
        // El código es válido, guardar los datos en la base de datos
        $ch = curl_init();

        // Configura la URL de la API
        curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Register/RegisterAdmin");

        // Configura cURL para enviar una solicitud POST
        curl_setopt($ch, CURLOPT_POST, 1);

        // Configura cURL para devolver el resultado en lugar de imprimirlo
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // Configura los datos que se enviarán en el cuerpo de la solicitud
        $data = [
            'Password' => $contra,
            'Email' => $email,
            'PrimerNombre' => $nombreA,
            'PrimerApellido' => $apellidoA
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
        if($response === false)
        {
            echo 'Error: ' . curl_error($ch);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        }
        // Cierra el manejador de cURL
        curl_close($ch);

        if($httpStatusCode == 201)
        {
            $responseArray['status'] = 'success';

        }
        else
        {
            $responseArray['status'] = $response;
        }
        echo json_encode($responseArray);
        exit;
	} else {
	    // El código no es válido
        //Marcar fallo como verdadero
        $responseArray['status'] = 'errorClave';
        echo json_encode($responseArray);
        exit;
	}
} 
else {
	echo "Error: No se pudieron guardar los datos del formulario";
}

function validar_codigo($codigo_ingresado){
	//Comprobamos si el codigo es igual al enviado por correo
	$clave_enviada = $_SESSION['claveE'];
	return($codigo_ingresado == $clave_enviada);
}

?>