<?php

    session_start();
    $cookie_path = "../../auth/cookie_" . $_SESSION["steamid"] . "/h2px74b0c98dn2m11.txt";

    $url = "http://steamcommunity.com/market/";
    $c = curl_init();
    curl_setopt($c, CURLOPT_HEADER, false);
    curl_setopt($c, CURLOPT_NOBODY, false);
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)");
    curl_setopt($c, CURLOPT_COOKIEFILE, $cookie_path);
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Referer: http://store.steampowered.com/?l=russian'));
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $output_curl = curl_exec($c);
    curl_close($c);

    $preg_item_CLASS_INSTANCE = preg_match_all(("/(marketWalletBalanceAmount\">)[0-9.,]{1,}/"), (string) $output_curl, $item_CLASS_INSTANCE);
    for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++) {
        $ballance = str_replace(",", ".", substr($item_CLASS_INSTANCE[0][$i], 27));
    }

    $response = array(
        'cash' => $ballance,
        'time' => "[" . date("d.m.Y H:i:s") . "] "
    );
    echo json_encode($response);
?>