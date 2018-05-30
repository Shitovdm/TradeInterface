
<?php
/*
*	Достаем данные из БД таблица searchList_SteamToTM, которые указал пользователь.
*/
include('../../service/bots_API_keys.php');

$t_lover_range_limit = $_POST['tlower_limit'];;//Нижняя граница(место откуда начинаем брать предметы)
$quantity = $_POST['tamount'];//Количество загружаемых предметов.
$t_weapon = $_POST['tweapon'];
$t_name = $_POST['tname'];
$t_quality = $_POST['tquality'];
$t_category = $_POST['tcategory'];
$t_type = $_POST['ttype'];

//	Лютый костыльный перебор.
//	Когда все указаны
$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND name='$t_name' AND quality='$t_quality' AND category='$t_category' AND type='$t_type'";	

// Когда 1 не указана

if($t_weapon == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE name='$t_name' AND quality='$t_quality' AND category='$t_category' AND type='$t_type'";
}
if($t_name == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND quality='$t_quality' AND category='$t_category AND type='$t_type'";
}
if($t_quality == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND name='$t_name' AND category='$t_category' AND type='$t_type'";
}
if($t_category == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND name='$t_name' AND quality='$t_quality' AND type='$t_type'";
}
if($t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND name='$t_name' AND quality='$t_quality' AND category='$t_category'";
}

// Когда 2 не указаны

if($t_weapon == "0" && $t_name == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE quality='$t_quality' AND category='$t_category' AND type='$t_type'";
}
if($t_weapon == "0" && $t_quality == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE name='$t_name' AND category='$t_category' AND type='$t_type'";
}
if($t_weapon == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE name='$t_name' AND quality='$t_quality' AND type='$t_type'";
}
if($t_weapon == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE name='$t_name' AND quality='$t_quality' AND category='$t_category'";
}
if($t_name == "0" && $t_quality == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND category='$t_category' AND type='$t_type'";
}
if($t_name == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND quality='$t_quality' AND type='$t_type'";
}
if($t_quality == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND name='$t_name' AND category='$t_category'";
}
if($t_quality == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND name='$t_name' AND type='$t_type'";
}
if($t_quality == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND category='$t_category' AND name='$t_name'";
}
if($t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND quality='$t_quality' AND name='$t_name'";
}

// Когда 3 не указаны

if($t_weapon == "0" && $t_name == "0" && $t_quality == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE category='$t_category' AND type='$t_type'";
}
if($t_weapon == "0" && $t_name == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE quality='$t_quality' AND type='$t_type'";
}
if($t_weapon == "0" && $t_quality == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE name='$t_name' AND type='$t_type'";
}
if($t_quality == "0" && $t_name == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND type='$t_type'";
}
if($t_weapon == "0" &&  $t_name == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE quality='$t_quality' AND category='$t_category'";
}
if($t_weapon == "0" &&  $t_quality == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE category='$t_category' AND name='$t_name'";
}
if($t_name == "0" &&  $t_quality == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND category='$t_category'";
}
if($t_weapon == "0" && $t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE quality='$t_quality' AND name='$t_name'";
}
if($t_name == "0" && $t_type == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND quality='$t_quality'";
}
if($t_quality == "0" && $t_type == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon' AND name='$t_name'";
}

//Когда 4 не указаны

if($t_weapon == "0" && $t_name == "0" && $t_quality == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE type='$t_type'";
}
if($t_weapon == "0" && $t_name == "0" && $t_quality == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE category='$t_category'";
}
if($t_weapon == "0" && $t_name == "0" && $t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE quality='$t_quality'";
}
if($t_weapon == "0" && $t_quality == "0" && $t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE name='$t_name'";
}
if($t_name == "0" && $t_quality == "0" && $t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon'";
}

//Когда 5 не указаны
if($t_weapon == "0" && $t_name == "0" && $t_quality == "0" && $t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_SteamToTM";
}

require_once("../../service/dbconnect.php");
$select_data = mysql_query($query);
$i=0;
while ($row = mysql_fetch_assoc($select_data)) {	
	$item_nameid[$i] = $row['item_nameid'];
	$weapon[$i] = $row['weapon'];
	$quality[$i] = $row['quality'];
	$name[$i] = $row['name'];
	$category[$i] = $row['category'];
	$type[$i] = $row['type'];
	$market_hash_name[$i] = $weapon[$i] . " | " . $name[$i] . " (" . $quality[$i] . ")"; 
	$i++;
}
$j=0;
for($k = $t_lover_range_limit; $k < ($t_lover_range_limit + $quantity); $k++){
	$item_nameid_copy[$j] = $item_nameid[$k];
	//	Вытаскиваем из Стима цену наибольшего запроса на покупку.
	$url = "http://steamcommunity.com/market/itemordershistogram?country=RU&language=russian&currency=5&item_nameid=" . $item_nameid[$k] . "&two_factor=0";
	$inv = curl_init($url);
	curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($inv, CURLOPT_HEADER, false);
	curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
	$output_curl = curl_exec($inv);
	curl_close($inv);
	$result = json_decode($output_curl);
	$highest_buy_order[$j] = $result->highest_buy_order/100;
	$lowest_sell_order[$j] = $result->lowest_sell_order/100;
	
	$market_hash_name_copy[$j] = $market_hash_name[$k];
	$market_hash_name_link[$j] = $market_hash_name[$k];
	$market_hash_name_link[$j] = str_replace(" ", "%20", $market_hash_name_link[$j]);	
	$market_hash_name_link[$j] = str_replace("(", "%28", $market_hash_name_link[$j]);
	$market_hash_name_link[$j] = str_replace(")", "%29", $market_hash_name_link[$j]);
	if($type[$k] == "Knife"){
		$market_hash_name_link[$j] = "★ " . $market_hash_name_link[$j];
		$market_hash_name_link[$j] = str_replace("|", "%7C", $market_hash_name_link[$j]);
		$market_hash_name_copy[$j] = "★ " . $market_hash_name[$k];
		
	}
	for($counter = 0; $counter < 3; $counter++){
		$url = "https://market.csgo.com/api/SearchItemByName/" . $market_hash_name_link[$j] . "/?key=" . $bot_secret_key[($j+$counter)];
		$inv = curl_init($url);
		curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($inv, CURLOPT_HEADER, false);
		curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
		$output_curl = curl_exec($inv);
		curl_close($inv);
		$responce = json_decode($output_curl);
		$temp = $responce->list;
		if(($temp[0]->i_classid != 0 && $temp[0]->i_classid != "_" && $temp[0]->i_classid != "")){
			break;
		}
	}
	
	
	//	Вытаскиваем из ТМ значение classid_instanceid по market_hash_name.
	/*$market_hash_name_copy[$j] = $market_hash_name[$k];
	$url = "https://market.csgo.com/api/SearchItemByName/" . $market_hash_name[$k] . "/?key=" . $bot_secret_key[$j+5];
	$inv = curl_init($url);
	curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($inv, CURLOPT_HEADER, false);
	curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
	$output_curl = curl_exec($inv);
	curl_close($inv);
	$responce = json_decode($output_curl);
	$temp = $responce->list;*/
	
	/*	
	*	Tm дает ответ в виде массива, состаящего из всех вещей найденных по MRKET_HASH_NAME
	*	Из всех вещей выбираем самый дешевый предмет, зачастую именно у этого предмета самая низкая ценв ордера.
	*	Есть еще вариант, выводить все вещи и выбирать самый дешевый.(неприменим)
	for($k = 0;$k < count($temp); $k++){
		//	Достаем все цены(не ордеров).
		$price_array[$k] = $temp[$k]->price;		
	}
	//	Сортируем цены по возрастанию.
	$sort_price = sort($price_array,SORT_NUMERIC);
	//	Выбираем classid_instanceid самого дешевого предмета.
	for($k = 0;$k < count($temp); $k++){
		if($temp[$k]->price == $sort_price[0]){
			$ids[$j] = $temp[$k]->i_classid . "_" . $temp[$k]->i_instanceid;
			break;
		}
	}
	*/
	
	$i_classid[$j] = $temp[0]->i_classid;
	$i_instanceid[$j] = $temp[0]->i_instanceid;
	$ids[$j] = $i_classid[$j] . "_" . $i_instanceid[$j];
	
	//	Вытаскиваем из ТМ цену запроса на покупку.
	$url = "https://market.csgo.com/api/ItemInfo/" . $ids[$j] . "/ru/?key=" . $bot_secret_key[$j+1];
	$inv = curl_init($url);
	curl_setopt($inv, CURLOPT_HEADER, false);
	curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
	$output_curl = curl_exec($inv);
	curl_close($inv);
	$responce = json_decode($output_curl);
	$tmp = $responce->buy_offers;
	$o_price[$j] = ($tmp[0]->o_price)/100;
	
	$j++;
}
	
if($item_nameid[$t_lover_range_limit] != null){
	$response_str = '';
		for($i =($quantity-1);$i>=0;$i--){//по убыванию
		if($item_nameid_copy[$i] != null){
			//	Обработка данных 
			$SteamToTm[$i] = ((((($o_price[$i])/1.05) * 100)/($highest_buy_order[$i])) - 100);
			$SteamToTm[$i] = number_format($SteamToTm[$i], 2, '.', '');
			$link_tm[$i] = 'https://market.csgo.com/item/' . str_replace("_", "-", $ids[$i]);
			$link_steam[$i] = 'http://steamcommunity.com/market/listings/730/' . $market_hash_name_copy[$i];
			$img_src[$i] = "<img src='https://cdn.csgo.com/item_" . $ids[$i] . ".png' width='32px'>";
			
			if($SteamToTm[$i] > -5){
				$percent_text_color = "green";
			}else{
				if($SteamToTm[$i] > -15){
					$percent_text_color = "yellow";
				}else{
					$percent_text_color = "red";
				}
			}
			//	Выставляем ордер на предметы, которые выгодны.
			if(($SteamToTm[$i] > -15) && ($o_price[$i] != 0)){
				$orders_status[$i] = "order";		
			}else{
				$orders_status[$i] = "skip";
			}
			
			$hash_name__price[$i] = array(
				$orders_status[$i],
				$market_hash_name_copy[$i],
				(($highest_buy_order[$i]+0.01)*100)
			);
			
			if($o_price[$i] == 0){
				$o_price[$i] = 'Absent';
				$SteamToTm[$i] = 'Unknown';
				$percent_text_color = "black";
			}
			// Если нет картинки ставим дефолтный красный круг.
			if($ids[$i] == "_"){
				$img_src[$i] = "<img src='images/red_circle.png' width='24px'>";
			}
			
			//	Формируем ответ		
			$response_str = $response_str . "";
			$response_str = $response_str . ('<tr>');
			$response_str = $response_str . ('<td>' . ($t_lover_range_limit+$i) . '</td>');
			$response_str = $response_str . ('<td>' . $img_src[$i] . '</td>');
			$response_str = $response_str . ('<td id="name' . $ids[$i] . '">' . $market_hash_name_copy[$i] . '</td>');
			$response_str = $response_str . ('<td id="priceSteamOrder' . $ids[$i] . '" class="bold_line">' . $highest_buy_order[$i] . '</td>');
			$response_str = $response_str . ('<td id="priceSteamLowest' . $ids[$i] . '" class="bold_line">' . $lowest_sell_order[$i] . '</td>');
			$response_str = $response_str . ('<td id="priceTmOrder' . $ids[$i] . '" class="bold_line">' . $o_price[$i] . '</td>');
			$response_str = $response_str . ('<td id="SteamToTm' . $ids[$i] . '" class="sort_by_profit_STTM '.$percent_text_color.'">' . $SteamToTm[$i] . '</td>');
			$response_str = $response_str . ('<td class="pointed" onClick="place_buyorder(\''.$market_hash_name_copy[$i].'\',\''.(($highest_buy_order[$i]+0.1)*100).'\')">Order</td>');	
			$response_str = $response_str . ('<td><a href="' . $link_tm[$i] . '" target="_blank">LINK TM</a></td>');
			$response_str = $response_str . ('<td><a href="' . $link_steam[$i] . '" target="_blank">LINK ST</a></td>');	
			$response_str = $response_str . ('<td>'.$orders_status[$i].'</td>');	
			$response_str = $response_str . ('</tr>');
		}else{
			// Предметы есть, но выбрано число большее чем осталось предметов в БД.
		}
	}
}else{
	$response_str = 0;
}

$response = array(
	'response_str' => $response_str,
	'order_items' => $hash_name__price
);

echo(json_encode($response));
?>
