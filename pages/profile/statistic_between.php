<?php

    require_once("../service/dbconnect.php");
    session_start();
    $steamid = $_SESSION['steamid'];

    $date_from = date("Y-m-d", strtotime($_GET['tfrom']));
    $date_to = date("Y-m-d", strtotime($_GET['tto']));

    $sell_price_sum = 0;
    $buy_price_sum = 0;
    $full_persent = 0;
    $full_summ = 0;
    $i = 0;

    $select_data = mysql_query("SELECT * FROM bought_items WHERE user_steamid='$steamid' AND timestamp BETWEEN '$date_from' AND '$date_to'");
    while ($row = mysql_fetch_assoc($select_data)) {
        $sell_price[$i] = $row['sell_price'];
        $buy_price[$i] = $row['buy_price'];
        $sell_price_sum += $sell_price[$i];
        $buy_price_sum += $buy_price[$i];
        $i++;
    }

    $amount = count($sell_price);
    $full_persent = number_format((((($buy_price_sum * 0.85 ) * 100) / ($sell_price_sum)) - 100), 2, '.', '');
    if ($full_persent == -100.00) {
        $full_persent = 0;
    }
    $full_summ = number_format(($buy_price_sum * 0.85 - $sell_price_sum), 2, '.', '');

    $response = array(
        'amount' => $amount,
        'sell_price_sum' => number_format($sell_price_sum, 2, '.', ''),
        'buy_price_sum' => number_format($buy_price_sum * 0.85, 2, '.', ''),
        'full_persent' => $full_persent,
        'full_summ' => $full_summ
    );
    echo json_encode($response);
?>