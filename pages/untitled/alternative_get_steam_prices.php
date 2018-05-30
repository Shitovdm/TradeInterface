<?php
//------------------Working with STEAM cUrl----------------------//	
$proxy = "80.76.102.22:8080";//Worked
//$proxy = get_proxy();

for($i = 0; $i < $amount_items_one_upload; $i++){
	$used_proxy = $proxy;
	$market_hash_name_link[$i] = str_replace(" ", "%20", $market_hash_name[$i]);	
	$market_hash_name_link[$i] = str_replace("(", "%28", $market_hash_name_link[$i]);
	$market_hash_name_link[$i] = str_replace(")", "%29", $market_hash_name_link[$i]);
	$url = "http://steamcommunity.com/market/priceoverview/?country=RU&currency=5&appid=730&market_hash_name=" . $market_hash_name_link[$i];
	$ch[$i] = curl_init($url);
	// Добавляем прокси.
	curl_setopt($ch[$i], CURLOPT_PROXY, $proxy);
	curl_setopt($ch[$i], CURLOPT_HEADER, false);
	curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch[$i], CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
	curl_setopt($ch[$i], CURLOPT_TIMEOUT, 5);
}
$mh = curl_multi_init();
	
for($i = 0; $i < $amount_items_one_upload; $i++){
	curl_multi_add_handle($mh,$ch[$i]);
}
	
$running = null;
do{
	curl_multi_exec($mh, $running);
}while ($running);
for($i = 0; $i < count($ids); $i++){
	curl_multi_remove_handle($mh, $ch[$i]);
}
curl_multi_close($mh);
$attempts_get_proxy = 1;

$amount_Attempts = 3;
for($i = 0; $i < $amount_items_one_upload; $i++){
	$output_curl[$i] = curl_multi_getcontent($ch[$i]);
	$statusOFresponce = "";
	if( ($output_curl[$i] == null) || ($output_curl[$i] == "") || (!isset($output_curl[$i])) ){
		// Make responce again.
		$statusOFresponce .= " First answer is missing!";
		for($j = 0; $j < $amount_Attempts; $j++){// Делаем попытку получить ответ 3 раза.
			//$proxy = get_proxy();// Получаем новый прокси.
			$proxy = "80.76.102.22:8080";//Worked
			// Пробуем делать запрос.
			$url = "http://steamcommunity.com/market/priceoverview/?country=RU&currency=5&appid=730&market_hash_name=" . $market_hash_name_link[$i];
			$inv = curl_init($url);
			curl_setopt($inv, CURLOPT_PROXY, $proxy);
			curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($inv, CURLOPT_HEADER, false);
			curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($inv, CURLOPT_TIMEOUT, 3);
			$output_curl[$i] = curl_exec($inv);
			curl_close($inv);

			if((json_decode($output_curl[$i])->lowest_price != "") && (isset($output_curl[$i]->lowest_price))){
				$attempts_get_proxy = $j+1;
				$used_proxy = $proxy;
				break;
			}elseif($j == $amount_Attempts - 1){
				$statusOFresponce .= "The answer is not received after 4 attempts!";
			}
		}
	}else{// Ответ пришел с первого запроса.
		$statusOFresponce = "Answer was received on the first attempt!";
	}
	
	$responce = json_decode($output_curl[$i]);
	if($responce->median_price != ""){
		$median_price_STEAM[$i] = $responce->median_price;
		$lowest_price_STEAM[$i] = $responce->lowest_price;
		$volume_STEAM[$i] = $responce->volume;
		$statusOFresponce .= "Parsing is OK! median: " . $median_price_STEAM[$i] . "; current: " . $lowest_price_STEAM[$i] . "; volume: " . $volume_STEAM[$i];
	}else{
		$statusOFresponce .= "Parsing is missing!";
	}
	
}	


?>