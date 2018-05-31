<?php

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
        $API_resource[0] = "https://api.getproxylist.com/proxy";
        $API_resource[1] = "http://gimmeproxy.com/api/getProxy";
        $API_resource[2] = "http://pubproxy.com/api/proxy?limit=1&format=txt&http=true&country=US&type=http";
        $API_resource[3] = "https://raw.githubusercontent.com/clarketm/proxy-list/master/proxy-list.txt";
        $API_resource[4] = "https://spinproxies.com/api/v1/proxylist?country_code=US&key=a27mfq0y0k5c9vkix30no2iq7kvqle";

        for ($k = 0; $k < count($API_resource); $k++) {
            if (($k == 0) || ($k == 1)) {
                $new_proxy_out = make_request($API_resource[$k]);
                $ip = json_decode($new_proxy_out)->ip;
                $port = json_decode($new_proxy_out)->port;
                $proxy = $ip . ":" . $port;
                if ($proxy != ":") {
                    return($proxy);
                }
            } elseif ($k == 2) {
                $new_proxy_out = make_request($API_resource[$k]);
                if (($new_proxy_out != null) && ($new_proxy_out != "") && (isset($new_proxy_out))) {
                    return($new_proxy_out);
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
                    return($all_new_proxies[0]);
                } else {
                    $proxy_array = delim_proxy_string($proxies);
                    for ($j = 1; $j < count($proxy_array); $j++) {
                        $residue .= $proxy_array[$j] . ",";
                    }
                    write_proxy_list('../../lists/proxy/proxy_list_spys_one_API.txt', $residue);
                    return($proxy_array[0]);
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
                    return ($proxies[0]->ip . ":" . $proxies[0]->port);
                } else {
                    $proxy_array = delim_proxy_string($spin_proxies);
                    for ($j = 1; $j < count($proxy_array); $j++) {
                        $residue .= $proxy_array[$j] . ",";
                    }
                    write_proxy_list('../../lists/proxy/proxy_list_spinproxy.txt', $residue);
                    return ($proxy_array[0]);
                }
            }
        }
        return false;
    }

    $market_hash_name = "AK-47%20%7C%20Blue%20Laminate%20%28Factory%20New%29";
    $old_proxy = read_proxy_list('../../lists/proxy/proxy_list.txt');
    if (($old_proxy != "") && (isset($old_proxy))) {
        $proxy_address = $old_proxy;
    } else {
        $proxy_address = get_proxy();
        write_proxy_list('../../lists/proxy/proxy_list.txt', $proxy_address);
    }
    echo("Start proxy address: " . $proxy_address . "<br>");
    $step = 0;
    while ($step != 10) {
        echo("<br>" . $step . " step : ");
        if ($proxy_address != false) {

            $steam_answer = get_steam_prices($market_hash_name, $proxy_address);
            $data = parse_steam_answer($steam_answer);
            if ($data["success"]) {
                if ((($data["lowest_price"] != "") && (isset($data["lowest_price"]))) || (($data["median_price"] != "") && (isset($data["median_price"]))) || (($data["volume"] != "") && (isset($data["volume"])))) {
                    echo("Responce obtained by  <b>" . $step . "</b> step. ");
                    echo("Median: " . $data["median_price"] . "; Lowest: " . $data["lowest_price"] . "; Volume: " . $data["volume"] . "<br>");
                    break;
                } else {
                    echo("Bad get paraneters.<br>");
                }
            } else {
                echo("Bad proxy server.<br>");
                $proxy_address = get_proxy();
                write_proxy_list('../../lists/proxy/proxy_list.txt', $proxy_address);
                echo("New proxy address: " . $proxy_address . "<br>");
            }
        } else {
            // Bad attempt to work with proxy API.
        }

        $step++;
    }
?>