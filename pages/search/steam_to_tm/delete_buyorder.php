<?php

    $order_number = $_POST['torder_number'];
    session_start();
    $sessionId = $_SESSION['sessionId'];
    $cookies = $_SESSION['cookies'];

    $data = array(
        'sessionid' => $sessionId,
        'buy_orderid' => $order_number
    );
    $url = 'http://steamcommunity.com/market/cancelbuyorder/';
    $c = curl_init();
    curl_setopt($c, CURLOPT_HEADER, false);
    curl_setopt($c, CURLOPT_NOBODY, false);
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)");
    curl_setopt($c, CURLOPT_COOKIE, $cookies);
    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Referer: http://steamcommunity.com/market/'));
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($c, CURLOPT_CUSTOMREQUEST, strtoupper('POST'));
    $output = curl_exec($c);
    curl_close($c);
    $res = json_decode($output);
    $error_code = '';
    $error_description = '';
    if (($res->success) == 1) {
        $status = 1;
    } else {
        $status = 0;
        $error_code = $res->error;
        if ($error_code == 'null') {
            $error_description = 'Item deleted.';
        } else {
            $error_description = 'Problem with auth! Please login. ';
        }
    }
    $response = array(
        'status' => $status,
        'error_code' => $error_code,
        'error_description' => $error_description
    );
    echo(json_encode($response));
?>