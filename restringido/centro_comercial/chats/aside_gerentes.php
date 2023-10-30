<?php
session_start();

$responseArray = [];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://ustoreapi.azurewebsites.net/api/Chat/GetChats?typeChat=Gerente");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Authorization: Bearer ' . $_COOKIE['SessionToken']
));

$response = curl_exec($ch);

if ($response === false) {
	$responseArray = [
		"status" => "error",
		"message" => 'Error: ' . curl_error($ch)
	];
	echo json_encode($responseArray);
	exit;
} else {
	$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode !== 200) {
	$responseArray = [
		"status" => "error",
		"message" => $httpStatusCode . ": " . $response
	];
	echo json_encode($responseArray);
	exit;
}
$chatsGerente = json_decode($response, true);
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
	$responseArray = [
		"status" => "error",
		"message" => 'Error: ' . curl_error($ch)
	];
	echo json_encode($responseArray);
	exit;
} else {
	$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

if ($httpStatusCode != 200) {
	$responseArray = [
		"status" => "error",
		"message" => $httpStatusCode . ": " . $response
	];
	echo json_encode($responseArray);
	exit;
}
$gerentes = json_decode($response, true);
curl_close($ch);

$gerentesConChat = [];
$gerentesSinChat = [];

foreach ($gerentes as $gerente)
{
	$chatEncontrado = false;
	foreach ($chatsGerente as $chat)
	{
		if (($chat['idMiembro1'] == $gerente['idGerente'] && $chat['typeMiembro1'] == 'Gerente') || 
		($chat['idMiembro2'] == $gerente['idGerente'] && $chat['typeMiembro2'] == 'Gerente'))
		{
			$chatEncontrado = true;
			break;
		}
	}
	
	if(!$chatEncontrado)
	{
		$gerentesSinChat[] = $gerente;
	}
}

$responseArray = [
	'status' => 'success',	
	'gerentesConChat' => $chatsGerente,
	'gerentesSinChat' => $gerentesSinChat
];
echo json_encode($responseArray);
exit;

?>