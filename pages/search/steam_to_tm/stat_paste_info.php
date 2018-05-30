<?php
require_once("../../service/dbconnect.php");

$value = $_POST['value'];
$operation = $_POST['operation'];
$num = $_POST['num'];

$query = "UPDATE real_bought_items_STtoTM
			SET ".$operation." = ".$value."
			WHERE num = ".$num;
	$result = mysql_query($query);
echo($result);
?>