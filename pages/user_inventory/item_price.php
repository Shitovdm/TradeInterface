<?php

    $item_nameid = "3445747";

    $url = "http://steamcommunity.com/market/priceoverview/?country=RU&currency=5&appid=730&market_hash_name=Револьвер R8 | Костяная маска (Закаленное в боях) ";
    $inv = curl_init($url);
    curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($inv, CURLOPT_HEADER, false);
    $output_curl = curl_exec($inv);
    curl_close($inv);


    echo($output_curl);
?>