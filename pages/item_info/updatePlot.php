<?php
include_once("../other/login_data.php");
$id = $_POST['tid'];

$url = "https://market.csgo.com/api/ItemHistory/".$id."/?key=". $secret_key;
$inv = curl_init($url);
curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($inv, CURLOPT_HEADER, false);
curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
curl_setopt($inv, CURLOPT_TIMEOUT, 5);
$output_curl = curl_exec($inv);
curl_close($inv);

$json_decode_data = json_decode($output_curl);
	$number = $json_decode_data->number;
	$MIN_price = $json_decode_data->min;
	$average_price = $json_decode_data->average;
	$MAX_price = $json_decode_data->max;

if(($content = curl_exec($ch)) !== false) {
	$data = json_decode($output_curl)->history;
	$i = 0;
	foreach( $data as $element ){
		$l_price[$i] = $element->l_price;
		$l_time[$i] = $element->l_time;
		$i++;
	}	
}else{
	echo("<script>alert('Error! Not connection!');</script>");
}
for($i=0;($i<count($l_price)) && ($i<100);$i++){
		$val_array_str = $val_array_str . ("[" . $i . "," . $l_price[$i]/100 . ",'" . "P: " . $l_price[$i]/100 ." | T: ". gmdate("Y.m.d H:i:s ", $l_time[$i]) . "'],");
	}
$val_array_str = substr($val_array_str, 0, -1);
$val_array_str = "[3,4,'hfuh']";

$responce = array(
	'dataArray' => $val_array_str,
	'number' => $number,
	'minPrice' => $MIN_price/100,
	'averagePrice' => $average_price/100,
	'maxPrice' => $MAX_price/100
);
echo json_encode($responce);


?>
