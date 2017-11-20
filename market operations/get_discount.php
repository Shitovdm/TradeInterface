<?php
/*	
*	Скрипт получает процент скидки при покупке и продаже предметов на маркете.
*/

include_once("../file_name.php"); // file with $secret_key;

$url = "https://market.csgo.com/api/GetDiscounts/?key=" . $secret_key;
$inv = curl_init($url);
curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($inv, CURLOPT_HEADER, false);
curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
curl_setopt($inv, CURLOPT_CONNECTTIMEOUT, 3);
$output_curl = curl_exec($inv);
curl_close($inv);	

$decode = json_decode($output_curl);
$data = $decode->discounts;

$array = array(
	"buy_discount" => $data->buy_discount,
	"sell_fee" => $data->sell_fee
);

echo(json_encode($array));
?>