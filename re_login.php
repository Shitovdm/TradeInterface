<?php

session_start();
include_once("pages/login_data.php");
include_once("./lib/api/AuthFunctions.php");
define('php-steamlogin', true);
require('main.php');

$SteamLogin = new SteamLogin(array(
    'username' => $username,
    'password' => $password,
    'datapath' => "pages/auth/cookie_" . $_SESSION["steamid"]
        ));
if ($SteamLogin->success) {
    $SteamAuth = new SteamAuth;
    $authcode = $SteamAuth->GenerateSteamGuardCode($SteamGuardCode);
    $twofactorcode = $authcode;
    $logindata = $SteamLogin->login($authcode, $twofactorcode);
    $login = array_values($logindata);
    $_SESSION['sessionId'] = $login[1];
    $_SESSION['cookies'] = $login[2];
}
$response = ("[" . date("d.m.Y H:i:s") . "] Server response: Auth FAIL!");
if ($SteamLogin->error != '') {
    $response = ("[" . date("d.m.Y H:i:s") . "] Server response: Auth FAIL! " . $SteamLogin->error);
} else {
    $response = ("[" . date("d.m.Y H:i:s") . "] Server response: Login is success! SessionID: " . substr($login[1], 0, 10) . "...; Cookies: " . substr($login[2], 13, 10) . "...;");
}

$JSON_response = array(
    'status' => $response
);
echo json_encode($JSON_response);
?>