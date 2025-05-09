<?php
session_start();
require '../../security.php';
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Chat/GetChats?typeChat=Usuario");
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Authorization: Bearer ' . $_COOKIE['SessionToken']
	));
	
	$response = curl_exec($ch);
	
	if ($response === false) {
		echo 'Error: ' . curl_error($ch);
	} else {
		$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	}
	
	if ($httpStatusCode == 400) {
		$chatsError = "Error al intentar recuperar las tiendas. Codigo de respuesta: " . $httpStatusCode;
	}
	$chatsUsuario = json_decode($response, true);
	curl_close($ch);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Chats</title>
	<?php require("../templates/template.styles.php") ?>
	<?php require("templates/template.secc_chats.php") ?>
</head>

<body>
	<?php require("../templates/template.menu.php") ?>

	<div class="content">
        <?php require("templates/template.aside_chats.php") ?>
		<div class="chat-area">
			<div class="mssg-area">
				<div>
					<span id="span-seleccion-tienda">Seleccione un chat</span>
				</div>
			</div>
	
			<div class="text-area">
				<form id="form_chats">
					<div>
						<label for="add_file"><i class='bx bx-plus-circle'></i></label>
						<input type="file" id="add_file">
					</div>
					
					<div>
						<div id="contentTextarea">
							<textarea id="expanding_textarea"></textarea>
						</div>
					</div>

					<div>
						<label for="submit_message"><i class='bx bx-send bx-flip-vertical'></i></label>
						<button id="submit_message"></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/microsoft-signalr/5.0.10/signalr.min.js"></script>
	<script src="js/aside_chats.js"></script>
	<script src="js/chat.js"></script>
</body>

</html>