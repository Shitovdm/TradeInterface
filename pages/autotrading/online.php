<?php
/*
*	Отправляет запрос csgo.tm на постоянный онлайн.
*	Принимает только ключ ТМ.
*	Никаких возвращаемых значений, просто запрос.
*/
	include_once("../login_data.php");
	$urlOnline = "https://market.csgo.com/api/PingPong/?key=" . $secret_key;
	
	$online = curl_init($urlOnline);
	curl_setopt($online, CURLOPT_HEADER, false);
	curl_setopt($online, CURLOPT_RETURNTRANSFER, true);
	$curl = curl_exec($online);
	curl_close($online);
	
	$log = "<p>[" . date("d.m.Y H:i:s") . "]" . " Online request in TM success.</p>";
	echo(json_encode($log));
?>