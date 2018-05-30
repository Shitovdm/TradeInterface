<?php
// Читает прокси из файла.
function read_proxy_list($list_name){
	$content = file_get_contents($list_name);
	return $content;	
}
// Записывает прокси в файл.
function write_proxy_list($filename,$text){
	//$filename = '../lists/proxy_list.txt';
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
// Разбиваем строку в массив.
function delim_proxy_string($string){
	$i = 0;
	while(strlen($string) != 0){
		$delimiter = strpos($string, ",");
		$proxy[$i] = substr($string, 0, $delimiter);
		$string = substr($string, $delimiter+1);
		$i++;
	}
	return $proxy;
}
// Парсим прокси из любого текста.
function parse_proxy_from_list($input_txt){
$preg_proxy_str = preg_match_all(("/\d+.\d+.\d+.\d+:\d+/"),(string)$input_txt, $proxy_array);
	for ($i = 0; $i < $preg_proxy_str; $i++){
		$proxy[$i] = (string)$proxy_array[0][$i];
	}
	return $proxy;
}
// Делает запрос на страницу, для получения контента.
function make_request($url){
	$new_proxy = curl_init($url);
	curl_setopt($new_proxy, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
	curl_setopt($new_proxy, CURLOPT_HEADER, false);
	curl_setopt($new_proxy, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($new_proxy, CURLOPT_TIMEOUT, 3);
	$new_proxy_out = curl_exec($new_proxy);
	curl_close($new_proxy);
	return $new_proxy_out;
}
// Функция фозвращает прокси адрес.
function get_proxy(){
	$API_resource[0] = "https://api.getproxylist.com/proxy"; // One proxy in json.
	$API_resource[1] = "http://gimmeproxy.com/api/getProxy"; // One proxy in json.
	$API_resource[2] = "http://pubproxy.com/api/proxy?limit=1&format=txt&http=true&country=US&type=http"; // One pure proxy.
	$API_resource[3] = "https://raw.githubusercontent.com/clarketm/proxy-list/master/proxy-list.txt"; // List with many proxy.
	$API_resource[4] = "https://spinproxies.com/api/v1/proxylist?country_code=US&key=a27mfq0y0k5c9vkix30no2iq7kvqle"; // Many proxy in json. overlimit
	
	// Пробуем получить прокси с разных API.
	for($k = 0; $k < count($API_resource); $k++){
		if( ($k == 0) || ($k == 1) ){ // For json, 1 proxy in request.
			$new_proxy_out = make_request($API_resource[$k]);
			$ip = json_decode($new_proxy_out)->ip;
			$port = json_decode($new_proxy_out)->port;
			$proxy = $ip . ":" . $port;
			if($proxy != ":"){
				return($proxy);
			}
		}elseif($k == 2){ // For txt answers, one pure proxy in request.
			$new_proxy_out = make_request($API_resource[$k]);
			if( ($new_proxy_out != null) && ($new_proxy_out != "") && (isset($new_proxy_out))){
				return($new_proxy_out);
			}
		}elseif($k == 3){ // For txt, many proxy in request.
			// Читаем текстовый файл, если он пуст, то помещаем туда все прокси, которые спарсили из txt API.
			$proxies = read_proxy_list('../lists/proxy_list_spys_one_API.txt');
			if( ($proxies == null) ){ // Если файл пустой.
				$new_proxy_out = make_request($API_resource[$k]); // Делаем запрос.
				// Парсим полученный лист из API и пишем его в файл  proxy_list_spys_one_API.txt.
				$all_new_proxies = parse_proxy_from_list($new_proxy_out);
				for($j = 1; $j < count($all_new_proxies); $j++){ // Строим остаток.
					$residue .= $all_new_proxies[$j] . ",";
				}
				write_proxy_list('../lists/proxy_list_spys_one_API.txt',$residue);// Пишем остаток в файл.
				
				return($all_new_proxies[0]); // Выводим первый прокси.
			}else{ // Если файл не пустой.
				// Парсим файл с прокси на сервере, забираем первый элемент, остальное пишем обратно.
				$proxy_array = delim_proxy_string($proxies);// Парсим этот лист.
				for($j = 1; $j < count($proxy_array); $j++){ // Отрезаем первый элемент. Строим остаток.
					$residue .= $proxy_array[$j] . ",";
				}
				write_proxy_list('../lists/proxy_list_spys_one_API.txt',$residue);// Пишем остаток в файл.
				return($proxy_array[0]); // Выводим первый прокси.
			}
		}elseif($k == 4){ // For json, many proxy in request. Fast overlimit!
			$spin_proxies = read_proxy_list('../lists/proxy_list_spinproxy.txt'); // Читаем файл.
			if($spin_proxies == null){ // Если он пуст.
				echo("List is empty!");
				// Делаем запрос на получение списка прокси, парсим его, помещаем в файл.
				$spinproxy_answer = make_request($API_resource[$k]);
				// Парсим данные из запроса.
				$data = json_decode($spinproxy_answer)->data;
				$proxies = $data->proxies;
				for($j = 1; $j < count($proxies); $j++){
					$residue .= $proxies[$j]->ip . ":" . $proxies[$j]->port . ",";
				}
				write_proxy_list('../lists/proxy_list_spinproxy.txt',$residue);// Пишем остаток в файл.
				return ($proxies[0]->ip . ":" . $proxies[0]->port); // Возвращаем первый полученный прокси.
			}else{ // Если в файле еще остались прокси.
				// Достаем первый прокси из файла, остальное пишем обратно.
				$proxy_array = delim_proxy_string($spin_proxies); // Парсим этот лист.
				for($j = 1; $j < count($proxy_array); $j++){ // Отрезаем первый элемент. Строим остаток.
					$residue .= $proxy_array[$j] . ",";
				}
				write_proxy_list('../lists/proxy_list_spinproxy.txt',$residue);// Пишем остаток в файл.
				return ($proxy_array[0]);
			}

		}
	}
	return false; // Если ни один метод не отправил ответа.
}

// Test
echo(get_proxy());
?>
