<?php
include_once("pages/other/login_data.php");
define('php-steamlogin', true);
require('main.php');
include_once("./lib/api/AuthFunctions.php");
require_once("pages/other/encodeORdecode.php");
require_once("pages/service/dbconnect.php");

session_start();

if (!isset($_GET['page'])) {
    $page = 'start_page.php';
} else {
    $page = addslashes(strip_tags(trim($_GET['page'])));
}

switch ($page) {
    case 'start_page.php':
        $title = 'Start page';
        header('Location: start_page.php');
        break;
    case 'pages/search_TMtoSteam.php':
        $title = 'Search TM to Steam';
        break;
    case 'pages/search_steamToTM (orders).php':
        $title = 'Search Steam to TM (orders)';
        break;
    case 'pages/search_steamToTM (sell).php':
        $title = 'Search Steam to TM (sell)';
        break;
    case 'pages/item_info_STtoTM.php':
        $title = 'Item info STtoTM';
        break;
    case 'pages/item_info_TMtoST.php':
        $title = 'Item info TMtoST';
        break;
}


if (isset($_GET["exit"])) {
    if ($_GET["exit"] == 1) {
        $_SESSION = array();
        session_destroy();
        header('Location: index.php');
    }
}
$_SESSION['error_login'] = "false";
if (!isset($_SESSION["priority_access"]) && $_POST['username'] != '' && $_POST['password'] != '') {
    if ($_POST['capcha'] == $_SESSION['capcha']) {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $username = mysql_real_escape_string($username);
        $password = mysql_real_escape_string($password);


        if ($username != '' && $password != '') {
            $password = encode_password($password, "************");
            $select_data = mysql_query("SELECT * 
										FROM login_users 
										WHERE username = '$username' AND password = '$password' 
										LIMIT 1");
            if (mysql_num_rows($select_data) > 0) {
                while ($row = mysql_fetch_assoc($select_data)) {
                    $_SESSION["priority_access"] = $row['priority'];
                    $_SESSION["username_login"] = $username;
                }
            } else {
                $_SESSION['error_login'] = "true";
                $_SESSION['error_desc'] = "Data is incorrect";
            }
        } else {
            $_SESSION['error_login'] = "true";
            $_SESSION['error_desc'] = "Fields are not filled";
        }
    } else {
        $_SESSION['error_login'] = "true";
        $_SESSION['error_desc'] = "Text from the image is entered incorrectly";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta content='text/html; charset=Windows-1251' http-equiv='Content-Type'>
        <title>Trade Interface v3.0</title>
        <link rel="shortcut icon" href="images/icon.ico" type="image/x-icon">
        <link rel="stylesheet" href="css/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/javascript.js"></script>		
    </head>
    <body class="body">
        <?php
            if (!isset($_SESSION["priority_access"])) {
                include('login_page.php');
            } else {
                if ($_SESSION["priority_access"] == "full_access") {
                    include('main_page.php');
                } else {
                    if ($_SESSION["priority_access"] == "limited_access") {

                    } else {
                        if ($_SESSION["priority_access"] == "view_access") {

                        }
                    }
                }
            }
        ?>
    </body>
</html>
