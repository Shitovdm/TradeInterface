<?php
/*
*	Парсит предметы из списка в массив, разделитель ",".
*/
$exception_items = file_get_contents('remember_items.txt');
echo($exception_items . "<br><br><br>");

$counter = 0;
while(strlen($exception_items) != 0){
	$delimiter = strpos($exception_items, ",");
	$item[$i] = substr($exception_items, 0, $delimiter);
	$exception_items = substr($exception_items, $delimiter+1);
	echo($i . " . " . $item[$i] . "<br><br>");
	$i++;
}
?>