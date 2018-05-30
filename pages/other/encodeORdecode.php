<?php
/*
*	Функция кодирования пароля.
*/

function encode_password($code,$steamid){
	$base64_first4_steamid = substr((base64_encode($steamid)), 0, 6);
	$base64_other_secretKey = (base64_encode($code));
	$base64_first4_secretKey = substr((base64_encode($code)), 0, 6);
	$full_code = "=" . $base64_first4_secretKey . $base64_first4_steamid . "fEt" . $base64_other_secretKey . "=";
	return($full_code);
}


/*
*	Функция декодирует пароль.
*/


function decode_password($code){
	$full_code = substr($code, 16, -1);
	return base64_decode($full_code);
}


/*
*	Функция декодирует строку.
*/


function decode_this($code){
	$variable = substr($code, 0, 6);
	$mainCode = substr($code, 12, -1);
	$full_code = $variable . $mainCode ."=";
	return base64_decode($full_code);
}


/*
*	Функция кодирует строку.
*/


function encode_this($code,$steamid){
	$base64_first4_steamid = substr((base64_encode($steamid)), 0, 4);
	$base64_other_secretKey = substr((base64_encode($code)), 6, -1);
	$base64_first4_secretKey = substr((base64_encode($code)), 0, 6);
	$full_code = $base64_first4_secretKey . $base64_first4_steamid . "eR" . $base64_other_secretKey . "=";
	return($full_code);
}


?>