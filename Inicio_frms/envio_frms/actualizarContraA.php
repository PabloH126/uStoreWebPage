<?php
session_start();

if(isset($_POST['passA']) && isset($_POST['repassA'])){

	if($_POST['passA'] == $_POST['repassA']){
    	$passA = $_POST['passA'];
		
    	$passEncryptIngres = md5(md5($passA));

		$ch = curl_init();

		// Configura la URL de la API
		curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/AdminsTienda/UpdatePass");
		// Configura el cURL para indicar una solicitud POST
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
		// Configura cURL para devolver el resultado en lugar de imprimirlo
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// Configura los datos que se enviarán en el cuerpo de la solicitud
		$data = [
			'patchDoc' => [
				[
					"path" => "/password",
					"op" => "replace",
					"value" => $passEncryptIngres
				]
			]
		];

		$jsonData = json_encode($data);
		// Configura las cabeceras de la solicitud para indicar que estamos enviando JSON
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Authorization: Bearer ' . $_GET['token'],
			'Content-Type: application/json',
			'Content-Length: ' . strlen($jsonData),
		));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

		// Realiza la solicitud
		$response = curl_exec($ch);

		if ($response === false) {
			// La solicitud falló
			echo 'Error: ' . curl_error($ch);
		} else {
			// La solicitud fue exitosa, obtenemos el código de estado HTTP
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		}

		echo "Codigo de respuesta: " . $httpStatusCode . "\n" . $response;

		// Cierra el manejador de cURL
		curl_close($ch);


    	
    }else{
    	echo "Error. las contraseñas no coninciden.";
    }

}else {
   echo "Error: No se pudieron enviar los datos del formulario";
}

/*
if(isset($_POST['passA']) && isset($_POST['repassA'])){

	if($_POST['passA'] == $_POST['repassA']){
    	$passA = $_POST['passA'];
		
    	$contra = md5(md5($contrasena));

    	$email = $_SESSION['correo'];

    	$conexion = mysqli_connect("localhost","root", "") or die ("No se puede conectar al servidor de uStore");

		$db = mysqli_select_db($conexion, "ustore") or die ("No se puede conectar con uStore");

		$resultado = mysqli_query($conexion, $consulta) or die("No se puede hacer la consulta");

		mysqli_close($conexion);
    }else{
    	echo "Error. las contraseñas no coninciden.";
    }

}else {
   echo "Error: No se pudieron enviar los datos del formulario";
}*/
?>