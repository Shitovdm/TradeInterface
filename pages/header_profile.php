<?php
    session_start();
?>
<div id="header_profile">
    <div class="header_profile_atr" id="header_profile_nikname">
        <span><?php echo $_SESSION["nikname"]; ?></span>
    </div>
    <div class="header_profile_atr" id="header_profile_photo">
        <?php echo "<img src='https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/" . $_SESSION["avatar"] . "'>"; ?>
    </div>

    <div class="header_profile_atr" id="show_paramList" onClick="showList()">
        <img src="images/icons/head_arrow.png">
    </div>

    <div id="header_profile_paramList">
        <ul>
            <a href="/index.php?page=pages/profile.php"><li>My profile</li></a>
            <hr align="center" size="1" width="80%" color="#ccc" />
            <li id="header_profile_paramList_settings" onClick="$('#profile_header_settings').toggle();">Settings</li>
            <li>Help</li>
            <hr align="center" size="1" width="80%" color="#ccc" />
            <a href='?is_exit=1'><li>Log out</li></a>
        </ul>
    </div>
</div>
<?php
    if (isset($_GET["is_exit"])) {
        if ($_GET["is_exit"] == 1) {
            //Удаляем данные, созданные при авторизации через стим.
            unset($_SESSION["nikname"]);
            unset($_SESSION["avatar"]);
            unset($_SESSION["steamid"]);
            unset($_SESSION["fullavatar"]);
            header("Location: ?is_exit=0"); //Редирект послае выхода;
        }
    }
?>

