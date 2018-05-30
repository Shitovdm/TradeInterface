<?php
/*
*	На этой странице пользователь может посмотреть
*	инвентарь других пользователей торговой площадки Steam
*	https://steamcommunity.com/profiles/76561198269415170/inventory/json/730/2/
*/
if(!isset($_SESSION['steamid'])){
	header('Location: access_denied.php');
}
$user_data = array(
	'mckimley' => '76561198269415170',
	'alfa09' => '76561198314610066',
	'Sia\'guess' => '76561198265124937'
);

$i=0;
foreach($user_data as $element => $value){
	$user_nickname[$i] = $element;
	$user_steamID[$i] = $value;
	$i++;
}
?>

<div>
	<table id="user_inventory_result_table">
		<?php
			for($j=0;$j<count($user_data);$j++){
				echo('<tr><td>');
				echo('<div class="profile_cash_update central" onClick="user_inventory_updateORdownload(' . $user_steamID[$j] . ')"><kbd>&#8634;</kbd></div>');
				echo('<b>' . $user_nickname[$j] . '</b></br>');
				echo('<a href="http://steamcommunity.com/profiles/' .$user_steamID[$j]  . '">' . $user_steamID[$j] . '</a>');
				echo('</td><td id="download_inventory_content'. $user_steamID[$j] .'"><b>Please, click update button.</b></td></tr>');	
			}		
        ?>
	</table>
</div>
<script>
//Функция подгрузки инвентарей пользователей. steamID- стим id пользователя, чей инвентарь загружаем.
function user_inventory_updateORdownload(steamID){
	$.ajax({
		url: 'pages/user_inventory/download_data.php', 
		cache: false,
		type:'POST',
		dataType: 'json',
		data: {'tsteamID':steamID},
		success: function(response){
			document.getElementById('download_inventory_content'+steamID).innerHTML = response;
		}
	});
}
</script>