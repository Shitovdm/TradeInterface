<?php
function set_request($url){
	$req = curl_init($url);
	curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($req, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($req, CURLOPT_HEADER, false);
	curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
	$output_curl_request = curl_exec($req);
	curl_close($req);
	return $output_curl_request;
}

$classid_instanceid = $_POST['tclassid_instanceid'];
$market_hash_name = $_POST['tmarket_hash_name'];
$price_tm = $_POST['t_buy_price'];
$price_steam_real = $_POST['t_sell_price'];

$TmToSteam = ((($price_steam_real / 1.15 )*100)/($price_tm))-100;
$TmToSteam = number_format($TmToSteam, 2, '.', '');


require_once("../../service/dbconnect.php");
include('../../login_data.php');

$buy_request = set_request("https://market.csgo.com/api/Buy/". $classid_instanceid . "/" . ($price_tm * 100) . "/?key=" . $secret_key);

if((json_decode($buy_request)->result) != "ok"){
	$buy_request = "Error. " . (json_decode($buy_request)->result);
	$status[$i] = "Error";
}else{
	$status[$i] = "Skipped";
}
$status[$i] = "Bought";

//	Заносим предмет в базу данных, чтобы отслеживать выведенные предметы, не обращаясь к стиму.
//	Тем самым уменьшим количество запросов к серверу стима.
$timestamp = date("Y-m-d H:i:s");
$query = "INSERT 
		  INTO bought_items 
		  (market_hash_name, sell_price, buy_price, classid_instanceid, user_steamid, timestamp) 
		  VALUES 	
		  ('$market_hash_name', '$price_tm' , '$price_steam_real', '$classid_instanceid' , '$steamid' , '$timestamp')";
$result = mysql_query($query);

//--------------------------------------------------------------------------------------------------
$buy_responce_log = "<p>[" . date("d.m.Y H:i:s") . "]" . " Bought Item: " . $market_hash_name . " By price: " . $price_tm . " With profit: " . $TmToSteam . " Server responce:" . $buy_request . "</p>";

echo(json_encode($buy_responce_log));	
?>