<?php
require_once("../../service/dbconnect.php");
$responce = "";
for($i=1001;$i<1424;$i++){
	$query = "UPDATE searchList_TMToSteam 
			  SET type = 'SMG'  
			  WHERE num = '$i'";
	$result = mysql_query($query);
	$responce .= $result;
}
echo($responce);
?>