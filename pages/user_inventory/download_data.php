<?php
/*
*	Скрипт загружзает инвентарь позьзователя, возвращая его обычной строкой html кода.
*/

//$steamID = $_POST['tsteamID'];
$steamID = "***********";

$url = "https://steamcommunity.com/profiles/".$steamID."/inventory/json/730/2/";
$inv = curl_init($url);
curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($inv, CURLOPT_HEADER, false);
curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
$output_curl = curl_exec($inv);
curl_close($inv);	
	
$data = json_decode($output_curl)->rgDescriptions;
$k = 0;
foreach($data as $element ){
	$classid_instanceid[$k] = $element->classid . '_' . $element->instanceid;
	$market_hash_name[$k] = $element->market_hash_name;
	$k++;
}
//	Формируем ответ.
$response = '';
if(count($classid_instanceid) != 0){
	for($i=0;$i<count($classid_instanceid);$i++){
		$response = $response . '<div class="user_inventory_item">';
		$response = $response . '<img src="https://cdn.csgo.com/item_'.$classid_instanceid[$i].'.png" width="100px">';
		$response = $response . '<b>' . $market_hash_name[$i] . '</b>';
		$response = $response . '</div>';
	}
}
if($response == ''){
	$response = '<b>The inventory is empty or an error occurred while retrieving the data. Try later.</b>';
}
echo json_encode($response);
?>
