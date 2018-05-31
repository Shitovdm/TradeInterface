<?php

    function get_and_parse_inventory($steamID) {
        $url = "https://steamcommunity.com/profiles/" . $steamID . "/inventory/json/730/2/";
        $inv = curl_init($url);
        curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($inv, CURLOPT_HEADER, false);
        curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
        $output_curl = curl_exec($inv);
        curl_close($inv);
        $data = json_decode($output_curl)->rgDescriptions;
        $k = 0;
        foreach ($data as $element) {
            $items[$k]['classid_instanceid'] = $element->classid . '-' . $element->instanceid;
            $items[$k]['market_hash_name'] = $element->market_hash_name;
            $items[$k]['name'] = $element->name;
            $items[$k]['name_color'] = $element->name_color;
            $items[$k]['quality'] = substr($element->market_hash_name, strpos($element->market_hash_name, "("));
            $items[$k]['marketable'] = $element->marketable;
            $items[$k]['type'] = $element->type;
            $items[$k]['description'] = $element->descriptions[2]->value;
            $items[$k]['collection'] = $element->descriptions[4]->value;

            if ($element->icon_url == "" || $element->icon_url == NULL) {
                $items[$k]['image'] = "images/icons/no_photo.png";
            } else {
                $items[$k]['image'] = "http://community.edgecast.steamstatic.com/economy/image/" . $element->icon_url;
            }

            if (isset($element->cache_expiration)) {
                $items[$k]['cache_expiration'] = $element->cache_expiration;
            } elseif ($items[$k]['marketable'] != 1) {
                $items[$k]['cache_expiration'] = "Not tradeble!";
            } else {
                $items[$k]['cache_expiration'] = "Available for sale!";
            }

            $k++;
        }
        return $items;
    }

    $steamID = "76561198269415170";

    $action = $_POST['t_action'];


    if ($action == "upload-inventory") {
        $items = get_and_parse_inventory($steamID);
        $min_items_content = "";
        for ($f = 1; $f <= count($items); $f++) {
            if (($f % 5 == 1)) {
                $min_items_content .= "<div class='row-item-min'>";
            }
            $min_items_content .= "<div id='min-item-" . ($f - 1) . "' class='conteiner-item-min' onClick='modal_select_item(this.id)' style='border:1px solid #" . $items[$f - 1]['name_color'] . "'><img src='" . $items[$f - 1]['image'] . "' width='100px'></div>";
            if (($f % 5 == 0)) {
                $min_items_content .= "</div><div style='clear:left;'></div>";
            }
        }
        $response = array(
            'min_items_content' => $min_items_content,
            'itemsData' => $items
        );
    }

    if (($action == "remember-selected") || ($action == "remember-all")) {
        if ($action == "remember-selected") {
            $itemsTOsave = $_POST['items'];


            $filename = '../../lists/remember_items.txt';
            $handle = fopen($filename, 'a');
            fwrite($handle, $market_hash_name_ALL);
            $response = count($items) . " selected items recorded to list.";
        } else {// remember-all
            $items = get_and_parse_inventory($steamID);
            for ($i = 0; $i < count($items); $i++) {
                $market_hash_name_ALL .= $items[$i]['market_hash_name'] . ",";
            }
            $filename = '../../lists/remember_items.txt';
            file_put_contents($filename, $market_hash_name_ALL);

            if (count($items) == 0) {
                $response = "Error. Try again later!";
            } else {
                $response = count($items) . " items recorded to list.";
            }
        }
    }

    if (($action == "clear-selected") || ($action == "clear-all")) {
        if ($action == "clear-selected") {

        } else {// clear-all
            $filename = '../../lists/remember_items.txt';
            file_put_contents($filename, '');
            $response = "List cleared!";
        }
    }

    echo(json_encode($response));
?>