<?php

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

    $t_weapon = $_POST['tweapon'];
    require_once("../../service/dbconnect.php");
    $select_data = mysql_query("SELECT * FROM searchList_SteamToTM WHERE weapon='$t_weapon'");
    $string_result = '<option selected value="0">Все</option>';
    $i = 0;
    while ($row = mysql_fetch_assoc($select_data)) {
        $name[$i] = $row['name'];
        $i++;
    }
    $weapon_name = UNIQUE_array($name);
    for ($i = 0; $i < count($weapon_name); $i++) {
        $string_result = $string_result . '<option value="' . $weapon_name[$i] . '">' . $weapon_name[$i] . '</option>';
    }
    echo(json_encode($string_result));
?>