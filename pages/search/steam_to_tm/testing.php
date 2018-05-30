<?php

$type = "SMG,Pistol,Heavy";
$name = "";
$weapon = "P90";
$category = "";
$quality = "";

//	Функция разбиения входного параметра поиска.
function parse_param($param){
	if($param != ""){
		$end_flag = true;
		$counter = 0;
		do{
			if(strripos($param, ",")){
				$str = strpos($param, ",");
				$tmp_subject[$counter] = substr($param, 0, $str);
				$param = substr($param, $str - strlen($param) + 1 );
			}else{
				// Больше нет параметров.
				$tmp_subject[$counter] = $param;
				$end_flag = false;
			}
			$counter++;
		}while($end_flag);
		return($tmp_subject);
	}else{
		return(false);
	}	
}

//	Функция построения запроса.
function build_query($param_array, $param_name){
	if($param_array){
		$query = "";
		for($i=0;$i<count($param_array);$i++){
			$query .= $param_name . "='".$param_array[$i]."'";
			if($param_array[$i+1] != null){
				$query .= " OR ";
			}
		}
		return($query);
	}else{
		return(false);	
	}
}

function build_full_query(){
	
}
$query[0] = build_query(parse_param($type), "type");
$query[1] = build_query(parse_param($name), "name");
$query[2] = build_query(parse_param($weapon), "weapon");
$query[3] = build_query(parse_param($category), "category");
$query[4] = build_query(parse_param($quality), "quality");

$query_str = "SELECT * FROM searchList_SteamToTM WHERE ";
for($i=0;$i<count($query);$i++){
	if($query[$i]){
		$query_str .= "(" . $query[$i] . ")";
		for($j = 1; $j < count($query)-$i; $j++){
			if($query[$i+$j]){
				$query_str .= " AND ";
				break;
			}
		}
	}
}
echo($query_str);

require_once("../../service/dbconnect.php");

$select_data = mysql_query($query_str);
$i=0;
while ($row = mysql_fetch_assoc($select_data)) {	
	$item_nameid[$i] = $row['item_nameid'];
	$i++;
}
echo json_encode(count($item_nameid));

?>