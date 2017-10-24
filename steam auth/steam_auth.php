<?php	
session_start();
require_once("db.php");// Коннект к БД
require 'lightopenid/openid.php';
$_STEAMAPI = "";// Стим API ID
try 
{
    $openid = new LightOpenID('/*site address*/');
    if(!$openid->mode) 
    {
        if(isset($_GET['login'])) 
        {
            $openid->identity = 'http://steamcommunity.com/openid/?l=english'; 
            header('Location: ' . $openid->authUrl());
        }
?>
<form action="?login" method="post" target="_blank">
    <input class="steam_auth_button" src="steam_login_green.png" height="42px" type="image" border="0px">
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
											FROM /*DB name*/  
											WHERE steamid = '$player->steamid'");
						if (mysql_num_rows($sql) == 0) {
							// Заносим в БД
							$query = "INSERT 
									INTO /*DB name*/ 
									(personaname,steamid,avatar) 
									VALUES 	
									('$nickname','$player->steamid','$short_avatar')";
									$result = mysql_query($query);
						} else {
							// Перезаписываем данные в БД
							$query = "UPDATE /*DB name*/ 
									SET personaname = '$nickname', avatar = '$short_avatar'  
									WHERE steamid = '$player->steamid'";
									$result = mysql_query($query);
							}
						// Создание сессионных файлов
						$_SESSION["nikname"] = $nickname;
						$_SESSION["avatar"] = $player->avatar;
						$_SESSION["steamid"] = $player->steamid;
						$_SESSION["fullavatar"] = $player->avatarfull;
						header('Location: /index.php?page=start_page.php');
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

