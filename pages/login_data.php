<?php
    require_once("service/dbconnect.php");
    require_once("other/encodeORdecode.php");
    session_start();

    $steamid = $_SESSION['steamid'];
    $select_data = mysql_query("SELECT *
                                FROM users
                                WHERE steamid = '$steamid'");
    while ($row = mysql_fetch_assoc($select_data)) {
        $username = $row['personaname'];
        $secret_key = decode_this($row['secretKey']);
        $password = decode_password($row['password']);
        $SteamGuardCode = decode_this($row['SteamGuardCode']);
    }
?>