<?php
/*
*	Код отправляет запрос на вывод купленной вещи на cdgoTM, который в дальнейшем необходимо принять(Прием осуществлен в файле reception.php).
*	1.Получаем массив со всеми активными вещами на csgoTM.
*	2.Отбираем нужные со статусом 4(то есть те которые мы купили, продавец передал и вещь готова, чтобы мы ее забрали у бота).
*	3.Достаем у этой вещи значение ui_bid с помощью которого в последствии мы и формируем запрос на передачу этой вещи нам.
*	4.После отправки предложения обмена, бот дает информацию об этом трейде, которую мы дальше передаем в файл reception.php.
*
*/
include_once("../login_data.php");
//Проверяем имеются ли вещи, готовые к выводу.Если имеются отправляем запрос на вывод.
$urlMyItems = "https://market.csgo.com/api/Trades/?key=" . $secret_key;
$myItems = curl_init($urlMyItems);
curl_setopt($myItems, CURLOPT_HEADER, false);
curl_setopt($myItems, CURLOPT_RETURNTRANSFER, true);
$curlItems = curl_exec($myItems);
curl_close($myItems);
//Читаем ответ, и разбиваем нужную нам информацию.
$data = json_decode($curlItems);
$i = 0;
foreach( $data as $element ){
	$ui_bid[$i] = $element->ui_bid;
	$ui_status[$i] = $element->ui_status;
	$i++;
}

for($i = 0; $i < count($ui_bid); $i++){//Перебираем все считаные id ботов.
	if(($ui_bid[$i] != 0) && ($ui_status[$i] == 4)){
		$urlTrade = "https://market.csgo.com/api/ItemRequest/out/" . $ui_bid[$i] . "/?key=" . $secret_key;
		//Используем 10 попыток, если за эти 10 попыток запрос успешно отправится то выходим из цикла.
		for($counter = 0; $counter < 15; $counter++){
			$trade = curl_init($urlTrade);
			curl_setopt($trade, CURLOPT_HEADER, false);
			curl_setopt($trade, CURLOPT_NOBODY, false);
			curl_setopt($trade, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($trade, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($trade, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)");
			$curlTrade = curl_exec($trade);
			curl_close($trade);	
			$json_array = json_decode($curlTrade);
			$responce = $curlTrade;
			if( (($json_array->success) == 1) ){
				$responce = "Success on " . $counter . " step.";
				break;
			}
			$responce = "Unsuccessfully!";
		}
		break;
	}else{
		$responce = ("No matching items for output.");	
	}
}
if(count($ui_bid) == 0){
	$responce = ("No purchased items! The list is empty.");
}

$tradeofferId = $json_array->trade;
$partner = (substr(substr($json_array->profile, 36), 0, -1));
$status = $json_array->success;
$withdrawel_log = ("[" . date("d.m.Y H:i:s") . "] " . $responce . " TradeofferId:" . $tradeofferId . " Partner:" . $partner . " Status:" . $status );//Формируем ответ об отправки трейда.
//Успешность запроса, true - если предмет выведен, false - неуспешно
if($status == 1){
	$success = true;
}else{
	$success = false;	
}

$JSON_responce = array(
	'tradeofferId' => $tradeofferId,
	'partner' => $partner,
	'status' =>	$status,
	'withdrawel_log' => $withdrawel_log,
	'success' => $success//успешность выполненого запроса.
);	
echo json_encode($JSON_responce);
?>