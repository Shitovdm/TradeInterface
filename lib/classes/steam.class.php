<?php
/**
* Steam Trade PHP Class
* autor: Shitov Dmitriy
* Based on cURL requests.
*
*
**/

	//Парсим данные из курл запроса	
	/*
	*	$preg_items_exterior = preg_match_all(("/(\"Exterior:)[A-Za-z0-9\s-]{3,}(\")/"),(string)$output, $items_exterior_array);
	*	$items_array[$i]["exterior"] = substr(substr((string)$items_exterior_array[0][$i], 11),0 , -1);
	*/
	function items_array($output){
		$preg_items_name = preg_match_all(("/(\"market_hash_name\":\")[\\\\+A-Za-z0-9\s-_]{3,}(|)/"),(string)$output, $items_name_array);
		$preg_items_fullname = preg_match_all(("/(\"market_hash_name\":\")[\\\\+A-Za-z0-9\s-|()]{3,}(\")/"),(string)$output, $items_fullname_array);
		$preg_items_exterior = preg_match_all(("/(\"Exterior:)[A-Za-z0-9\s-]{3,}(\")/"),(string)$output, $items_exterior_array);
		$preg_items_collection = preg_match_all(("/(\"name\":\")[\\\\+A-Za-z0-9\s]{3,}(Collection)/"),(string)$output, $items_collection_array);
		$preg_items_id = preg_match_all(("/(\"id\":\")[0-9]{8,}/"),(string)$output, $items_id_array);
		$preg_items_tradable = preg_match_all(("/\"tradable\":[0-1]/"),(string)$output, $items_tradable_array);
		$preg_items_iconURL = preg_match_all(("/(\"icon_url\":\")[A-Za-z0-9\s-_]{10,}(\")/"),(string)$output, $items_iconURL_array);
		$preg_items_color = preg_match_all(("/(\"Rarity\",\"color\":\")[A-Za-z0-9]{6}(\")/"),(string)$output, $items_color_array);
		$preg_items_classid = preg_match_all(("/(\"classid\":\")[0-9]{8,}/"),(string)$output, $items_classid_array);
		$preg_items_instanceid = preg_match_all(("/(\"instanceid\":\")[0-9]{8,}/"),(string)$output, $items_instanceid_array);
		//Заполняем массивы данными о предметах
		for ($i = 0; $i < $preg_items_id; $i++){
			if ( substr(substr((string)$items_name_array[0][$i], 20), -5) == "Medal" ||
				 substr(substr((string)$items_name_array[0][$i], 20), -4) == "Coin" ||
				 substr(substr((string)$items_name_array[0][$i], 20), -4) == "Case" ){
				$items_array[$i]["name"] = "EXSEPTION";
				$items_array[$i]["exterior"] = "none exterior";
				$j++;
				if (substr(substr((string)$items_name_array[0][$i], 20), -5) == "Medal" ||
					substr(substr((string)$items_name_array[0][$i], 20), -4) == "Coin"){
					$k++;
					}
			}else{
				$items_array[$i]["name"] = substr((string)$items_name_array[0][$i], 20);
				$items_array[$i]["fullname"] = substr(substr((string)$items_fullname_array[0][$i], 20),0 , -1);
				if ($items_array[$i]["name"] != "Sticker "){
					$items_array[$i]["fullname"] = substr($items_array[$i]["fullname"], 0, strrpos($items_array[$i]["fullname"], '('));
					//$items_array[$i]["fullname"] = str_replace("|", "<br>", $items_array[$i]["fullname"]);	
				}
				$items_array[$i]["exterior"] = substr(substr((string)$items_exterior_array[0][$i-$j], 11),0 , -1);
				if ($items_array[$i]["name"] == "Sticker "){
					$items_array[$i]["collection"] = "Sticker";
					$s++;
					}else{
						$items_array[$i]["collection"] = substr((string)$items_collection_array[0][$i-$k-$s], 8);
					}
				$items_array[$i]["id"] = substr((string)$items_id_array[0][$i], 6);
				$items_array[$i]["tradable"] = substr((string)$items_tradable_array[0][$i], 11);
				$items_array[$i]["iconURL"] = substr(substr((string)$items_iconURL_array[0][$i], 12),0 , -1);
				$items_array[$i]["color"] = substr(substr((string)$items_color_array[0][$i], 18), 0, -1);
				$items_array[$i]["market_hash_name"] = substr(substr((string)$items_fullname_array[0][$i], 20),0 , -1);
				$items_array[$i]["market_hash_name"] = str_replace(" ", "%20", $items_array[$i]["market_hash_name"]);	
			}
		}
		for ($i = 0,$j =0; $i < count($items_array); $i++){
			if ( (string)$items_array[$i]["name"] != 'EXSEPTION' ){
				$new_array[$j] = $items_array[$i];
				$j++;
			}else{
			}
		}
		unset($items_array);
		return (array)$new_array;
	}
	
	/*
	*	Функция проверки на тред-способность.
	*	На вход подаем массив всех предметов.
	*	На выходе получаем массив из трейд-способных элементов.
	*/
	function trade_sorting($items_array){
		for($i = 0, $j = 0; $i < count($items_array); $i++){
			if ($items_array[$i]["tradable"] == 1){
				$sorting_array[$j] = $items_array[$i];
				$j++;
			}	
		}
		return (array)$sorting_array;
	}
	
	
	/*
	*	Функция выборки по коллекциям.
	*	На вход подаем массив всех трейд-способных предметов.
	*	На выходе получим массив из заданной коллекции.
	*	$items_array - массив предметов(входной);
	*	$collection_name - имя коллекции.
	* 
	*/
	function collection_sorting($items_array, $collection_name){
		for($i = 0, $j = 0; $i < count($items_array); $i++){
			if ($items_array[$i]["collection"] == $collection_name ||
				$items_array[$i]["color"] == $collection_name &&
				$items_array[$i]["tradable"] == 1){
					$sorting_array[$j] = $items_array[$i];
					$j++;
			}	
		}
		return (array)$sorting_array;
	}

	function getprice($input_str){
		$preg_item_price = preg_match_all(("/(\"lowest_price\":\")[0-9,]{1,}(\s)/"),(string)$input_str, $item_price_array);
		for ($i = 0; $i < $preg_item_price; $i++){
			$price = substr((string)$item_price_array[0][$i], 16);
		}
		return $price;
	}

?>