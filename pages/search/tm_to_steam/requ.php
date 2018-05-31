<?php

    require_once("../../service/dbconnect.php");

    function UNIQUE_array($array) {
        $UNIQUE_array = array_unique($array);
        $k = 0;
        for ($i = 0; $i < count($array); $i++) {
            if ($UNIQUE_array[$i] != '') {
                $uni_array[$k] = $UNIQUE_array[$i];
                $k++;
            }
        }
        return($uni_array);
    }

    $preg_item_CLASS_INSTANCE = preg_match_all(("/(Desert Eagle)[a-zA-Z0-9-|(\s']{2,}(\))/"), file_get_contents('../../lists/all_items.txt'), $item_CLASS_INSTANCE);
    for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++) {
        $all_items_array[$i] = $item_CLASS_INSTANCE[0][$i];
    }

    $sort_array = UNIQUE_array($all_items_array);
    for ($i = 0; $i < count($sort_array); $i++) {
        $only_name[$i] = substr($sort_array[$i], 0, strpos($sort_array[$i], "(") - 1);
    }

    $sort_array_only_name = UNIQUE_array($only_name);
    for ($i = 0; $i < count($sort_array); $i++) {

        $tmp_weapon = substr($sort_array[$i], 0, strpos($sort_array[$i], "|") - 1);
        $tmp_name = substr(substr($sort_array[$i], (strpos($sort_array[$i], "|") + 2)), 0, (strpos(substr($sort_array[$i], (strpos($sort_array[$i], "|") + 2)), "(") - 1));
        $tmp_quality = substr($sort_array[$i], strpos($sort_array[$i], "(") + 1, -1);
        echo($tmp_weapon);
        echo($tmp_name);
        echo($tmp_quality);
        echo("<br>");
        $query = mysql_query("INSERT INTO searchList_TMToSteam (weapon,name,quality,category,type) VALUES ('$tmp_weapon','$tmp_name','$tmp_quality','Normal','Pistol')");
    }
?>