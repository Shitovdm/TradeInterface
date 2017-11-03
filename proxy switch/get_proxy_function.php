<?php
/*
*	Функция фозвращает прокси адрес.
*/
function get_proxy(){
	$API_resource[0] = "https://api.getproxylist.com/proxy"; // One proxy in json.
	$API_resource[1] = "http://gimmeproxy.com/api/getProxy"; // One proxy in json.
	$API_resource[2] = "http://pubproxy.com/api/proxy?limit=1&format=txt&http=true&country=US&type=http"; // One pure proxy.
	$API_resource[3] = "https://raw.githubusercontent.com/clarketm/proxy-list/master/proxy-list.txt"; // List with many proxy.
	$API_resource[4] = "https://spinproxies.com/api/v1/proxylist?country_code=US&key=API_KEY"; // Many proxy in json. overlimit
	
	// Пробуем получить прокси с разных API.
	for($k = 0; $k < count($API_resource); $k++){
		$new_proxy = curl_init($API_resource[$k]);
		curl_setopt($new_proxy, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
		curl_setopt($new_proxy, CURLOPT_HEADER, false);
		curl_setopt($new_proxy, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($new_proxy, CURLOPT_TIMEOUT, 3);
		$new_proxy_out = curl_exec($new_proxy);
		curl_close($new_proxy);

		if( ($k == 0) || ($k == 1) ){ // For json, 1 proxy in request.
			$ip = json_decode($new_proxy_out)->ip;
			$port = json_decode($new_proxy_out)->port;
			$proxy = $ip . ":" . $port;
			if($proxy != ":"){
				return($proxy);
			}
			
		}
		
		if($k == 2){ // For txt answers, one pure proxy in request.
			if( ($new_proxy_out != null) && ($new_proxy_out != "") && (isset($new_proxy_out))){
				return($new_proxy_out);
			}
			
		}
		
		if($k == 3){ // For txt, many proxy in request.
			// Читаем текстовый файл, если он пуст, то помещаем туда все прокси, которые спарсили из txt API.
			$proxies = read_proxy_list('../lists/proxy_list_spys_one_API.txt');
			if( ($proxies == null) ){ // Если файл пустой.
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
		}

		if($k == 4){ // For json, many proxy in request. Fast overlimit!
			$spin_proxies = read_proxy_list('../lists/proxy_list_spinproxy.txt'); // Читаем файл.
			if($spin_proxies == null){ // Если он пуст.
				echo("List is empty!");
				// Делаем запрос на получение списка прокси, парсим его, помещаем в файл.
				// Импровизированый запрос к spinproxy. 
				$spinproxy_answer = read_proxy_list('../lists/spinproxy_response.txt');
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
		// Изменить порядок выполнения запросов и порядок определения API.
		
	}
	return false;
}
?>
