<?php
// Читает прокси из файла.
function read_proxy_list(){
	$content = file_get_contents('../lists/proxy_list.txt');
	return $content;	
}
// Записывает прокси в файл.
function write_proxy_list($text){
	$filename = '../lists/proxy_list.txt';
	file_put_contents($filename, $text);
}
// Обрезает "руб." у ответа стима.
function cut_priceSteam($priceSt){
	$priceSt = substr($priceSt,0,-7);
	$priceSt = str_replace(",", ".", $priceSt);
	$priceSt = number_format($priceSt, 2, '.', '');
	return $priceSt;
}
// Парсит ответ стима в массив.
function parse_steam_answer($steam_answer){
	$steam_answer = json_decode($steam_answer);
	$data = array(
		"success" => $steam_answer->success,
		"lowest_price" => cut_priceSteam($steam_answer->lowest_price),
		"volume" => $steam_answer->volume,
		"median_price" => cut_priceSteam($steam_answer->median_price)
	);
	return $data;
}
// Отправляет запрос в Стим на получение цен.
function get_steam_prices($market_hash_name,$proxy){
	$market_hash_name_link = str_replace(" ", "%20", $market_hash_name);	
	$market_hash_name_link = str_replace("(", "%28", $market_hash_name_link);
	$market_hash_name_link = str_replace(")", "%29", $market_hash_name_link);
	$url = "http://steamcommunity.com/market/priceoverview/?country=RU&currency=5&appid=730&market_hash_name=" . $market_hash_name_link;
	$inv = curl_init($url);
	curl_setopt($inv, CURLOPT_PROXY, $proxy);
	curl_setopt($inv, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
	curl_setopt($inv, CURLOPT_HEADER, false);
	curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($inv, CURLOPT_TIMEOUT, 3);
	$output_curl = curl_exec($inv);
	curl_close($inv);
	return $output_curl;		
}
// Получает новый прокси адрес из free proxy API.
function get_proxy(){
	// Получаем новый прокси.
	$get_proxy_url = "https://api.getproxylist.com/proxy";// Resource of free proxy API.
	// Пробуем получить прокси с разных API.
	for($k = 0; $k < 2; $k++){
		$new_proxy = curl_init($get_proxy_url);
		curl_setopt($inv, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
		curl_setopt($new_proxy, CURLOPT_HEADER, false);
		curl_setopt($new_proxy, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($inv, CURLOPT_TIMEOUT, 3);
		$new_proxy_out = curl_exec($new_proxy);
		curl_close($new_proxy);
		//echo($new_proxy_out);
		$ip = json_decode($new_proxy_out)->ip;
		$port = json_decode($new_proxy_out)->port;
		$proxy = $ip . ":" . $port;
		if($proxy != ":"){
			return $proxy;
		}else{
			$get_proxy_url = "http://gimmeproxy.com/api/getProxy";// Resource of free proxy API.
		}
	}
	return false;
}

// Main.
$market_hash_name = "AK-47%20%7C%20Blue%20Laminate%20%28Factory%20New%29";
$old_proxy  = read_proxy_list();
if( ($old_proxy != "") && (isset($old_proxy)) ){
	$proxy_address = $old_proxy;
}else{
	$proxy_address = get_proxy();
	write_proxy_list($proxy_address);
}
$step = 0;
while($step != 10){// Количество попыток получить корректный ответ от Стима.
	if($proxy_address != false){
		echo("Start proxy address: " . $proxy_address . "<br>");
		$steam_answer = get_steam_prices($market_hash_name,$proxy_address);
		$data = parse_steam_answer($steam_answer);
		if($data["success"]){
			if( (($data["lowest_price"] != "") && (isset($data["lowest_price"]))) || (($data["median_price"] != "") && (isset($data["median_price"]))) || (($data["volume"] != "") && (isset($data["volume"]))) ){
				echo("Responce obtained by  <b>" . $i . "</b> step. ");
				echo("Median: " . $data["median_price"] . "; Lowest: " . $data["lowest_price"] . "; Volume: " . $data["volume"] . "<br>");
				break;
			}else{
				// Bad marker hash name.
				echo("Bad get paraneters.<br>");
			}
		}else{
			// Bad proxy.
			echo("Bad proxy server.<br>");
			$proxy_address = get_proxy();
			write_proxy_list($proxy_address);
			echo("New proxy address: " . $proxy_address . "<br>");
		}	
	}else{
		// Bad attempt to work with proxy API.
	}
	echo("<br>" . $step . "<br>");
	$step++;
}
?>