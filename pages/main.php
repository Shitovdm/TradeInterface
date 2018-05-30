
<?php
function getprice_tm($input_str){
$preg_item_price = preg_match_all(("/(\"min_price\":\")[0-9]{1,}/"),(string)$input_str, $item_price_array);
	for ($i = 0; $i < $preg_item_price; $i++){
		$price = substr((string)$item_price_array[0][$i], 13);
	}
	return $price;
}
function getprice_steam($input_str){
	$preg_item_price_st = preg_match_all(("/(\"lowest_price\":\")[0-9,]{1,}(\s)/"),(string)$input_str, $item_price_st_array);
	for ($i = 0; $i < $preg_item_price_st; $i++){
		$price_st = substr((string)$item_price_st_array[0][$i], 16);
	}
	return $price_st;
}
function getmarckethashname($input_str){
	$preg_items_name = preg_match_all(("/(\"market_hash_name\":\")[\\\\+A-Za-z0-9\s-_|()]{3,}(\")/"),(string)$input_str, $items_name_array);
	for ($i = 0; $i < $preg_items_name; $i++){
		$hash_name = substr(substr((string)$items_name_array[0][$i], 20), 0, -1);
	}
	return $hash_name;
}
function getname($input_str){
	$preg_items_name = preg_match_all(("/[\\\\+A-Za-z0-9\s-_|]{3,}(\()/"),(string)$input_str, $items_name_array);
	for ($i = 0; $i < $preg_items_name; $i++){
		$hash_name = substr((string)$items_name_array[0][$i],0 , -1);
	}
	return $hash_name;
}
function getquality($input_str){
	$preg_items_name = preg_match_all(("/(\()[\\\\+A-Za-z0-9\s-_|]{3,}(\))/"),(string)$input_str, $items_name_array);
	for ($i = 0; $i < $preg_items_name; $i++){
		$hash_name = substr(substr((string)$items_name_array[0][$i], 1), 0, -1);
	}
	return $hash_name;
}

$secret_key1 = "************";
$secret_key2 = "**************";


include('pages/ids.php');

?>
<div class="result">
<table id="result_table">
	<tr>
    	<th></th>
        <th>Img:</th>
    	<th>Name:</th>
        <th>Quality:</th>
        <th>csgo.Tm:</th>
        <th>Steam:</th>
        <th>Profit [%]:</th>
        <th>Profit [rub]:</th>
        <th>Steam link:</th>
        <th>csgo.Tm link:</th>
        <th>Buy in TM:</th>
        <th>Update:</th>
    </tr>
<?php
for($j = 0; $j < count($ids); $j++){
		$link_tm[$j] = "https://csgo.tm/item/" . $ids[$j];
}
//---------------------------------------Working with csgoTM cUrl-------------------------------------------------//	
for($i = 0; $i < count($ids);	$i = $i+8){
	for($j = 0; $j < count($ids); $j++){
		$ids[$j] = str_replace("-", "_", $ids[$j]);	
	}
	//Цикл для формирования запросов cURl
	for($n = 0; $n < 8;	$n++){
		if(($i + $n) % 2 == 0){$secret_key = $secret_key1;}
		else{$secret_key = $secret_key2;}
		
		/*if(($i + $n) % 2 == 0){
			$proxy = '176.97.190.63:8080';	
		}else{
			$proxy = '87.242.77.197:8080';}*/
		
		$url = "https://csgo.tm/api/ItemInfo/". $ids[$i + $n] ."/ru/?key=" . $secret_key;
		$ch[$i + $n] = curl_init($url);
		//curl_setopt($ch[$i + $n], CURLOPT_PROXY, $proxy);
		curl_setopt($ch[$i + $n], CURLOPT_HEADER, false);
		curl_setopt($ch[$i + $n], CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch[$i + $n], CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');	
	}
	$mh = curl_multi_init();
	for($n = 0; $n < 8;	$n++){
		curl_multi_add_handle($mh,$ch[$i + $n]);
	}
	$running = null;
  	do {
    	curl_multi_exec($mh, $running);
  	} while ($running);
	for($n = 0; $n < 8;	$n++){
		curl_multi_remove_handle($mh, $ch[$i + $n]);
	}
	curl_multi_close($mh);
	
	for($n = 0; $n < 8;	$n++){
		$market_hash_name[$i + $n] = str_replace(" ", "%20", getmarckethashname(curl_multi_getcontent($ch[$i + $n])));
		$price_tm[$i + $n] = (getprice_tm(curl_multi_getcontent($ch[$i + $n]))/100);
	}
	usleep(500000);
}
//---------------------------------------Working with STEAM cUrl-------------------------------------------------//	
for($i = 0; $i < count($ids); $i++){
	$url = "http://steamcommunity.com/market/priceoverview/?country=RU&currency=5&appid=730&market_hash_name=" . $market_hash_name[$i];
	$ch[$i] = curl_init($url);
	
	curl_setopt($ch[$i], CURLOPT_HEADER, false);
	curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch[$i], CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
}
$mh = curl_multi_init();
	
for($i = 0; $i < count($ids); $i++){
	curl_multi_add_handle($mh,$ch[$i]);
}
	
$running = null;
do {
	curl_multi_exec($mh, $running);
} while ($running);
for($i = 0; $i < count($ids); $i++){
	curl_multi_remove_handle($mh, $ch[$i]);
}

curl_multi_close($mh);

for($i = 0; $i < count($ids); $i++){
	$price_steam[$i] = (getprice_steam(curl_multi_getcontent($ch[$i])));
}	
//---------------------------------------Processing data----------------------------------------------------------//
for($i = 0; $i < count($ids); $i++){
	$link_steam[$i] = "http://steamcommunity.com/market/listings/730/" . $market_hash_name[$i];	
	$market_hash_name[$i] = str_replace("%20", " ", $market_hash_name[$i]);	
	$market_hash_name[$i] = str_replace("\u2605", "", $market_hash_name[$i]);
	$name[$i] = getname($market_hash_name[$i]);
	$quality[$i] = getquality($market_hash_name[$i]);
	
	$price_steam[$i] = number_format($price_steam[$i], 2, '.', '');
	$price_tm[$i] = number_format($price_tm[$i], 2, '.', '');
	
	$profit_persent[$i] = ((($price_steam[$i] / 1.15) - $price_tm[$i])/($price_tm[$i] / 100));
	$profit_persent[$i] = number_format($profit_persent[$i], 2, '.', '');
	
	$profit[$i] = ($price_steam[$i] / 1.15) - $price_tm[$i];
	$profit[$i] = number_format($profit[$i], 2, '.', '');
	
	if($profit_persent[$i] == -100){$profit_persent[$i] = "None";}
	if($price_steam[$i] == 0){$price_steam[$i] = "None";}
	if($profit[$i] == -100){$profit[$i] = "None";}
	if($persent[$i] == -100){$persent[$i] = "None";}
}



for($i = 0; $i < count($ids); $i++){

	
?>
    <tr>
    	<td><?php echo $i; ?></td>
        <td><?php echo '<img src="https://cdn.csgo.com/item_' . $ids[$i] . '.png" width="32px"' ?></td>
		<td id="name<?php echo ($ids[$i]);?>"><?php echo $name[$i]; ?></td>
        <td id="float<?php echo ($ids[$i]);?>"><?php echo $quality[$i]; ?></td>
		<td id="priceTm<?php echo ($ids[$i]);?>" class="bold_line"><?php echo $price_tm[$i]; ?></td>
		<td id="priceSteam<?php echo ($ids[$i]);?>"><?php echo $price_steam[$i]; ?></td>
		<td id="profit_persent<?php echo ($ids[$i]);?>" class="red"><?php echo $profit_persent[$i]; ?></td>
        <td id="profit_rub<?php echo ($ids[$i]);?>"><?php echo $profit[$i]; ?></td>
        <td><a href="<?php echo $link_steam[$i]; ?>" target="_blank">LINK ST</a></td>
        <td><a href="<?php echo $link_tm[$i]; ?>" target="_blank">LINK TM</a></td>
        <td><div class="update" onClick="buying('<?php echo($ids[$i]);?>','<?php echo $name[$i]; ?>','<?php echo $quality[$i]; ?>','<?php echo($price_tm[$i]);?>','<?php echo $price_steam[$i]; ?>','<?php echo $profit[$i]; ?>')">BUY</div></td>
        <td><div class="update" onClick="update('<?php echo($ids[$i]);?>')">Update</div></td>
	</tr>
<?php
}
?>

</table>
<p>
	*	None - Предмет не продается на одной из ТП.
</p>
</div>
<div class="adding_form">
	<form class="input_form" name="forma" method="post" action="pages/action.php" >
		<textarea placeholder="Inter the classid_intenceid. For example: $its[3] = '937248672-188530139';" name="txt" rows=20 cols=80><?php echo htmlspecialchars(file_get_contents('pages/ids.php'), ENT_QUOTES);?></textarea>
		<input type="submit" name="otp" value="Сохранить">
	</form>
    
    <form class="input_form" name="forma1" method="post" action="pages/change.php" >
		<input type="submit" name="AK47" value="AK47">
        <input type="submit" name="M4A4" value="M4A4">
        <input type="submit" name="M4A1" value="M4A1">
        <input type="submit" name="FAMAS" value="FAMAS">
	</form>

	
</div>
<div class="clear"></div>


  <script>
	function update(id){
			var secret_key = "<?php echo $secret_key;?>";
			$.ajax({
				type: "POST",
        		url: 'pages/update.php', 
				dataType: 'json',
				data: {tid:id,tsecret_key:secret_key},
			}).done(function(response)
			{
				document.getElementById('name' + id).innerHTML = response.name;
				document.getElementById('float' + id).innerHTML = response.float;
				
				document.getElementById('priceTm' + id).innerHTML = response.priceTm;
				document.getElementById('priceSteam' + id).innerHTML = response.priceSteam;

				document.getElementById('profit_persent' + id).innerHTML = response.profit_persent;
				document.getElementById('profit_rub' + id).innerHTML = response.profit_rub;
				
				
			});
	}
	function buying(id, name, float, pricetm, priceSt, profit_rub){
			var secret_key = "<?php echo $secret_key1;?>";
			$.ajax({
				type: "POST",
        		url: 'pages/buy.php', 
				dataType: 'json',
				data: { tid:id,
						tname:name,
						tfloat:float,
						tprice_tm:pricetm,
						tprice_st:priceSt,
						tprofit_rub:profit_rub,
						tsecret_key:secret_key
						},
			}).done(function(response)
			{
				alert(response.status);
			});
	}
</script>