<?php

    $action = $_POST['t_action'];
    $source_code = $_POST['t_source_value'];
    $source_filename = '../../lists/page_source_code.txt';
    $filename = '../../lists/CSGOTM_profitable.txt';
    $write_str = "";
    if ($action == "clear") {
        file_put_contents($source_filename, '');
        file_put_contents($filename, '');
        $responce = "List's cleared!";
    }
    if ($action == "save") {
        file_put_contents($source_filename, '');
        $handle = fopen($source_filename, 'a');
        fwrite($handle, $source_code);

        $preg_item_CLASS_INSTANCE = preg_match_all(("/(class=\"item hot\" href=\"item\/)[0-9_-]{2,}/"), (string) $source_code, $item_CLASS_INSTANCE);
        for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++) {
            $classid_instanceid[$i] = substr(substr($item_CLASS_INSTANCE[0][$i], 0, -1), 28);
            $write_str .= $classid_instanceid[$i] . ",";
        }
        file_put_contents($filename, '');
        $handle = fopen($filename, 'a');
        fwrite($handle, $write_str);
        $responce = "Saved is success!";
    }
    if ($action == "load") {
        $write_str[0] = file_get_contents('../../lists/page_source_code.txt');
        $write_str[1] = file_get_contents('../../lists/CSGOTM_profitable.txt');
        if (isset($write_str)) {
            $responce = "Loading success!";
        } else {
            $responce = "Loading is fail!";
        }
        $preg_item_CLASS_INSTANCE = preg_match_all(("/(class=\"item hot\" href=\"item\/)[0-9_-]{2,}/"), (string) $write_str[0], $item_CLASS_INSTANCE);
        for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++) {
            $classid_instanceid[$i] = substr(substr($item_CLASS_INSTANCE[0][$i], 0, -1), 28);
        }
    }

    $RES_ARRAY = array(
        'date' => "[" . date("d.m.Y H:i:s") . "] ",
        'logs' => $responce,
        'items' => $write_str,
        'amount' => count($classid_instanceid)
    );
    echo(json_encode($RES_ARRAY));
?>
