<?php
session_start();

if(isset($_POST['passA']) && isset($_POST['repassA']) && ((strlen($_POST['passA']) < 8) or (strlen($_POST['repassA']) < 8)))
{
	$_SESSION['ContraNV'] = True;
	header("Location: recuperacionCuenta.php?token=" . $_GET['token']);
}
else
{
	if(isset($_POST['passA']) && isset($_POST['repassA'])){

		if($_POST['passA'] == $_POST['repassA']){
			$passA = $_POST['passA'];
			
			$passEncryptIngres = md5(md5($passA));
	
			$ch = curl_init();
	
			// Configura la URL de la API
			curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Users/UpdatePass");
			// Configura el cURL para indicar una solicitud POST
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
			// Configura cURL para devolver el resultado en lugar de imprimirlo
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
			// Configura los datos que se enviarán en el cuerpo de la solicitud
			$data = [
				[
					"path" => "/password",
					"op" => "replace",
					"value" => $passEncryptIngres
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
	
			// Cierra el manejador de cURL
			curl_close($ch);
	
			if($httpStatusCode == 401)
			{
				$_SESSION['TokenExpirado'] = True;
				header("Location: recuperacionCuenta.php?token=" . $_GET['token']);
			}
			else if ($httpStatusCode != 204)
			{
				$_SESSION['error'] = False;
				echo ''. $httpStatusCode .'';
			}
			else
			{
				header("Location: confirmacion_contra_user.php");
			}
		}else{
			$_SESSION['ContrasenasDif'] = True;
			header("Location: recuperacionCuenta.php?token=" . $_GET['token']);
		}
	
	}else {
	   echo "Error: No se pudieron enviar los datos del formulario";
	}

}

?>