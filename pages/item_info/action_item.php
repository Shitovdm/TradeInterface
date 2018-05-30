<?php
	/*Файл получает информацию о предмете и отправляет ее в json ответе.*/
	
include('../service/bots_API_keys.php');

$id = $_POST['tid'];
$url = "https://market.csgo.com/api/ItemInfo/".$id."/ru/?key=" . $bot_secret_key[15];
$inv = curl_init($url);
curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($inv, CURLOPT_HEADER, false);
curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
curl_setopt($inv, CURLOPT_TIMEOUT, 5);
$output_curl = curl_exec($inv);
curl_close($inv);	
	
if(($content = curl_exec($ch)) !== false) {
	$json_decode_data = json_decode($output_curl);
	$market_name = $json_decode_data->market_name;
	$rarity = $json_decode_data->rarity;
	$quality = $json_decode_data->quality;
	$type = $json_decode_data->type;
	$slot = $json_decode_data->slot;
	
	$description = json_decode($output_curl)->description;
	$desc = $description[2]->value;
	$collection = $description[4]->value;	
	
}else{
	$responce->market_hash_name = "Error loading data!";
}	

$response = array(
	'marketName' => $market_name,
	'type' => $type,
	'slot' => $slot,
	'quality' => $quality,
	'rarity' => $rarity,
	'collection' => $collection,
	'description' => $desc
);
echo json_encode($response);
?>