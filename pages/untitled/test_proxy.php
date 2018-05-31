<?php

    $url = "https://market.csgo.com/?t=293&rs=0;100&fst=0";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_output = curl_exec($curl);
    curl_close($curl);
    echo($curl_output);
?>
