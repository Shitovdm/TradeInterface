<?php	
session_start();
require_once("pages/service/dbconnect.php");
require 'pages/other/lightopenid/openid.php';
$_STEAMAPI = "*****";
try 
{
    $openid = new LightOpenID('www.youdomen.ru');
    if(!$openid->mode) 
    {
        if(isset($_GET['login'])) 
        {
            $openid->identity = 'http://steamcommunity.com/openid/?l=english'; 
            header('Location: ' . $openid->authUrl());
        }
?>
<form action="?login" method="post" target="_blank">
    <input class="steam_auth_button" src="../../images/steam_login_green.png" height="42px" type="image" border="0px">
</form>
<?php
    } 
    elseif($openid->mode == 'cancel') 
    {
        echo 'User has canceled authentication!';
    } 
    else 
    {
        if($openid->validate()) 
        {
                $id = $openid->identity;
                // identity is something like: http://steamcommunity.com/openid/id/76561197960435530
                // we only care about the unique account ID at the end of the URL.
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
 
                $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$_STEAMAPI&steamids=$matches[1]";
                $json_object= file_get_contents($url);
                $json_decoded = json_decode($json_object);
 
                foreach ($json_decoded->response->players as $player)
                	{	
						$short_avatar = substr($player->avatar, 69, -4);
						$nickname = addslashes($player->personaname);
						// проверяем на наличие в БД
						$sql = mysql_query("SELECT num 
											FROM users 
											WHERE steamid = '$player->steamid'");
						if (mysql_num_rows($sql) == 0) {
							// Заносим в БД
							$query = "INSERT 
									INTO users 
									(personaname,steamid,avatar) 
									VALUES 	
									('$nickname','$player->steamid','$short_avatar')";
									$result = mysql_query($query);
						} else {
							// Перезаписываем данные в БД
							$query = "UPDATE users 
									SET personaname = '$nickname', avatar = '$short_avatar'  
									WHERE steamid = '$player->steamid'";
									$result = mysql_query($query);
							}
						// Создание сессионных файлов
						$_SESSION["nikname"] = $nickname;
						$_SESSION["avatar"] = $player->avatar;
						$_SESSION["steamid"] = $player->steamid;
						$_SESSION["fullavatar"] = $player->avatarfull;
						header('Location: start_page.php');
                }
 
        } 
        else 
        {
                echo "User is not logged in.\n";
        }
    }
} 
catch(ErrorException $e) 
{
    echo $e->getMessage();
}
?>

