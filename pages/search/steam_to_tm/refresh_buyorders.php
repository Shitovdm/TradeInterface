<?php
/*
*	Скрипт обновляет все ордера на покупку в стиме.
*	Для начала идет проверка цен в стиме и тм на выгодность, если вещь еще выгодна то она выставляется повторно. Если нет то удаляется.
*	Идет проверка очереди в стиме.
*/
//	Функция получения данных о предметах, на которые были выставленны запросы.
function get_order_data_from_Steam($output_curl){
	// Вытаскиваем из кода страницы данные.
	// Вытаскиваем номер ордера.
	$orderNumbers = 0;
	$preg_item_CLASS_INSTANCE = preg_match_all(("/(mbuyorder_)[0-9]{2,}/"),(string)$output_curl, $item_CLASS_INSTANCE);
	for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
		//$classid_instanceid[$i]=substr(substr($item_CLASS_INSTANCE[0][$i],0,-1),11);
		$items[$i]['order_number'] = substr($item_CLASS_INSTANCE[0][$i],10);
		$orderNumbers++;
	}
	
	// Вытаскиваем название предмета.
	$namesAmount = 0;
	$preg_item_CLASS_INSTANCE = preg_match_all(("/(<a class=\"market_listing_item_name_link\" href=\")[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхчшщъыьэюя弐0-9a-zA-Z:\/.%->|\"\s]{2,}/"),(string)$output_curl, $item_CLASS_INSTANCE);
	for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
		$tmp[$i]=$item_CLASS_INSTANCE[0][$i];
		$preg_tmp = preg_match_all(("/(\>)[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхчшщъыьэюя弐0-9a-zA-Z:\/.%-|\"\s]{2,}/"),(string)$tmp[$i], $preg_order_name);
		for ($j = 0; $j < $preg_tmp; $j++){
			$items[$i]['order_name'] = substr(substr($preg_order_name[0][$j],1), 0 ,-39);
			$namesAmount++;
		}
	}
	
	// Обрезаем элементы, которые относится к ордерам продажи а не покупки.
	$amountUnseting = $namesAmount - $orderNumbers;
	for($k = 0; $k < $orderNumbers; $k++){
		$items[$k]['order_name'] = $items[($amountUnseting + $k)]['order_name'];
	}

	// Вытаскиваем количество.
	$preg_item_CLASS_INSTANCE = preg_match_all(("/(<span class=\"market_listing_inline_buyorder_qty\">)[0-9]{1}/"),(string)$output_curl, $item_CLASS_INSTANCE);
	for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
		$items[$i]['order_amount'] = (int)substr($item_CLASS_INSTANCE[0][$i],49);	
	}
	
	// Вытаскиваем цену запроса.
	$preg_item_CLASS_INSTANCE = preg_match_all(("/(@<\/span>)[a-z0-9руб\s.,]{1,}/"),(string)$output_curl, $item_CLASS_INSTANCE);
	for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
		$items[$i]['order_price'] = (float)str_replace(",", ".", substr($item_CLASS_INSTANCE[0][$i],8,-10));	
	}
	if($orderNumbers == 0){
		return false;
	}else{
		return($items);	
	}
	
}
//	Функция удаления ордера.
function delete_order($order_number){
	$sessionId = $_SESSION['sessionId'];
	$cookies = $_SESSION['cookies'];
	$data = array(
		'sessionid' => $sessionId,
		'buy_orderid' => $order_number
	);
	$url = 'http://steamcommunity.com/market/cancelbuyorder/';
	$c = curl_init();
	curl_setopt($c, CURLOPT_HEADER, false);
	curl_setopt($c, CURLOPT_NOBODY, false);
	curl_setopt($c, CURLOPT_URL, $url);
	curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)");
	//curl_setopt($c, CURLOPT_COOKIEFILE, '../../../cookiejar.txt');
	//curl_setopt($c, CURLOPT_COOKIEFILE, 'cookiejar.txt');
	curl_setopt($c, CURLOPT_COOKIE, $cookies);
	curl_setopt($c, CURLOPT_POST, 1);
	curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_HTTPHEADER, array('Referer: http://steamcommunity.com/market/'));
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($c, CURLOPT_CUSTOMREQUEST, strtoupper('POST'));
	$output = curl_exec($c);
	curl_close($c);
	$res = json_decode($output);
	$error_code = '';
	$error_description = '';
	if(($res->success) == 1){
		$response = ("Deleting is OK! ");
	}else{
		$status = 0;
		$error_code = $res->error;
		if($error_code == 'null'){
			$response = ("Item deleted. ");
		}else{
			$response = ("Problem with auth! Please login");
		}
	}
	return $response;	
}
//	Функция выставления ордера.
function place_order($market_hash_name,$price){
	$sessionId = $_SESSION['sessionId'];
	$cookies = $_SESSION['cookies'];
	$data = array(
		'sessionid' => $sessionId,
		'currency' => 5,
		'appid' => 730,
		'market_hash_name' => $market_hash_name,
		'price_total' => $price,
		'quantity' => 1
	);
	$url = 'https://steamcommunity.com/market/createbuyorder/';
	$c = curl_init();
	curl_setopt($c, CURLOPT_HEADER, false);
	curl_setopt($c, CURLOPT_NOBODY, false);
	curl_setopt($c, CURLOPT_URL, $url);
	curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)");
	//curl_setopt($c, CURLOPT_COOKIEFILE, '../../../cookiejar.txt');
	//curl_setopt($c, CURLOPT_COOKIEFILE, 'cookiejar.txt');
	curl_setopt($c, CURLOPT_COOKIE, $cookies);
	curl_setopt($c, CURLOPT_POST, 1);
	curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($c, CURLOPT_HTTPHEADER, array('Referer: http://steamcommunity.com/market/listings/'));
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($c, CURLOPT_CUSTOMREQUEST, strtoupper('POST'));
	$output = curl_exec($c);
	curl_close($c);
	$res = json_decode($output);
	
	// успешный ответ {"success":1,"buy_orderid":"1338185887"}
	if($res->success == 1){
		$response = "Placeing at " . ($price/100) . " is OK! Buy order: " . $res->buy_orderid;
	}else{
		$response = "Placeing is FAIL! Error message: Please login or add funds!" . $res->message;
	}
	return ($response);	
}
//	Сессия для получения куков
include('../../service/bots_API_keys.php');
require_once("../../service/dbconnect.php");
session_start();
$cookie_path = "../../auth/cookie_" . $_SESSION["steamid"] . "/h2px74b0c98dn2m11.txt";
$sessionId = $_SESSION['sessionId'];
$cookies = $_SESSION['cookies'];
$fatal_error = 0;
$amount_of_attempts = 3;
$lower_limit = $_POST['tlower_limit_refresh'];

//	Делаем запрос в Steam для получения исходного кода страницы.
$url = "http://steamcommunity.com/market/";
$c = curl_init();
curl_setopt($c, CURLOPT_HEADER, false);
curl_setopt($c, CURLOPT_NOBODY, false);
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)");
//curl_setopt($c, CURLOPT_COOKIEFILE, '../../../cookiejar.txt'); //Для скрипта , выполняющегося не из под index.php
curl_setopt($c, CURLOPT_COOKIEFILE, $cookie_path);
curl_setopt($c, CURLOPT_HTTPHEADER, array('Referer: http://store.steampowered.com/?l=russian'));
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$output_curl = curl_exec($c);
curl_close($c);

$items = get_order_data_from_Steam($output_curl);//	Получаем массив с данными о предметах.
$out_str = ($items[0]['order_number']) . " " . ($items[0]['order_name']) . " " . ($items[0]['order_amount']) . " " . ($items[0]['order_price']);
if($items == false){
	$act = "No buy orders!";
	$status = "No buy orders!";
}else{
	// Достаем для всех вещей данный о цене
	for($k=$lower_limit;$k<($lower_limit+1);$k++){
		//	Вытаскиваем из ТМ значение classid_instanceid по market_hash_name.
		//	Используем $amount_of_attempts попыток, если за эти $amount_of_attempts попыток запрос успешно отправится, то выходим из цикла.
		for($counter = 0; $counter < $amount_of_attempts; $counter++){
			$tmp_items = str_replace(" ", "%20", $items[$k]['order_name']);
			$tmp_items = str_replace("|", "%7C", $tmp_items);
			$url = "https://market.csgo.com/api/SearchItemByName/" . $tmp_items . "/?key=" . $bot_secret_key[6];
			$try2 = $items[$k]['order_name'];
			$try = $url;
			
			$inv = curl_init($url);
			curl_setopt($inv, CURLOPT_HEADER, false);
			curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($inv, CURLOPT_CONNECTTIMEOUT, 5);
			$output_curl = curl_exec($inv);
			$try1 = $output_curl;
			curl_close($inv);
			$responce = json_decode($output_curl);
			$temp = $responce->list;
			$ids = $temp[0]->i_classid . "_" . $temp[0]->i_instanceid;
			$error_status_1 = 1;
			$error_1 = "There are no results for getting classid_instanceid from CSGOTM after ".$amount_of_attempts." attempts! ";
			if(($ids != 0 && $ids != "" && $ids != "_")){
				$error_1 = "The classid_instanceid was obtained by the " . ($counter + 1) . " attempt! ";
				$error_status_1 = 0;
				break;
			}
		}
		//	Вытаскиваем из ТМ цену запроса на покупку.
		//	Если classid_instanceid получен.
		if($error_status_1 != 1){
			//Используем $amount_of_attempts попыток, если за эти $amount_of_attempts попыток запрос успешно отправится, то выходим из цикла.
			for($counter = 0; $counter < $amount_of_attempts; $counter++){
				//$url = "https://market.csgo.com/api/ItemInfo/" . $ids . "/ru/?key=" . $bot_secret_key[$counter+$k];
				$url = "https://market.csgo.com/api/ItemInfo/" . $ids . "/ru/?key=" . $bot_secret_key[7];
				$inv = curl_init($url);
				curl_setopt($inv, CURLOPT_HEADER, false);
				curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($inv, CURLOPT_CONNECTTIMEOUT, 5);
				$output_curl = curl_exec($inv);
				curl_close($inv);
				$responce = json_decode($output_curl);
				$tmp = $responce->buy_offers;
				$o_price = ($tmp[0]->o_price)/100;//Цена наибольшего запроса на покупку в TM
				$c = ($tmp[0]->c);//Количество этих зпросов
				$error_status_2 = 1;
				$error_2 = "There are no results for getting prices from CSGOTM after ".$amount_of_attempts." attempts! ";
				if(($o_price != 0 && $o_price != "" && $o_price != null)){
					$error_2 = "The price of CSGOTM was obtained by the " . ($counter + 1) . " attempt! ";
					$error_status_2 = 0;
					break;
				}
			}
		}
		//	Если o_price получена.
		if(($error_status_1 != 1) && ($error_status_2 != 1)){
			// Получаем из БД nameid (уникальный номер для каждого предмета на тороговой площадке Стим), для получения цены наибольшего запроса в Стиме.
			//	Парсм market_hash_name для получения названия Оружия, имени предмета и качества.
			$tmp_weapon = substr($items[$k]['order_name'], 0, strpos($items[$k]['order_name'], "|") - 1);
			$tmp_name = substr($items[$k]['order_name'], strpos($items[$k]['order_name'], "|")+2, (strpos($items[$k]['order_name'], "(") - (strpos($items[$k]['order_name'], "|")+2))-1);
			$tmp_quality = substr($items[$k]['order_name'], strpos($items[$k]['order_name'], "(")+1, (strpos($items[$k]['order_name'], ")") - (strpos($items[$k]['order_name'], "(")+1)));
			
			//	Получаем уникальный номер на ТП Стима из нашей БД.
			$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$tmp_weapon' AND name='$tmp_name' AND quality='$tmp_quality'";
			$select_data = mysql_query($query);
			while ($row = mysql_fetch_assoc($select_data)) {	
				$item_nameid = $row['item_nameid'];//Уникальный номер предмета на торговой площадке Steam.
			}
			for($counter = 0; $counter < $amount_of_attempts; $counter++){
				//	Вытаскиваем из Стима цену наибольшего запроса на покупку.
				$url = "http://steamcommunity.com/market/itemordershistogram?country=RU&language=english&currency=5&item_nameid=" . $item_nameid . "&two_factor=0";
				$inv = curl_init($url);
				curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($inv, CURLOPT_HEADER, false);
				curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($inv, CURLOPT_CONNECTTIMEOUT, 5);
				$output_curl = curl_exec($inv);
				curl_close($inv);
				$highest_buy_order = (json_decode($output_curl)->highest_buy_order)/100;
				$error_3 = "There are no results for getting prices from STEAM after ".$amount_of_attempts." attempts! ";
				$error_status_3 = 1;
				if(($highest_buy_order != 0 && $highest_buy_order != "" && $highest_buy_order != null)){
					$error_3 = "The price of STEAM was obtained by the " . ($counter + 1) . " attempt! ";
					$error_status_3 = 0;
					break;
				}else{
					sleep(2);	//	Существует возможность быть забанеым в стиме из за большого числа запросов.
				}
			}
		}else{
			$fatal_error = 1;
		}
		
		$percent = number_format((((($o_price/1.05) * 100)/$highest_buy_order) - 100), 2, '.', '');
		//	Обработка данных. Алгоритм переопределения ордеров.
		//	Формируем лог.
		$action = "";
		$act = "";
		if($highest_buy_order > $items[$k]['order_price']){// Если цена последнего ордера в Стиме больше чем мой ордер.
			if((((($o_price/1.05) * 100)/$highest_buy_order) - 100) > -15){// Если ордер все еще выгоден по отношению к TM.
				$future_order_price = (($highest_buy_order*100) + 1);
				$action .= "Lift the order. ";
				//	Удаляем предыдущий заказ.
				$action .= delete_order($items[$k]['order_number']);
				
				//	Выставляем новый ордер.
				$action .= place_order($items[$k]['order_name'],$future_order_price);
				$act = "raise";
			}else{
				//Удаляем ордер.
				$action .= "Remove the order. ";
				$action .= delete_order($items[$k]['order_number']);
				$act = "remove";
			}
		}else{//	Если последний ордер в Стиме мой.
			if((((($o_price/1.05) * 100)/$highest_buy_order) - 100) > -15){// Если ордер все еще выгоден по отношению к TM.
				//	Оставляем заказ как есть.
				$action .= "Leave order. ";
				$act = "leave";
			}else{
				//Удаляем ордер если он не выгоден по отношению к TM, при условии что последний заказ в Стиме мой.
				$action .= "Remove the order. ";
				$action .= delete_order($items[$k]['order_number']);
				$act = "remove";
			}
		}
		
		$action_log = "";
		$action_log = "[" . date("d.m.Y H:i:s") . "]<br>";
		$action_log .= "Market hash name: " . $items[$k]['order_name'] . "<br>";
		$action_log .= "Item_nameid: " . $item_nameid . "<br>";
		$action_log .= $error_1 . " classid_instanceid: " . $ids . "<br>";
		$action_log .= "My order price: " . $items[$k]['order_price'] . "<br>";
		$action_log .= "My future order: " . ((($highest_buy_order*100) + 1)/100) . "<br>";
		$action_log .= $error_2 . " CSGOTM order price: " . $o_price . "<br>";
		$action_log .= $error_3 . " STEAM order price: " . $highest_buy_order . "<br>";
		$action_log .= "Percent: " . $percent . "<br>";
		$action_log .= "Action: " . $action . "<br>";
		
		$log[$k] = $action_log;
		$str .= $log[$k];
		
		if($ids != "_"){
			$status = "Success";
		}else{
			$status = "Error";
		}
	}
}

$response = array(
	'status' => $status,
	'action' => $act,
	'logs' => $str
);
echo(json_encode($response));

?>
