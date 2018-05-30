<?php
/*
*	Код отвечет за принятие предложения обмена в СТИМЕ. Он автоматически принимает обмен.
*	Для работы необходима авторизация и параметры трейда, такие как ID партнера и ID трейд обмена.
*/
session_start();

$sessionId = $_SESSION['sessionId'];
$cookies = $_SESSION['cookies'];
$tradeofferid = $_POST['ttradeofferId'];
$partner = $_POST['tpartner'];
$status = $_POST['tstatus'];

$status_resp = false;
if($status == "true"){
	$url = 'https://steamcommunity.com/tradeoffer/' . $tradeofferid . '/accept';
	$data = array(
		'sessionid' => $sessionId,
		'serverid' => '1',
		'partner' => $partner,
		'tradeofferid' => $tradeofferid,
		'captcha' => ''
	);
	for($counter = 0; $counter < 10; $counter++){
		$c = curl_init();
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_NOBODY, false);
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)");
		curl_setopt($c, CURLOPT_COOKIE, $cookies);
		curl_setopt($c, CURLOPT_POST, 1);
		curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_HTTPHEADER, array('Referer: https://steamcommunity.com/tradeoffer/' . $tradeofferid));
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($c, CURLOPT_CUSTOMREQUEST, strtoupper('POST'));
		$output_curl = curl_exec($c);
		curl_close($c);	
		$json = json_decode($output_curl);
		
		if( ($json->tradeid) != 0 ){
			$response = "Item received successfully. " . $output_curl;
			$status_resp = true;
			break;
		}
		$response = "When making this offer of exchange error. Please try again later. Step : " . $counter;
		$status_resp = false;
	}
	//Пример успешного выполнения: {"tradeid":"1006954383652832774"}
}else{
	$response = "Trade offer was not sent.";
}
		


$confirmation_log = ("[" . date("d.m.Y H:i:s") . "] " . $response);//Ответ о состоянии принятия в STEAM.

$JSON_responce = array(
	'confirmation_log' => $confirmation_log
);
	
echo json_encode($JSON_responce);

?>