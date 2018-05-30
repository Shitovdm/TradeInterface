<?php
include('../../service/bots_API_keys.php');
$classid_instanceid = $_POST['tclassid_instanceid'];
$market_hash_name = $_POST['tmarket_hash_name'];
//	TM prices:
//	Минимальная цена ТМ.
$classid_instanceid = str_replace("-", "_", $classid_instanceid);	
$url = "https://market.csgo.com/api/ItemInfo/" . $classid_instanceid . "/en/?key=" . $bot_secret_key[2];
$inv = curl_init($url);
curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($inv, CURLOPT_HEADER, false);
curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
$out = curl_exec($inv);
curl_close($inv);
$data = json_decode($out);
$min_price_TM = $data->min_price/100;
$market_hash_name = $data->market_hash_name;

//	Максимальный ордер ТМ.

$url = "https://market.csgo.com/api/ItemInfo/" . $classid_instanceid . "/ru/?key=" . $bot_secret_key[3];
$inv = curl_init($url);
curl_setopt($inv, CURLOPT_HEADER, false);
curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
$output_curl = curl_exec($inv);
curl_close($inv);
$responce = json_decode($output_curl);
$tmp = $responce->buy_offers;
$o_price = ($tmp[0]->o_price)/100;

//	Получение item_nameid для получения цены в Стиме.

$item_weapon = substr($market_hash_name, 0, strpos($market_hash_name, "|")-1-strlen($market_hash_name));
$item_name = substr(substr($market_hash_name,0,strpos($market_hash_name,"(")-1), strpos(substr($market_hash_name,0,strpos($market_hash_name,"(")), "|")+2); 
$item_quality = substr(substr($market_hash_name, strpos($market_hash_name, "(")+1), 0, -1);

$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$item_weapon' AND name='$item_name' AND quality='$item_quality'";
require_once("../../service/dbconnect.php");
$select_data = mysql_query($query);
while ($row = mysql_fetch_assoc($select_data)) {	
	$item_nameid = $row['item_nameid'];
}

//	Steam prices:

$url = "http://steamcommunity.com/market/itemordershistogram?country=RU&language=russian&currency=5&item_nameid=" . $item_nameid . "&two_factor=0";
$inv = curl_init($url);
curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($inv, CURLOPT_HEADER, false);
curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
$output_curl = curl_exec($inv);
curl_close($inv);
$result = json_decode($output_curl);
$highest_buy_order = $result->highest_buy_order/100;
$lowest_sell_order = $result->lowest_sell_order/100;
	

$responce = array(
	"Steam_real" => $lowest_sell_order,
	"ST_to_ST_real" => "Unknown",
	"ST_to_ST_order" => "Unknown",
	"Steam_order" => $highest_buy_order,
	"TM_real" => $min_price_TM,
	"TM_order" => $o_price,
	"ST_to_TM_real" => "Unknown",
	"ST_to_TM_order" => "Unknown",
	"item_weapon" => $item_weapon,
	"item_name" => $item_name,
	"item_quality" => $item_quality,
	"item_nameid" => $item_nameid
);

echo(json_encode($responce));

?>