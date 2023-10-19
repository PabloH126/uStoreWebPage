<?php
session_start();
require '../../security.php';
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Chat/GetChats?typeChat=Gerentes");
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
	$chats = json_decode($response, true);
	curl_close($ch);

	//GET GERENTES ADMINISTRADOR

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Gerentes/Gerentes");
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt(
		$ch,
		CURLOPT_HTTPHEADER,
		array(
			'Authorization: Bearer ' . $_COOKIE['SessionToken']
		)
	);

	$response = curl_exec($ch);

	if ($response === false) {
		echo 'Error: ' . curl_error($ch);
	} else {
		$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	}

	if ($httpStatusCode == 400) {
		$tiendasError = "Error al intentar recuperar las tiendas. Codigo de respuesta: " . $httpStatusCode;
	}
	$gerentes = json_decode($response, true);
	curl_close($ch);

	$gerentesConChat = [];
	$gerentesSinChat = [];

	foreach ($gerentes as $gerente)
	{
		$chatEncontrado = false;
		foreach ($chats as $chat)
		{
			if (($chat['idMiembro1'] == $gerente['idGerente'] && $chat['typeMiembro1'] == 'Gerente') || 
			($chat['idMiembro2'] == $gerente['idGerente'] && $chat['typeMiembro2'] == 'Gerente'))
			{
				$chatEncontrado = true;
				$gerentesConChat[] = [
					'gerente' => $gerente,
					'chat' => $chat
				];
				break;
			}
		}
		
		if(!$chatEncontrado)
		{
			$gerentesSinChat[] = $gerente;
		}
	}
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
				<!--
				<div class="received-msg">
					<div class="received-msg-inbox">
						<p class="recived-box-msg">Hi !! This is message from Riya . Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non quas nemo eum, earum sunt, nobis similique quisquam eveniet pariatur commodi modi voluptatibus iusto omnis harum illumiste distinctio expedita illo!</p>
						<span class="time">18:06 PM | July 24 </span>
					</div>
				</div>

				<div class="outgoing-msg">
					<div class="outgoing-chats-msg">
						<p class="outgoing-box-msg">Hi riya , Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo nobis deleniti earum magni recusandae assumenda.</p>
						<p class="outgoing-box-msg">Lorem ipsum dolor sit amet consectetur.</p>
						<span class="time">18:30 PM | July 24 </span>
					</div>
				</div>

				<div class="received-msg">
					<div class="received-msg-inbox">
						<div class="recived-box-msg">
							<img src="https://hips.hearstapps.com/hmg-prod/images/fotos-1533279584.jpg" alt="">
							
						</div>
						<span class="time">18:06 PM | July 24 </span>
					</div>
				</div>

				<div class="outgoing-msg">
					<div class="outgoing-chats-msg">
						<div class="outgoing-box-msg">
							<img src="https://www.blogdelfotografo.com/wp-content/uploads/2022/01/girasol-foto-perfil.webp" alt="">
						</div>
						<span class="time">18:30 PM | July 24 </span>
					</div>
				</div>
				-->
			</div>
			<div class="text-area">
				<form action="">
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
	<?php $idUser = $_SESSION['idUser']; ?>
	<script>
		const idUser = "<?php echo $idUser ?>";
		console.log("IdUser en php: ", idUser);
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/microsoft-signalr/5.0.10/signalr.min.js"></script>
	<script src="js/aside_chats.js"></script>
	<script src="js/chat.js"></script>
</body>

</html>