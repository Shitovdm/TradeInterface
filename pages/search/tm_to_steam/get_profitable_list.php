<?php

    $text = file_get_contents('page_source_code.txt');
    $preg_item_CLASS_INSTANCE = preg_match_all(("/(class=\"item hot\" href=\"item\/)[0-9_-]{2,}/"), (string) $text, $item_CLASS_INSTANCE);
    for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++) {
        $classid_instanceid[$i] = substr(substr($item_CLASS_INSTANCE[0][$i], 0, -1), 28);
        echo($classid_instanceid[$i] . "<br>");
        $write_str .= $classid_instanceid[$i] . ",";
    }
    $filename = '../../lists/CSGOTM_profitable.txt';
    $handle = fopen($filename, 'a');
    fwrite($handle, $write_str);
?>