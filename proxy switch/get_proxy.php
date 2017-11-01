<?php
function get_steam_prices($market_hash_name,$proxy){
	$market_hash_name_link = str_replace(" ", "%20", $market_hash_name);	
	$market_hash_name_link = str_replace("(", "%28", $market_hash_name_link);
	$market_hash_name_link = str_replace(")", "%29", $market_hash_name_link);
	$url = "http://steamcommunity.com/market/priceoverview/?country=RU&currency=5&appid=730&market_hash_name=" . $market_hash_name_link;
	$inv = curl_init($url);
	//curl_setopt($inv, CURLOPT_PROXY, $proxy);
	curl_setopt($inv, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
	curl_setopt($inv, CURLOPT_HEADER, false);
	curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($inv, CURLOPT_TIMEOUT, 3);
	$output_curl = curl_exec($inv);
	curl_close($inv);
	return $output_curl;		
}
function parse_steam_answer($steam_answer){
	$data = array(
		'success' => $steam_answer->success,
		'lowest_price' => $steam_answer->lowest_price,
		'volume' => $steam_answer->volume,
		'median_price' => $steam_answer->median_price
	);
	return $data;
}
function get_proxy(){
	// Получаем новый прокси.
	//$get_proxy_url = "https://api.getproxylist.com/proxy";
	$get_proxy_url = "http://gimmeproxy.com/api/getProxy";
	
	$new_proxy = curl_init($get_proxy_url);
	curl_setopt($inv, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
	curl_setopt($new_proxy, CURLOPT_HEADER, false);
	curl_setopt($new_proxy, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($inv, CURLOPT_TIMEOUT, 3);
	$new_proxy_out = curl_exec($new_proxy);
	curl_close($new_proxy);
	echo($new_proxy_out);
	$ip = json_decode($new_proxy_out)->ip;
	$port = json_decode($new_proxy_out)->port;
	$proxy = $ip . ":" . $port;
	return $proxy;
}
function write_proxy_list($text){
	$filename = '../lists/proxy_list.txt';
	file_put_contents($filename, $text);
}
function read_proxy_list(){
	$content = file_get_contents('../lists/proxy_list.txt');
	return $content;	
}
function parse_into_array($string){
	$i = 0;
	while(strlen($string) != 0){
		$delimiter = strpos($string, ",");
		$proxy[$i] = substr($string, 0, $delimiter);
		$string = substr($string, $delimiter+1);
		$i++;
	}
	return $proxy;
}

$market_hash_name = "AK-47%20%7C%20Blue%20Laminate%20%28Factory%20New%29";
$proxy_list  = read_proxy_list();
$proxy_array = parse_into_array($proxy_list);
for($i = 0; $i < count($proxy_array)-1; $i++){
	$steam_answer = get_steam_prices($market_hash_name,$proxy_array[$i]);
	echo("steam_answer: " . $steam_answer."<br>");
	$data = parse_steam_answer($steam_answer);
	echo($data.success . "<br>");
	if($data->success == "true"){
		if( ($data->median_price != "") && (isset($data->median_price)) ){
			echo("Median: " . $data->median_price . "; Lowest: " . $data->lowest_price . "; Volume: " . $data->volume . "<br>");
			break;
		}else{
			// Bad marker hash name	
		}
	}else{
		// Bad proxy.	
	}
	//echo($proxy_array[$i] . "<br>");
}


echo(read_proxy_list());
//echo(get_proxy());
?>