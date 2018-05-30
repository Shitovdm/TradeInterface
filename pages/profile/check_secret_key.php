<?php
require_once("../service/dbconnect.php");
require_once("../other/encodeORdecode.php");
session_start();

/*
*	Функция проверки работоспособности ключа.
*/
function working_capacity_secretKey($secret_key){
	$url = "https://market.csgo.com/api/GetMoney/?key=". $secret_key;
	$inv = curl_init($url);
	curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($inv, CURLOPT_HEADER, false);
	curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($inv, CURLOPT_TIMEOUT, 5);
	$output_curl = curl_exec($inv);
	curl_close($inv);
	
	$json_decode_data = json_decode($output_curl);
	$money = $json_decode_data->money;
	if(isset($money)){	//{"money":95054}
		return true;
	}
	if(($json_decode_data->error) == 'Bad KEY'){ //{"error":"Bad KEY"}
		return false;
	}
}
//--------------------------------------------------------------------

$steamid = $_SESSION['steamid'];

//Если проверяем секретный ключ API tm
if($_POST['ttype'] == "secret_key"){
	$select_data = mysql_query("SELECT *
								FROM users
								WHERE steamid = '$steamid'");
	while ($row = mysql_fetch_assoc($select_data)) {	
		$get_code = $row['secretKey'];
	}
	if((substr($_POST['tchecking_field'], 0, 4)) == (substr(decode_this($get_code), 0, 4))){
		//Проверяем на наличие данного кода в БД.
		$secret_key = decode_this($get_code);
	}else{
		$secret_key = $_POST['tchecking_field'];
		if(working_capacity_secretKey($secret_key)){//Если ключ прошел проверку то сохраняем его в БД.
			$code = encode_this($secret_key,$steamid);
			$query = "UPDATE users 
					 SET secretKey = '$code'  
					 WHERE steamid = '$steamid'";
			$result = mysql_query($query);
		}	
	}	
	$flag = working_capacity_secretKey($secret_key);

}

//Если проверяем пароль
if($_POST['ttype'] == "password"){
	$password = $_POST['tchecking_field'];
	if($password == ""){
		$flag = false;
	}else{
		$password = encode_password($password,$steamid);
	$query = "UPDATE users 
			  SET password = '$password'  
			  WHERE steamid = '$steamid'";
	$result = mysql_query($query);
	$flag = true;
	}	
}

//Если проверяем secret_shared(SteamGuardCode)
if($_POST['ttype'] == "SteamGuardCode"){
	$SteamGuardCode = $_POST['tchecking_field'];
	if($SteamGuardCode == ""){
		$flag = false;
	}else{
		$SteamGuardCode = encode_this($SteamGuardCode,$steamid);
	$query = "UPDATE users 
			  SET SteamGuardCode = '$SteamGuardCode'  
			  WHERE steamid = '$steamid'";
	$result = mysql_query($query);
	$flag = true;
	}	
}


//Формируем ответ
$responce = array(
	'flag' => $flag
);
echo json_encode($responce);

?>