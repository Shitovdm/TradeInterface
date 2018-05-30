<?php

$steamID = $_POST['tsteamID'];

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
	$items[$k]['classid_instanceid'] = $element->classid . '-' . $element->instanceid;
	$classid_instanceid = $items[$k]['classid_instanceid'];
	$market_hash_name = $element->market_hash_name;;
	// if image empty.
	if($element->icon_url_large == "" || $element->icon_url_large == NULL){
		$items[$k]['Image:'] = "<img src='images/icons/no_photo.png' width='150px;'>";	
	}else{
		$items[$k]['Image:'] = "<div><a href='https://market.csgo.com/item/" . $classid_instanceid . "-" . $market_hash_name . "' target='_blank'>TM</a></div><div><a href='http://steamcommunity.com/market/listings/730/" . $market_hash_name . "' target='_blank'>STEAM</a></div><img src='http://community.edgecast.steamstatic.com/economy/image/" . $element->icon_url_large . "/360fx360f' width='150px;'>";	
	}
	$items[$k]['Name:'] = substr($element->market_hash_name,0,strpos($element->market_hash_name,"("));
	$items[$k]['Quality:'] = substr($element->market_hash_name, strpos($element->market_hash_name, "("));
	$items[$k]['Price of bought:'] = "<input type='text' placeholder='00.00' onChange='calculate(this.value,\"" . $classid_instanceid . "\")' id='price_of_bought_" . $classid_instanceid . "' style='text-align:center;height:20px;'>";
	$items[$k]['Steam real:'] = "NaN";
	$items[$k]['ST⇒ST real:'] = "Unknown";
	$items[$k]['ST⇒ST order:'] = "Unknown";
	$items[$k]['Steam order:'] = "NaN";
	$items[$k]['TM real:'] = "NaN";
	$items[$k]['TM order:'] = "NaN";
	$items[$k]['ST⇒TM real:'] = "Unknown";
	$items[$k]['ST⇒TM order:'] = "Unknown";
	$items[$k]['Sell in Tm:'] = "<input type='button' style='width:50%;float:left;' value='Order price' onClick='sell_in_TM()'><input type='button' style='width:50%;float:right;' value='Real price' onClick='sell_in_TM(\"" . $classid_instanceid . "\")'>";
	$items[$k]['Refresh:'] = "<input type='button' style='width:100%;' value='Refresh' onClick='refresh_prices(\"" . $classid_instanceid . "\",\"" . $market_hash_name . "\")'>";

	$items[$k]['tradable'] = $element->tradable;
	$items[$k]['type'] = $element->type;
	$k++;
}

$param = array(
	'0' => "Image:",
	'1' => "Name:",
	'2' => "Quality:",
	'3' => "Price of bought:",
	'4' => "Steam real:",
	'5' => "ST⇒ST real:",
	'6' => "ST⇒ST order:",
	'7' => "Steam order:",
	'8' => "TM real:",
	'9' => "TM order:",
	'10' => "ST⇒TM real:",
	'11' => "ST⇒TM order:",
	'12' => "Sell in Tm:",
	'13' => "Refresh:"
);

//	Формируем ответ.\\
$response = '';
if(count($items) != 0){
	for ($j=0; $j < count($param); $j++){//	By param. 
		$response .= "<tr>";
		$response .= "<th class='steamToTM_sell_cell_th'>" . $param[$j] . "</th>";
		for($i=count($items)-1;$i>=0;$i--){//	By item.
			if($items[$i]['type'] != "Extraordinary Collectible"){
				$response .= "<td id='" . $param[$j] . "_" . $items[$i]['classid_instanceid'] . "'";
				if($items[$i]['tradable'] == "0"){ // No tradable item.
					$response .= " style='opacity:0.2;'";
				}
				$response .= " class='steamToTM_sell_cell'>" . $items[$i][$param[$j]] . "</td>";
				
			}
		}
		$response .= "</tr>";
	}
	
}
if($response == ''){
	$response = '<b>The inventory is empty or an error occurred while retrieving the data. Try later.</b>';
	$response .= $output_curl;
}

echo json_encode($response);
//echo json_encode($output_curl);
?>