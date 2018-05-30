<?php
session_start();
$steamid = $_SESSION['steamid'];

require_once("../../service/dbconnect.php");
$select_data = mysql_query("SELECT * FROM real_bought_items_STtoTM WHERE user_steamid='$steamid'");

$i = 0;
while ($row = mysql_fetch_assoc($select_data)) {	
	$market_hash_name[$i] = $row['market_hash_name'];
	$buy_price_steam[$i] =$row['buy_price_steam'];
	$sell_price_tm[$i] =$row['sell_price_tm'];
	
	$spent_amount += $buy_price_steam[$i];
	$received_amount += $sell_price_tm[$i];
	$share[$i] = number_format( (($buy_price_steam[$i] * 100)/$spent_amount) , 2, '.', '');
	$i++;
}

$lower_limit = $_POST['lower_limit'];

$content = "";
for($i=(count($market_hash_name)-1-$lower_limit);$i>=(count($market_hash_name)-$lower_limit-20);$i--){
	if(isset($market_hash_name[$i])){
		if($sell_price_tm[$i] == 0){ $null_value = "null-value"; }else{ $null_value = "";}
		$content .= ("<tr><td class='no-edit calculate-selector' id='row-".($i+1)."' onClick='select_row(this.id)'>" . ($i + 1) . "</td>");
		$content .= ("<td class='no-edit' id='name-".($i+1)."'>".$market_hash_name[$i]."</td>");
		$content .= ("<td class='buy-price-steam-class' num=" . ($i+1) . "  operation ='buy_price_steam'>".$buy_price_steam[$i]."</td>");
		$content .= ("<td class='sell-price-tm-class ".$null_value."' num=" . ($i+1) . "  operation ='sell_price_tm'>".$sell_price_tm[$i]."</td>");
		$content .= ("<td class='no-edit' id='diff-".($i+1)."'>".($sell_price_tm[$i] - $buy_price_steam[$i])."</td>");
		$content .= ("<td class='no-edit' id='percent-".($i+1)."'>".number_format(((($sell_price_tm[$i]*100)/$buy_price_steam[$i])-100), 2, '.', '')."</td>");
		$content .= ("<td class='no-edit' id='share-".($i+1)."'>".$share[$i]."</td></tr>");
	}
}

echo($content);

?>