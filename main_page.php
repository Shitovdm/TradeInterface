<div class="header">
<div class="navbar">
<a href="start_page.php" style="cursor:pointer;">
	<div class="header_param">
    	<img src="images/image.png" width="48px" height="48px">
    </div>
    <div class="header_param">
        <li style="cursor:pointer;">Trade Interface</li>
    </div>
</a>
    <a href="/index.php?page=pages/search_TMtoSteam.php">
    <div class="header_param header_hover <?php if($page == 'pages/search_TMtoSteam.php'){echo("active_tab");}?>" id="navbar_search"  onClick="navbar('<?php echo($page);?>')">
        <li>TM &#8658; Steam</li>
    </div></a>
    
    <a href="/index.php?page=pages/search_steamToTM (orders).php">
    <div class="header_param header_hover <?php if($page == 'pages/search_steamToTM (orders).php'){echo("active_tab");}?>" id="navbar_search"  onClick="navbar('<?php echo($page);?>')">
        <li>Steam &#8658; TM (orders)</li>
    </div></a>
    
    <a href="/index.php?page=pages/search_steamToTM (sell).php">
    <div class="header_param header_hover <?php if($page == 'pages/search_steamToTM (sell).php'){echo("active_tab");}?>" id="navbar_search"  onClick="navbar('<?php echo($page);?>')">
        <li>Steam &#8658; TM (sell)</li>
    </div></a>
    
    
    <a href="/index.php?page=pages/item_info_TMtoST.php">
    <div class="header_param header_hover <?php if($page == 'pages/item_info_TMtoST.php'){echo("active_tab");}?>" id="navbar_contacts"  onClick="navbar('<?php echo($page);?>')">
    	<li>Item's TM&#8658;ST</li>
    </div></a>
    
    <a href="/index.php?page=pages/item_info_STtoTM.php">
    <div class="header_param header_hover <?php if($page == 'pages/item_info_STtoTM.php'){echo("active_tab");}?>" id="navbar_contacts"  onClick="navbar('<?php echo($page);?>')">
    	<li>Item's ST&#8658;TM</li>
    </div></a>
    
    <div class="login">
		<?php		
			session_start();	
			if(isset($_SESSION["steamid"])){
				include('pages/header_profile.php');
			}else{
				include('pages/other/steam_auth.php');
			}
        ?>
	</div>
</div>
	
</div>
<div class="main">
<?php
	include ($page);
?>
</div>
<div class="clear"></div>
<div class="footer">
	<div class="exit_ss">
		<?php 
			if($_SESSION["priority_access"] == "full_access"){
				echo("<img src='images/icons/admin.png' width='32px' height='32px' alt='Icon'>");
			}else{
				echo("<img src='images/icons/user.png' width='32px' height='32px' alt='Icon'>");
			}
			echo("<b>" . $_SESSION["username_login"] . "</b>");
        ?>
        
    	<a href='?exit=1'>Log out</a>
    </div>
	<div class="header_param">
    	<img src="images/image.png" width="48px" height="48px">
    </div>
</div>
