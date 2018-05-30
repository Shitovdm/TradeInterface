<?php
/*
*	Обновляем список активных предметов в CSGOTM.
*	Разделяем предметы по степени их готовности.	
******************************************************
*	Проверяем на наличие предметов, готовых к выводу.	
*/
include_once("../login_data.php");
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
	$i_name[$i] = $element->i_name;
	$ui_status[$i] = $element->ui_status;
	$ui_price[$i] = $element->ui_price;
	$i_classid[$i] = $element->i_classid;
    $i_instanceid[$i] = $element->i_instanceid;
	
	$link[$i] = "https://market.csgo.com/item/" . $i_classid[$i] . "-" . $i_instanceid[$i];
	
	$hours = floor($element->left/3600);
	$min = floor($minutes = ($element->left/3600 - $hours)*60);
	$seconds = ceil(($minutes - floor($minutes))*60);
	
	$left_time[$i] = $hours . ":" . $min . ":" . $seconds;
		
	if($ui_status[$i] == 4){
		$action[$i] = "GET";
	}
	if($ui_status[$i] == 3){
		$action[$i] = "WAIT";
		$left_time[$i] = "unknown";
	}
	if($ui_status[$i] == 2){
		$action[$i] = "TRANSFER";
	}
	if($ui_status[$i] == 1){
		$action[$i] = "ON SELL";
		$left_time[$i] = "unknown";
	}
	
	$i++;
}
$items = $items . "<div class='container_activeItems'>";
for($i = 0; $i < count($i_name); $i++){ //Строим список предметов(сразу для вывода на экран)
	$items = $items . "<div class='active_item_CSGOTM'>";
	$items = $items . "<img src='https://cdn.csgo.com/item/".$i_name[$i]."/300.png' width='100px' height='75px'>";
	$items = $items . "<div class='active_item_CSGOTM_price'><b>" . $ui_price[$i] . "</b></div>";
	$items = $items . "<div class='active_item_CSGOTM_action'><b>" . $action[$i] . "</b></div>";
	$items = $items . "<a href='".$link[$i]."' target='_blank'><div class='active_item_CSGOTM_info'></div></a>";
	$items = $items . "<div class='active_item_CSGOTM_timer'><span></span><b>" . $left_time[$i] . "</b></div>";
	$items = $items . "</div>";
}
$items = $items . "<div class='clear'></div></div>";

//
for($i = 0; $i < count($ui_status);$i++){
	if($ui_status[$i] == 4){
		$FLAG = true;
		break;
	}
}
if($FLAG){
	$status = 1;
}else{
	$status = 0;
}

$JSON_responce = array(
	'itemsInfo' => $items,
	'status' => $status,
	'time' => "[" . date("d.m.Y H:i:s") . "] "
);	
echo json_encode($JSON_responce);

?>