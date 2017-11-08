<?php
/*
*	Выставляем предметы по самым низким ценам.
*	Принимаем сессионные файлы и айди профиля.
*	Отвечаем результатом выполнения запроса в формате json. Все возможные ошибки Стима описаны.
*/
function cut_priceSteam($priceSt){//Функция обрезает цену и оставляет только число(уберает буквы).
	$priceSt = substr($priceSt,0,-7);
	$priceSt = str_replace(",", ".", $priceSt);
	$priceSt = number_format($priceSt, 2, '.', '');
	return $priceSt;
}
session_start();
$id = $_SESSION['steamid'];
$sessionId = $_SESSION['sessionId'];
$cookies = $_SESSION['cookies'];
$date = date("d.m.Y H:i:s");

$profile_link = "https://steamcommunity.com/profiles/" . $id . "/inventory/json/730/2/";
$req = curl_init($profile_link);
curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($req, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($req, CURLOPT_HEADER, false);
curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
$output_curl_request = curl_exec($req);
curl_close($req);
//Составляем массив айдишников, по которым и осуществляется выставление вещей.
$data = json_decode($output_curl_request)->rgInventory;
$i = 0;
foreach( $data as $element ){
	$assetid[$i] = $element->id;
	$classid[$i] = $element->classid;
	$instanceid[$i] = $element->instanceid;
	$i++;
}
//Строим массив полных имен предметов, так как только с помощью них можно получить текущую цену предмета.
$data = json_decode($output_curl_request)->rgDescriptions;
$i = 0;
foreach( $data as $element ){
	$classid_desc[$i] = $element->classid;
	$instanceid_desc[$i] = $element->instanceid;
	$market_hash_name[$i] = $element->market_hash_name;
	$tradable[$i] = $element->tradable;
	$i++;
}
$date = date("d.m.Y H:i:s");
if((count($assetid)-5) <= 0){
	//No items in inventory
	$steamsell_log = "<p>[" . $date . "] The list of items is empty or error uploading inventory.</p>";
}
//ограничиваем количество одновременно выставляемых вещей до 5 штук.
if(count($assetid) > 5){ if(count($assetid) < 10){ $iter =	count($assetid)-5; }else{ $iter = 5;} }
// Читаем список сохраненных предметов.
$exception_items = file_get_contents('../lists/remember_items.txt');
$i = 0;
while(strlen($exception_items) != 0){
	$delimiter = strpos($exception_items, ",");
	$market_hash_name_inList[$i] = substr($exception_items, 0, $delimiter);
	$exception_items = substr($exception_items, $delimiter+1);
	$i++;
}

for($j = 0; $j < $iter; $j++){
	$coincidence = false;// Флаг совпадения предмета с предметом из списка сохраненных.
	for($f = 0; $f < count($market_hash_name_inList); $f++){
		if($market_hash_name_inList[$f] == $market_hash_name[$j]){
			$coincidence = true;// найдено совпадение.
			break;
		}
	}
	if(($classid[$j] == $classid_desc[$j]) && ($instanceid[$j] == $instanceid_desc[$j]) && ($tradable[$j] != 0) && (!$coincidence) ){//сопоставляем данные из rgInventory и rgDescriptions. Проверяем трейдабельность и проверяем нет ли этого предмета в списке remember items.
		$market_hash_name_rep[$j] = str_replace(" ", "%20", $market_hash_name[$j]);	
		$url = "http://steamcommunity.com/market/priceoverview/?country=RU&currency=5&appid=730&market_hash_name=" . $market_hash_name_rep[$j];
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$output_curl = curl_exec($curl);
		curl_close($curl);
		$json_array = json_decode($output_curl);
		$price = (cut_priceSteam($json_array->lowest_price))*100;
		$price = ($price/1.15);
		//$price = (5000/1.15);
		$price = number_format($price, 0, '.', '');
		//Selling item
		$url = 'https://steamcommunity.com/market/sellitem/';
		$data = array(
			'sessionid' => $sessionId,
			'appid' => '730',
			'contextid' => '2',
			'assetid' => $assetid[$j],
			'amount' => '1',
			'price' => $price
		);
		for($a = 0; $a < 10; $a++){
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
			curl_setopt($c, CURLOPT_HTTPHEADER, array('Referer: http://steamcommunity.com/profiles/'. $id .'/inventory'));
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($c, CURLOPT_CUSTOMREQUEST, strtoupper('POST'));
			$response = curl_exec($c);
			curl_close($c);
			$res = json_decode($response);
			if(($res->success) == 1){
				break;
			}
		}
		$item_info = $market_hash_name[$j] . "; At price: " . ($price/100) . " rub. Assetid: " . $assetid[$j];
		//The error handler.
		if(($res->success) != 1){//Errors
			if($res->message == 'Лот с этим предметом уже ожидает вашего согласия на продажу. Подтвердите или отмените его.'){
				$steamsell_log .= "<p>[" . $date . "]" . " Error. Еhe object is not exposed: Lot with this subject already awaiting your approval for sale. Confirm or reject it. " . $item_info . ";</p>";		
			}else{
				if($res->message == 'Не удалось соединиться с сервером игровых предметов. Вероятно, сервер игровых предметов недоступен или в Steam происходят временные перебои соединения. Предмет не был выставлен на продажу. Обновите страницу и попробуйте еще раз.'){
					$steamsell_log .= "<p>[" . $date . "]" . " Error. The server is not available on Steam or there is a temporary interruption connection. " . $item_info . ";</p>";	
				}else{
					if($res->message == 'Ошибка при выставлении предмета на продажу. Обновите страницу и повторите попытку.'){
						$steamsell_log .= "<p>[" . $date . "]" . " Error. Error while setting the object for sale. Refresh the page and try again. " . $item_info . ";</p>";		
					}else{
						if($res->message == 'Предмет больше не находится в вашем инвентаре, либо его нельзя обменивать на Торговой площадке сообщества.'){
							$steamsell_log .= "<p>[" . $date . "]" . " Error. The subject is no longer in your inventory, or it can not be exchanged for the Marketplace community. " . $item_info . ";</p>";
						}else{
							//Other error
							$steamsell_log .= "<p>[" . $date . "]" . " Error. The object is not exposed: " . $item_info . "; Server response: success: " . $response . "</p>";
						}
					}	
				}
			}
		}else{
			// OK
			$steamsell_log .= "<p>[" . $date . "]" . " Item is exposed: " . $item_info . "; Server response: success: True;</p>";
		}	
	}else{
		// Error
		$steamsell_log .= "<p>[" . $date . "]" . " Item : " . $market_hash_name[$j] . "; Server response: Sale of the item is prohibited by the '<a href='#' target='_blank'>Stored items</a>' list.</p>";
	}
}

$JSON_responce = array(
	'steamsell_log' => $steamsell_log,
	'coincidence' => $coincidence
);	

echo json_encode($JSON_responce);
?>
