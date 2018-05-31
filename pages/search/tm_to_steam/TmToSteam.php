<?php

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

    function read_proxy_list($list_name) {
        $content = file_get_contents($list_name);
        return $content;
    }

    function write_proxy_list($filename, $text) {
        file_put_contents($filename, $text);
    }

    function cut_priceSteam($priceSt) {
        $priceSt = substr($priceSt, 0, -7);
        $priceSt = str_replace(",", ".", $priceSt);
        $priceSt = number_format($priceSt, 2, '.', '');
        return $priceSt;
    }

    function parse_steam_answer($steam_answer) {
        $steam_answer = json_decode($steam_answer);
        $data = array(
            "success" => $steam_answer->success,
            "lowest_price" => cut_priceSteam($steam_answer->lowest_price),
            "volume" => $steam_answer->volume,
            "median_price" => cut_priceSteam($steam_answer->median_price)
        );
        return $data;
    }

    function get_steam_prices($market_hash_name, $proxy) {
        $market_hash_name_link = str_replace(" ", "%20", $market_hash_name);
        $market_hash_name_link = str_replace("(", "%28", $market_hash_name_link);
        $market_hash_name_link = str_replace(")", "%29", $market_hash_name_link);
        $url = "http://steamcommunity.com/market/priceoverview/?country=RU&currency=5&appid=730&market_hash_name=" . $market_hash_name_link;
        $inv = curl_init($url);
        curl_setopt($inv, CURLOPT_PROXY, $proxy);
        curl_setopt($inv, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($inv, CURLOPT_HEADER, false);
        curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($inv, CURLOPT_TIMEOUT, 3);
        $output_curl = curl_exec($inv);
        curl_close($inv);
        return $output_curl;
    }

    function delim_proxy_string($string) {
        $i = 0;
        while (strlen($string) != 0) {
            $delimiter = strpos($string, ",");
            $proxy[$i] = substr($string, 0, $delimiter);
            $string = substr($string, $delimiter + 1);
            $i++;
        }
        return $proxy;
    }

    function parse_proxy_from_list($input_txt) {
        $preg_proxy_str = preg_match_all(("/\d+.\d+.\d+.\d+:\d+/"), (string) $input_txt, $proxy_array);
        for ($i = 0; $i < $preg_proxy_str; $i++) {
            $proxy[$i] = (string) $proxy_array[0][$i];
        }
        return $proxy;
    }

    function make_request($url) {
        $new_proxy = curl_init($url);
        curl_setopt($new_proxy, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($new_proxy, CURLOPT_HEADER, false);
        curl_setopt($new_proxy, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($new_proxy, CURLOPT_TIMEOUT, 3);
        $new_proxy_out = curl_exec($new_proxy);
        curl_close($new_proxy);
        return $new_proxy_out;
    }

    function get_proxy() {
        $return_values = array(
            "proxy" => "",
            "source" => ""
        );
        $API_resource[0] = "https://api.getproxylist.com/proxy";
        $API_resource[1] = "http://gimmeproxy.com/api/getProxy";
        $API_resource[2] = "http://pubproxy.com/api/proxy?limit=1&format=txt&http=true&country=US&type=http";
        $API_resource[3] = "https://raw.githubusercontent.com/clarketm/proxy-list/master/proxy-list.txt";
        $API_resource[4] = "https://spinproxies.com/api/v1/proxylist?country_code=US&key=a27mfq0y0k5c9vkix30no2iq7kvqle";
        $f = 0;
        while (($f != 3) || ($return_values["proxy"] != "")) {
            $k = rand(1, 5) - 1;
            if (($k == 0) || ($k == 1)) {
                $new_proxy_out = make_request($API_resource[$k]);
                $ip = json_decode($new_proxy_out)->ip;
                $port = json_decode($new_proxy_out)->port;
                $proxy = $ip . ":" . $port;
                if ($proxy != ":") {
                    $return_values["proxy"] = $proxy;
                    $return_values["source"] = $API_resource[$k];
                    break;
                }
            } elseif ($k == 2) {
                $new_proxy_out = make_request($API_resource[$k]);
                if (($new_proxy_out != null) && ($new_proxy_out != "") && (isset($new_proxy_out))) {
                    $return_values["proxy"] = $new_proxy_out;
                    $return_values["source"] = $API_resource[$k];
                    break;
                }
            } elseif ($k == 3) {
                $proxies = read_proxy_list('../../lists/proxy/proxy_list_spys_one_API.txt');
                if (($proxies == null)) {
                    $new_proxy_out = make_request($API_resource[$k]);
                    $all_new_proxies = parse_proxy_from_list($new_proxy_out);
                    for ($j = 1; $j < count($all_new_proxies); $j++) {
                        $residue .= $all_new_proxies[$j] . ",";
                    }
                    write_proxy_list('../../lists/proxy/proxy_list_spys_one_API.txt', $residue);
                    $return_values["proxy"] = $all_new_proxies[0];
                    $return_values["source"] = $API_resource[$k];
                    break;
                } else {
                    $proxy_array = delim_proxy_string($proxies);
                    for ($j = 1; $j < count($proxy_array); $j++) {
                        $residue .= $proxy_array[$j] . ",";
                    }
                    write_proxy_list('../../lists/proxy/proxy_list_spys_one_API.txt', $residue);
                    $return_values["proxy"] = $proxy_array[0];
                    $return_values["source"] = $API_resource[$k];
                    break;
                }
            } elseif ($k == 4) {
                $spin_proxies = read_proxy_list('../../lists/proxy/proxy_list_spinproxy.txt');
                if ($spin_proxies == null) {
                    $spinproxy_answer = make_request($API_resource[$k]);
                    $data = json_decode($spinproxy_answer)->data;
                    $proxies = $data->proxies;
                    for ($j = 1; $j < count($proxies); $j++) {
                        $residue .= $proxies[$j]->ip . ":" . $proxies[$j]->port . ",";
                    }
                    write_proxy_list('../../lists/proxy/proxy_list_spinproxy.txt', $residue);
                    $return_values["proxy"] = $proxies[0]->ip . ":" . $proxies[0]->port;
                    $return_values["source"] = $API_resource[$k];
                    break;
                } else {
                    $proxy_array = delim_proxy_string($spin_proxies);
                    for ($j = 1; $j < count($proxy_array); $j++) {
                        $residue .= $proxy_array[$j] . ",";
                    }
                    write_proxy_list('../../lists/proxy/proxy_list_spinproxy.txt', $residue);
                    $return_values["proxy"] = $proxy_array[0];
                    $return_values["source"] = $API_resource[$k];
                    break;
                }
            }
            $f++;
        }

        if ($return_values["proxy"] != "") {
            return $return_values;
        } else {
            return false;
        }
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

    require_once("../../service/dbconnect.php");
    include('../../service/bots_API_keys.php');
    include_once("../../login_data.php");
    session_start();
    $steamid = $_SESSION['steamid'];
    $lower_limit = (int) $_POST['lower_limit'];
    $amount_items_one_upload = $_POST['amount'];
    $auto_trade_ON = $_POST['auto_trade'];
    $minimum_percentage = $_POST['minimum_percentage'];


    if (($_POST['bot_id'] == 'STEAMtoTMList') || ($_POST['bot_id'] == 'STEAMtoTMListOLD') || ($_POST['bot_id'] == 'TMtoSTEAMList') || ($_POST['bot_id'] == 'CSGOTM_profitable')) {
        $text = file_get_contents('../../lists/' . $_POST['bot_id'] . '.txt');
        $preg_item_CLASS_INSTANCE = preg_match_all(("/[0-9_-]{2,}(,)/"), (string) $text, $item_CLASS_INSTANCE);
        for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++) {
            $ids[$i] = substr($item_CLASS_INSTANCE[0][$i], 0, -1);
        }
        for ($i = 0; $i < $amount_items_one_upload; $i++) {
            $ids[$i] = str_replace("-", "_", $ids[$i + $lower_limit]);
            $url = "https://market.csgo.com/api/ItemInfo/" . $ids[$i] . "/en/?key=" . $bot_secret_key[$i];
            $inv = curl_init($url);
            curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($inv, CURLOPT_HEADER, false);
            curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
            $out = curl_exec($inv);
            curl_close($inv);
            $data = json_decode($out);
            $min_price_TM[$i] = $data->min_price / 100;
            $market_hash_name[$i] = $data->market_hash_name;
            if ($min_price_TM[$i] == -0.01) {
                $error[$i] = true;
            } else {
                $error[$i] = false;
            }
        }
    } else {
        if (($_POST['bot_id'] == 'OutSearch')) {
            $t_weapon = $_POST['tweapon'];
            $t_name = $_POST['tname'];
            $t_quality = $_POST['tquality'];
            $t_category = $_POST['tcategory'];
            $t_type = $_POST['ttype'];

            $query = set_query($t_weapon, $t_name, $t_quality, $t_category, $t_type);
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
                $url = "https://market.csgo.com/api/SearchItemByName/" . $market_hash_name[$i] . "/?key=" . $bot_secret_key[$i];
                $inv = curl_init($url);
                curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($inv, CURLOPT_HEADER, false);
                curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
                $out = curl_exec($inv);
                curl_close($inv);
                $data = json_decode($out)->list[0];
                $min_price_TM[$i] = $data->price / 100;
                $ids[$i] = $data->i_classid . "_" . $data->i_instanceid;
            }
        }
    }

    $steam_getPrice_log = "";
    $proxy_address = "";
    $get_proxy_array_values = false;
    for ($i = 0; $i < $amount_items_one_upload; $i++) {
        if ($min_price_TM[$i] != -0.01) {
            $steam_getPrice_log .= "[" . date("d.m.Y H:i:s") . "] ";
            $proxy_address = read_proxy_list('../../lists/proxy/proxy_list.txt');
            for ($step = 0; $step < 15; $step++) {
                $steam_getPrice_log .= ("Step: " . $step . "; Start proxy eddress: " . $proxy_address . "; ");
                if (($proxy_address != ":") && ($proxy_address != "") && (isset($proxy_address))) {
                    $steam_answer = get_steam_prices($market_hash_name[$i], $proxy_address);
                    if ($steam_answer != false) {
                        $data = parse_steam_answer($steam_answer);
                        if ($data["success"]) {
                            if ((($data["lowest_price"] != "") && (isset($data["lowest_price"]))) || (($data["median_price"] != "") && (isset($data["median_price"]))) || (($data["volume"] != "") && (isset($data["volume"])))) { // Если присутствуют нужные нам данные.
                                $steam_getPrice_log .= ("Responce obtained by  <b>" . $step . "</b> step. ");
                                $steam_getPrice_log .= ("Median: " . $data["median_price"] . "; Lowest: " . $data["lowest_price"] . "; Volume: " . $data["volume"] . "; ");
                                $steam_getPrice_log .= ("End proxy address: " . $proxy_address);
                                $median_price_STEAM[$i] = $data["median_price"];
                                $lowest_price_STEAM[$i] = $data["lowest_price"];
                                $volume_STEAM[$i] = $data["volume"];
                                write_proxy_list('../../lists/proxy/proxy_list.txt', $proxy_address);
                                break;
                            } else {
                                $steam_getPrice_log .= ("Bad marker hash name!");
                            }
                        } else {
                            $steam_getPrice_log .= ("Bad response!");
                        }
                    } else {
                        $steam_getPrice_log .= ("Bad get proxy function!");
                    }
                } else {
                    $steam_getPrice_log .= ("File is empty!");
                }
                $get_proxy_array_values = get_proxy();
                $proxy_address = $get_proxy_array_values["proxy"];
                $steam_getPrice_log .= (" Proxy get from: " . $get_proxy_array_values["source"] . "<br>");
            }
        } else {
            $median_price_STEAM[$i] = "Aborted";
            $lowest_price_STEAM[$i] = "Aborted";
            $volume_STEAM[$i] = "Aborted";
        }
    }

    $buy_responce_log = "";
    for ($i = 0; $i < $amount_items_one_upload; $i++) {
        $status[$i] = "Skipped";
        if ($min_price_TM[$i] != -0.01) {
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
            $TmToSteam[$i] = number_format((((($lowest_price_STEAM[$i] / 1.15 ) * 100) / ($min_price_TM[$i])) - 100), 2, '.', '');
            if ($TmToSteam[$i] >= 30) {
                $color_TM_ST[$i] = "green";
            } else {
                $color_TM_ST[$i] = "red";
            }
            if (strpos($volume_STEAM[$i], ",") !== false) {
                $volume_STEAM[$i] = str_replace(",", "", $volume_STEAM[$i]);
            }
            if (($TmToSteam[$i] >= $minimum_percentage) && ($volume_STEAM[$i] >= 20) && ($auto_trade_ON == 'Yes') && ($min_price_TM[$i] < 100)) {
                $buy_request = set_request("https://market.csgo.com/api/Buy/" . $ids[$i] . "/" . ($min_price_TM[$i] * 100) . "/?key=" . $secret_key);
                if ((json_decode($buy_request)->result) == "ok") {
                    $status[$i] = "Bought";
                    $timestamp = date("Y-m-d H:i:s");
                    $query = "INSERT 
                                              INTO bought_items 
                                              (market_hash_name, sell_price, buy_price, classid_instanceid, user_steamid, timestamp) 
                                              VALUES 	
                                              ('$market_hash_name[$i]', '$min_price_TM[$i]' , '$lowest_price_STEAM[$i]', '$ids[$i]' , '$steamid' , '$timestamp')";
                    $result = mysql_query($query);
                } else {

                    $buy_request = "Error. " . (json_decode($buy_request)->result);
                    $status[$i] = "Error";
                }
                $buy_responce_log = $buy_responce_log . "<p>[" . date("d.m.Y H:i:s") . "]" . " Bought Item: " . $market_hash_name[$i] . " By price: " . $min_price_TM[$i] . " rub. (" . ($min_price_TM[$i] * 100) . " kopeck.). Sell price: " . $lowest_price_STEAM[$i] . " rub. With profit: " . $TmToSteam[$i] . " Server responce:" . $buy_request . "</p>";
            }
        } else {
            $min_price_TM[$i] = "Absent";
            $TmToSteam[$i] = "Unknown";
        }
        if ($ids[$i] == "_") {
            $img_src[$i] = "<img src='images/red_circle.png' width='24px'>";
            $ids[$i] = "Error";
        } else {
            $link_tm[$i] = "https://market.csgo.com/item/" . str_replace("_", "-", $ids[$i]);
            $img_src[$i] = "<img src='https://cdn.csgo.com/item_" . $ids[$i] . ".png' width='32px'>";
        }
    }

    $amount_of_download_items = 0;
    $items = "";
    for ($i = 0; $i < $amount_items_one_upload; $i++) {
        if ($market_hash_name[$i] != "null" && $market_hash_name[$i] != " |  ()" && $market_hash_name[$i] != "") {
            $items = $items . ('<tr>');
            $items = $items . ('<td>' . ($i + $lower_limit + 1) . '</td>');
            $items = $items . ('<td>' . $img_src[$i] . '</td>');
            $items = $items . ('<td id="name' . $ids[$i] . '">' . $market_hash_name[$i] . '</td>');
            $items = $items . ('<td id="priceTm' . $ids[$i] . '" class="bold_line">' . $min_price_TM[$i] . '</td>');
            $items = $items . ('<td id="priceSteamReal' . $ids[$i] . '">' . $lowest_price_STEAM[$i] . '</td>');
            $items = $items . ('<td id="priceSteamMedian' . $ids[$i] . '">' . $median_price_STEAM[$i] . '</td>');
            $items = $items . ('<td id="TmToSteam' . $ids[$i] . '" class="' . $color_TM_ST[$i] . '">' . $TmToSteam[$i] . '</td>');
            $items = $items . ('<td><a href="' . $link_tm[$i] . '" target="_blank">LINK TM</a></td>');
            $items = $items . ('<td><a href="' . $link_steam[$i] . '" target="_blank">LINK ST</a></td>');
            $items = $items . ('<td><div class="update" onClick="update_itemPrices(\'' . $ids[$i] . '\')"><img class="action_icon_green" src="images/icons/update-green.png" width="100px"></div></td>');
            $items = $items . ('<td id="buy_item' . $ids[$i] . '" ><div class="update" onClick="buyItem(\'' . $ids[$i] . "','" . $market_hash_name[$i] . "','" . $min_price_TM[$i] . "','" . $lowest_price_STEAM[$i] . '\')"><img class="action_icon_green" src="images/icons/buy-green.png" width="100px"></div></td>');
            $items = $items . ('<td <div class="update" id="update' . $ids[$i] . '" onClick="placeItem(\'' . $ids[$i] . '\')"><img class="action_icon_green" src="images/icons/save-green.png" width="100px"></div></td>');
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
        'time' => "[" . date("d.m.Y H:i:s") . "] ",
        'statusOFresponce ' => $statusOFresponce,
        'steam_getPrice_log' => $steam_getPrice_log,
        'proxy_address' => $proxy_address
    );

    echo json_encode($response);
?>
