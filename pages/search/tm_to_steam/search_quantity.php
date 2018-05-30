<?php
/*	
*	Скрипт считает количество предметов, подходящих под параметры поиска.
*	Возвращает количество в json.
*/
$t_weapon = $_POST['tweapon'];
$t_name = $_POST['tname'];
$t_quality = $_POST['tquality'];
$t_category = $_POST['tcategory'];
$t_type = $_POST['ttype'];

//	Лютый костыльный перебор.
//	Когда все указаны
$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND quality='$t_quality' AND category='$t_category' AND type='$t_type'";	

// Когда 1 не указана

if($t_weapon == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name' AND quality='$t_quality' AND category='$t_category' AND type='$t_type'";
}
if($t_name == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND quality='$t_quality' AND category='$t_category AND type='$t_type'";
}
if($t_quality == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND category='$t_category' AND type='$t_type'";
}
if($t_category == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND quality='$t_quality' AND type='$t_type'";
}
if($t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND quality='$t_quality' AND category='$t_category'";
}

// Когда 2 не указаны

if($t_weapon == "0" && $t_name == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE quality='$t_quality' AND category='$t_category' AND type='$t_type'";
}
if($t_weapon == "0" && $t_quality == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name' AND category='$t_category' AND type='$t_type'";
}
if($t_weapon == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name' AND quality='$t_quality' AND type='$t_type'";
}
if($t_weapon == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name' AND quality='$t_quality' AND category='$t_category'";
}
if($t_name == "0" && $t_quality == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND category='$t_category' AND type='$t_type'";
}
if($t_name == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND quality='$t_quality' AND type='$t_type'";
}
if($t_quality == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND category='$t_category'";
}
if($t_quality == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND type='$t_type'";
}
if($t_quality == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND category='$t_category' AND name='$t_name'";
}
if($t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND quality='$t_quality' AND name='$t_name'";
}

// Когда 3 не указаны

if($t_weapon == "0" && $t_name == "0" && $t_quality == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE category='$t_category' AND type='$t_type'";
}
if($t_weapon == "0" && $t_name == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE quality='$t_quality' AND type='$t_type'";
}
if($t_weapon == "0" && $t_quality == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name' AND type='$t_type'";
}
if($t_quality == "0" && $t_name == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND type='$t_type'";
}
if($t_weapon == "0" &&  $t_name == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE quality='$t_quality' AND category='$t_category'";
}
if($t_weapon == "0" &&  $t_quality == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE category='$t_category' AND name='$t_name'";
}
if($t_name == "0" &&  $t_quality == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND category='$t_category'";
}
if($t_weapon == "0" && $t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE quality='$t_quality' AND name='$t_name'";
}
if($t_name == "0" && $t_type == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND quality='$t_quality'";
}
if($t_quality == "0" && $t_type == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name'";
}

//Когда 4 не указаны

if($t_weapon == "0" && $t_name == "0" && $t_quality == "0" && $t_category == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE type='$t_type'";
}
if($t_weapon == "0" && $t_name == "0" && $t_quality == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE category='$t_category'";
}
if($t_weapon == "0" && $t_name == "0" && $t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE quality='$t_quality'";
}
if($t_weapon == "0" && $t_quality == "0" && $t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name'";
}
if($t_name == "0" && $t_quality == "0" && $t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon'";
}

//Когда 5 не указаны
if($t_weapon == "0" && $t_name == "0" && $t_quality == "0" && $t_category == "0" && $t_type == "0"){
	$query = "SELECT * FROM searchList_TMToSteam";
}
//
require_once("../../service/dbconnect.php");
$select_data = mysql_query($query);
$i=0;
while ($row = mysql_fetch_assoc($select_data)) {	
	$item_nameid[$i] = $row['item_nameid'];
	$i++;
}
echo json_encode(count($item_nameid));
?>