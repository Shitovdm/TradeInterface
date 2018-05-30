<?php
function getprice_tm($input_str){
$preg_item_price = preg_match_all(("/(\"min_price\":\")[0-9]{1,}/"),(string)$input_str, $item_price_array, PREG_PATTERN_ORDER);
	for ($i = 0; $i < $preg_item_price; $i++){
		$price = substr((string)$item_price_array[0][$i], 13);
	}
	return $price;
}
function getprice_tm_order($input_str){
$preg_item_price = preg_match_all(("/(\"o_price\":\")[0-9]{1,}/"),(string)$input_str, $item_price_array, PREG_PATTERN_ORDER);
	for ($i = 0; $i < $preg_item_price; $i++){
		$price = substr((string)$item_price_array[0][0], 11);
	}
	return $price;
}
function cut_priceSteam($priceSt){
	$priceSt = substr($priceSt,0,-7);
	$priceSt = str_replace(",", ".", $priceSt);
	$priceSt = number_format($priceSt, 2, '.', '');
	return $priceSt;
}
function get_proxy(){
	// Получаем новый прокси.
	$get_proxy_url = "https://api.getproxylist.com/proxy";
	$new_proxy = curl_init($get_proxy_url);
	curl_setopt($new_proxy, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($new_proxy, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($new_proxy, CURLOPT_HEADER, false);
	curl_setopt($new_proxy, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($new_proxy, CURLOPT_TIMEOUT, 3);
	$new_proxy_out = curl_exec($new_proxy);
	curl_close($new_proxy);
	$ip = json_decode($new_proxy_out)->ip;
	$port = json_decode($new_proxy_out)->port;
	$proxy = $ip . ":" . $port;
	return $proxy;
}

include('../../service/bots_API_keys.php');

$id = $_POST['tid'];
//Запрос на ТМ для получения цены.
$urlTM = "https://market.csgo.com/api/ItemInfo/". $id ."/ru/?key=" . $bot_secret_key[17];
	$ch = curl_init($urlTM);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	$curl = curl_exec($ch);
	curl_close($ch);	
$responce = json_decode($curl);
//читаем ответ и извлекаем оттуда цену и имя.
$priceTm = getprice_tm($curl) / 100;
$price_tm_order = (getprice_tm_order($curl)/100);
$market_hash_name = $responce->market_hash_name;
$name = ($market_hash_name);
$proxy = get_proxy();// Получаем новый прокси.

if($priceTm != -0.01){
	$market_hash_name = str_replace(" ", "%20", $responce->market_hash_name);
	//Запрос с стим на получение цены.
	for($i=0;$i<3;$i++){
		//$proxy = get_proxy();// Получаем новый прокси.
		$urlST = "http://steamcommunity.com/market/priceoverview/?country=RU&currency=5&appid=730&market_hash_name=" . $market_hash_name;
		$ch = curl_init($urlST);
		//curl_setopt($ch, CURLOPT_PROXY, $proxy);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 2);
		$curl = curl_exec($ch);
		curl_close($ch);	
		$responce = json_decode($curl);
		if( ($responce->lowest_price != "") && (isset($responce->lowest_price)) ){
			$attempts = $i+1;
			break;
		}
	}
}

//Читаем ответ от стима, для получения цены.
$priceSt = $responce->median_price;
$priceStreal = $responce->lowest_price;
$volume = $responce->volume;
$priceSt = cut_priceSteam($priceSt);
$priceStreal = cut_priceSteam($priceStreal);
//Формируем ответ и отправляем клиенту.
//Расчитываем цену при покупке в Steam и продаже на TM;
$SteamToTm = ((((($price_tm_order)/1.05) * 100)/($priceStreal)) - 100);
$SteamToTm = number_format($SteamToTm, 2, '.', '');
//Расчитываем цену для покупки на TM и продаже в Steam;
$TmToSteam = ((($priceStreal / 1.15 )*100)/($priceTm))-100;
$TmToSteam = number_format($TmToSteam, 2, '.', '');
//Обработчик неприятностей.
if($priceTm == (-0.01)){
	$priceTm = 'None';
	$profit_persent = 'None';
	$TmToSteam = 'None';
}
//Добавление класса подсветка выгодного процента.
if($TmToSteam >= 30){
	$TmToSteam_class = "green";	
}else{
	$TmToSteam_class = "red";
}

$buy_response_field = '<div class="update" onClick="buyItem(\'' . $id . "','" . $name . "','" . $priceTm . "','" . $priceStreal . '\')"><img class="action_icon_green" src="images/icons/buy-green.png" width="100px"></div>';

$update_log = "<p>[" . date("d.m.Y H:i:s") . "]" . " Success updated ".$name.".</p>";
$JSON_responce = array(
	'priceTm' => $priceTm,
	'priceTmOrder' => $price_tm_order,
	'priceSteamMedian' => $priceSt,
	'priceSteamReal' => $priceStreal,
	'SteamToTm' => $SteamToTm,
	'SteamToTM_class' => $SteamToTM_class,
	'TmToSteam' => $TmToSteam,
	'TmToSteam_class' => $TmToSteam_class,
	'UpdateLog' => $update_log,
	'Buy_response_field' => $buy_response_field,
	'used_proxy' => $proxy,
	'attempts' => $attempts
);
	
echo json_encode($JSON_responce);
?>