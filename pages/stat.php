
<?php

    function getprice_tm_order($input_str) {
        $preg_item_price = preg_match_all(("/(\"o_price\":\")[0-9]{1,}/"), (string) $input_str, $item_price_array, PREG_PATTERN_ORDER);
        for ($i = 0; $i < $preg_item_price; $i++) {
            $price = substr((string) $item_price_array[0][0], 11);
        }
        return $price;
    }

    function getprice_tm($input_str) {
        $preg_item_price = preg_match_all(("/(\"min_price\":\")[0-9]{1,}/"), (string) $input_str, $item_price_array, PREG_PATTERN_ORDER);
        for ($i = 0; $i < $preg_item_price; $i++) {
            $price = substr((string) $item_price_array[0][$i], 13);
        }
        return $price;
    }

    function getprice_steam($input_str) {
        $preg_item_price_st = preg_match_all(("/(\"median_price\":\")[0-9,]{1,}(\s)/"), (string) $input_str, $item_price_st_array);
        for ($i = 0; $i < $preg_item_price_st; $i++) {
            $price_st = substr((string) $item_price_st_array[0][$i], 16);
        }
        return $price_st;
    }

    function cut_priceSteam($priceSt) {
        $priceSt = substr($priceSt, 0, -7);
        $priceSt = str_replace(",", ".", $priceSt);
        $priceSt = number_format($priceSt, 2, '.', '');
        return $priceSt;
    }

    function set_request($url) {
        $req = curl_init($url);
        curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($req, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($req, CURLOPT_HEADER, false);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        $output_curl_request = curl_exec($req);
        curl_close($req);
        return $output_curl_request;
    }

    function set_query($t_weapon, $t_name, $t_quality, $t_category, $t_type) {
        $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND quality='$t_quality' AND category='$t_category' AND type='$t_type'";


        if ($t_weapon == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name' AND quality='$t_quality' AND category='$t_category' AND type='$t_type'";
        }
        if ($t_name == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND quality='$t_quality' AND category='$t_category AND type='$t_type'";
        }
        if ($t_quality == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND category='$t_category' AND type='$t_type'";
        }
        if ($t_category == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND quality='$t_quality' AND type='$t_type'";
        }
        if ($t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND quality='$t_quality' AND category='$t_category'";
        }


        if ($t_weapon == "0" && $t_name == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE quality='$t_quality' AND category='$t_category' AND type='$t_type'";
        }
        if ($t_weapon == "0" && $t_quality == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name' AND category='$t_category' AND type='$t_type'";
        }
        if ($t_weapon == "0" && $t_category == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name' AND quality='$t_quality' AND type='$t_type'";
        }
        if ($t_weapon == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name' AND quality='$t_quality' AND category='$t_category'";
        }
        if ($t_name == "0" && $t_quality == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND category='$t_category' AND type='$t_type'";
        }
        if ($t_name == "0" && $t_category == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND quality='$t_quality' AND type='$t_type'";
        }
        if ($t_quality == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND category='$t_category'";
        }
        if ($t_quality == "0" && $t_category == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name' AND type='$t_type'";
        }
        if ($t_quality == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND category='$t_category' AND name='$t_name'";
        }
        if ($t_category == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND quality='$t_quality' AND name='$t_name'";
        }


        if ($t_weapon == "0" && $t_name == "0" && $t_quality == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE category='$t_category' AND type='$t_type'";
        }
        if ($t_weapon == "0" && $t_name == "0" && $t_category == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE quality='$t_quality' AND type='$t_type'";
        }
        if ($t_weapon == "0" && $t_quality == "0" && $t_category == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name' AND type='$t_type'";
        }
        if ($t_quality == "0" && $t_name == "0" && $t_category == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND type='$t_type'";
        }
        if ($t_weapon == "0" && $t_name == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE quality='$t_quality' AND category='$t_category'";
        }
        if ($t_weapon == "0" && $t_quality == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE category='$t_category' AND name='$t_name'";
        }
        if ($t_name == "0" && $t_quality == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND category='$t_category'";
        }
        if ($t_weapon == "0" && $t_category == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE quality='$t_quality' AND name='$t_name'";
        }
        if ($t_name == "0" && $t_type == "0" && $t_category == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND quality='$t_quality'";
        }
        if ($t_quality == "0" && $t_type == "0" && $t_category == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon' AND name='$t_name'";
        }


        if ($t_weapon == "0" && $t_name == "0" && $t_quality == "0" && $t_category == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE type='$t_type'";
        }
        if ($t_weapon == "0" && $t_name == "0" && $t_quality == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE category='$t_category'";
        }
        if ($t_weapon == "0" && $t_name == "0" && $t_category == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE quality='$t_quality'";
        }
        if ($t_weapon == "0" && $t_quality == "0" && $t_category == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE name='$t_name'";
        }
        if ($t_name == "0" && $t_quality == "0" && $t_category == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam WHERE weapon='$t_weapon'";
        }

        if ($t_weapon == "0" && $t_name == "0" && $t_quality == "0" && $t_category == "0" && $t_type == "0") {
            $query = "SELECT * FROM searchList_TMToSteam";
        }
        return $query;
    }

    require_once("service/dbconnect.php");
    include('service/bots_API_keys.php');
    session_start();

    $lower_limit = (int) $_POST['lower_limit'];
    $amount_items_one_upload = $_POST['amount'];

    $t_weapon = $_POST['tweapon'];
    $t_name = $_POST['tname'];
    $t_quality = $_POST['tquality'];
    $t_category = $_POST['tcategory'];
    $t_type = $_POST['ttype'];

    $query = set_query($t_weapon, $t_name, $t_quality, $t_category, $t_type);
    //-----------Working with csgoTM cUrl---------------------//	
    $select_data = mysql_query($query);
    $i = 0;
    while ($row = mysql_fetch_assoc($select_data)) {
        $weapon[$i] = $row['weapon'];
        $name[$i] = $row['name'];
        $quality[$i] = $row['quality'];
        $i++;
    }

    for ($i = 0; $i < $amount_items_one_upload; $i++) {
        $market_hash_name[$i] = $weapon[$i + $lower_limit] . " | " . $name[$i + $lower_limit] . " (" . $quality[$i + $lower_limit] . ")";
        $url = "https://market.csgo.com/api/SearchItemByName/" . $market_hash_name[$i] . "/?key=*****************";
        $inv = curl_init($url);
        curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($inv, CURLOPT_HEADER, false);
        curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
        $out = curl_exec($inv);
        curl_close($inv);
        $data = json_decode($out)->list;

        $j = 0;
        foreach ($data as $element) {
            $price[$j] = $element->price;
            $ids[$j] = $element->i_classid . "_" . $element->i_instanceid;
            $j++;
        }
        if (min($price) != "") {
            $min_price_TM[$i] = min($price) / 100;
        } else {
            $min_price_TM[$i] = "Ubsent";
        }
        unset($price);
    }

    //------------------Working with STEAM cUrl----------------------//	
    for ($i = 0; $i < $amount_items_one_upload; $i++) {
        $market_hash_name_link[$i] = str_replace(" ", "%20", $market_hash_name[$i]);
        $market_hash_name_link[$i] = str_replace("(", "%28", $market_hash_name_link[$i]);
        $market_hash_name_link[$i] = str_replace(")", "%29", $market_hash_name_link[$i]);
        $url = "http://steamcommunity.com/market/priceoverview/?country=RU&currency=5&appid=730&market_hash_name=" . $market_hash_name_link[$i];
        $ch[$i] = curl_init($url);
        curl_setopt($ch[$i], CURLOPT_HEADER, false);
        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch[$i], CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
    }
    $mh = curl_multi_init();

    for ($i = 0; $i < $amount_items_one_upload; $i++) {
        curl_multi_add_handle($mh, $ch[$i]);
    }

    $running = null;
    do {
        curl_multi_exec($mh, $running);
    } while ($running);
    for ($i = 0; $i < count($ids); $i++) {
        curl_multi_remove_handle($mh, $ch[$i]);
    }
    curl_multi_close($mh);

    for ($i = 0; $i < $amount_items_one_upload; $i++) {
        $responce = json_decode(curl_multi_getcontent($ch[$i]));
        $median_price_STEAM[$i] = $responce->median_price;
        $lowest_price_STEAM[$i] = $responce->lowest_price;
        $volume_STEAM[$i] = $responce->volume;
    }

    //-----------------Processing data--------------------//
    $ret = "";
    for ($i = 0; $i < $amount_items_one_upload; $i++) {
        $link_steam[$i] = "http://steamcommunity.com/market/listings/730/" . $market_hash_name[$i];
        $link_steam[$i] = str_replace(" ", "%20", $link_steam[$i]);
        $link_steam[$i] = str_replace("(", "%28", $link_steam[$i]);
        $link_steam[$i] = str_replace(")", "%29", $link_steam[$i]);
        $link_steam[$i] = str_replace("\u2605", "★", $link_steam[$i]);
        $link_steam[$i] = str_replace("\u9f8d", "龍", $link_steam[$i]);
        $link_steam[$i] = str_replace("\u738b", "王", $link_steam[$i]);
        $link_steam[$i] = str_replace("\u2122", "™", $link_steam[$i]);

        $market_hash_name[$i] = str_replace("%20", " ", $market_hash_name[$i]);
        $market_hash_name[$i] = str_replace("\u2605", "★", $market_hash_name[$i]);
        $market_hash_name[$i] = str_replace("\u9f8d", "龍", $market_hash_name[$i]);
        $market_hash_name[$i] = str_replace("\u738b", "王", $market_hash_name[$i]);
        $market_hash_name[$i] = str_replace("\u2122", "™", $market_hash_name[$i]);

        $TmToSteam[$i] = ((($lowest_price_STEAM[$i] / 1.15 ) * 100) / ($min_price_TM[$i])) - 100;
        $TmToSteam[$i] = number_format($TmToSteam[$i], 2, '.', '');

        $median_price_STEAM[$i] = cut_priceSteam($median_price_STEAM[$i]);
        $lowest_price_STEAM[$i] = cut_priceSteam($lowest_price_STEAM[$i]);

        $link_tm[$i] = "https://csgo.tm/item/" . str_replace("_", "-", $ids[$i]);

        if ($price_tm[$i] == 0) {
            $price_tm[$i] = "Not";
        }
        if ($price_steam[$i] == 0) {
            $price_steam[$i] = "Not";
        }
        if ($SteamToTm[$i] >= 1) {
            $color_ST_TM[$i] = "green";
        } else {
            $color_ST_TM[$i] = "red";
        }
        if ($TmToSteam[$i] >= 30) {
            $color_TM_ST[$i] = "green";
        } else {
            $color_TM_ST[$i] = "red";
        }
    }

    $amount_of_download_items = 0;
    $items = "";
    for ($i = 0; $i < $amount_items_one_upload; $i++) {
        if ($market_hash_name[$i] != "null" && $market_hash_name[$i] != " |  ()") {
            $items = $items . ('<tr>');
            $items = $items . ('<td>' . ($i + $lower_limit) . '</td>');
            $items = $items . ('<td><img src="https://cdn.csgo.com/item_' . $ids[$i] . '.png" width="32px"></td>');
            $items = $items . ('<td id="name' . $ids[$i] . '">' . $market_hash_name[$i] . '</td>');
            $items = $items . ('<td id="priceTm' . $ids[$i] . '" class="bold_line">' . $min_price_TM[$i] . '</td>');
            $items = $items . ('<td id="priceSteamReal' . $ids[$i] . '">' . $lowest_price_STEAM[$i] . '</td>');
            $items = $items . ('<td id="priceSteamMedian' . $ids[$i] . '">' . $median_price_STEAM[$i] . '</td>');
            $items = $items . ('<td id="TmToSteam' . $ids[$i] . '" class="' . $color_TM_ST[$i] . '">' . $TmToSteam[$i] . '</td>');
            $items = $items . ('<td><a href="' . $link_tm[$i] . '" target="_blank">LINK TM</a></td>');
            $items = $items . ('<td><a href="' . $link_steam[$i] . '" target="_blank">LINK ST</a></td>');
            $items = $items . ('<td><div class="update" onClick="update(\'' . $ids[$i] . '\')">Update</div></td>');
            $items = $items . ('<td <div class="update" id="update' . $ids[$i] . '" onClick="placeItem(\'' . $ids[$i] . '\')">' . $ids[$i] . '</div></td>');
            $items = $items . ('<td>' . $volume_STEAM[$i] . '</td>');
            $items = $items . ('<td>' . $status[$i] . '</td>');
            $items = $items . ('</tr>');
            $amount_of_download_items++;
        }
    }
    if (count($ids) != 0) {
        $logs = "<p>[" . date("d.m.Y H:i:s") . "]" . " Loading " . $amount_of_download_items . " new items.</p>";
    }
    $response = array(
        'items' => $items,
        'logs' => $logs,
        'buy_log' => $buy_responce_log,
        'time' => "[" . date("d.m.Y H:i:s") . "] "
    );
    echo json_encode($response);
?>




