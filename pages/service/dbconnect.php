<?php
/*
*	Подключаемся к базе данных.
*
*/

$server = "***"; 
$database = "***"; 
$username = "***"; 
$password = "***"; 

$connect = mysql_connect($server,$username,$password) or die ( mysql_error() ); 
mysql_select_db($database);

?>