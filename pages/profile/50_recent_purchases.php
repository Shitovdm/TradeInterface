<?php
require_once("../login_data.php");
$url = "https://market.csgo.com/api/OperationHistory/[start_time]/[end_time]/?key=". $secret_key;
	$inv = curl_init($url);
	curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($inv, CURLOPT_HEADER, false);
	curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($inv, CURLOPT_TIMEOUT, 5);
	$output_curl = curl_exec($inv);
	curl_close($inv);
	
	$json_decode_data = json_decode($output_curl);
	$money = $json_decode_data->money;

$responce = "";
echo json_encode($responce);

?>