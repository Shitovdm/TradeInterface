<?php
require_once("../../service/dbconnect.php");
session_start();
$steamid = $_SESSION['steamid'];
// Проверяем на наличие данных.

$market_hash_name_POST = $_POST['tmarket_hash_name'];
$buy_price_steam_POST = $_POST['tbuy_price_steam'];
$sell_price_tm_POST = $_POST['tsell_price_tm'];
$timestamp = date("Y-m-d H:i:s");
$query = "INSERT 
		  INTO real_bought_items_STtoTM 
		  (market_hash_name, buy_price_steam, sell_price_tm, user_steamid, timestamp) 
		  VALUES 	
		  ('$market_hash_name_POST', '$buy_price_steam_POST' , '$sell_price_tm_POST' , '$steamid' , '$timestamp')";
$result = mysql_query($query);

$result_table = "<table class='simple-little-table simple-little-table-statistic'><tr><th>#</th><th>Market hash name</th><th>Buy price, rub</th><th>Sell price, rub</th><th>Difference, rub</th><th>Percent, %</th><th>Share, %</th></tr>";

$result_table .= "<tr><td class='no-edit' style='padding:0px;'><img class='no-edit' style='margin-left:10px; cursor:pointer;' onClick='saveItem_inDB()' src='../../images/icons/add_button.png' width='32px;'></td><td class='no-edit'><input id='market_hash_name' type='text' placeholder='M4A4 | Radiation Hazard(Well-Worn)' name='market_hash_name' width='300px'></td><td class='no-edit'><input id='buy_price_steam' type='text' placeholder='00.00' name='buy_price_steam'></td><td class='no-edit'><input id='sell_price_tm' type='text' placeholder='00.00' name='sell_price_tm'></td><td class='no-edit' colspan='3'><input type='button' value='FN' name='Factory New' title='Factory New' onClick='add_quality(this.name)'><input type='button' value='WW' name='Well-Worn' title='Well-Worn' onClick='add_quality(this.name)'><input type='button' value='BS' name='Battle-Scarred' title='Battle-Scarred' onClick='add_quality(this.name)'><input type='button' value='MW' name='Minimal Wear' title='Minimal Wear' onClick='add_quality(this.name)'><input type='button' value='FT' name='Field-Tested' title='Field-Tested' onClick='add_quality(this.name)'></td></tr>";

// Основную таблицу.
$select_data = mysql_query("SELECT * FROM real_bought_items_STtoTM WHERE user_steamid='$steamid'");
$i=0;
while ($row = mysql_fetch_assoc($select_data)) {	
	$market_hash_name[$i] = $row['market_hash_name'];
	$buy_price_steam[$i] =$row['buy_price_steam'];
	$sell_price_tm[$i] =$row['sell_price_tm'];

	$spent_amount += $buy_price_steam[$i];
	$received_amount += $sell_price_tm[$i];
	 
	$i++;
}
$full_percent = number_format( (($received_amount*100)/$spent_amount)-100 , 2, '.', '');
$loss = $received_amount - $spent_amount;
for($i=0;$i<count($market_hash_name);$i++){
	$share[$i] = number_format( (($buy_price_steam[$i] * 100)/$spent_amount) , 2, '.', '');
}
for($i=count($market_hash_name)-1;$i>=0;$i--){
	if($sell_price_tm[$i] == 0){ $null_value = "null-value"; }else{ $null_value = "";}
	$result_table .= "<tr><td class='no-edit calculate-selector' id='row-".($i+1)."' onClick='select_row(this.id)'>" . ($i+1) . "</td>";
	$result_table .= "<td class='no-edit' id='name-".($i+1)."'>".$market_hash_name[$i]."</td>";
	$result_table .= "<td class='buy-price-steam-class' num=" . ($i+1) . "  operation ='buy_price_steam'>".$buy_price_steam[$i]."</td>";
	$result_table .= "<td class='sell-price-tm-class ".$null_value."' num=" . ($i+1) . "  operation ='sell_price_tm'>".$sell_price_tm[$i]."</td>";
	$result_table .= "<td class='no-edit' id='diff-".($i+1)."'>".($sell_price_tm[$i] - $buy_price_steam[$i])."</td>";
	$result_table .= "<td class='no-edit' id='percent-".($i+1)."'>".number_format(((($sell_price_tm[$i]*100)/$buy_price_steam[$i])-100), 2, '.', '')."</td>";
	$result_table .= "<td class='no-edit' id='share-".($i+1)."'>".$share[$i]."</td></tr>";
}	
$result_table .= "</table>";

// Сводную таблицу.
$stat_table = "<table class='simple-little-table simple-little-table-statistic ST-TM-stat-table'><tr><th>Amount</th><th>Spent amount, rub</th><th>Received amount, rub</th><th>Difference, rub</th><th>Full percent, %</th></tr>";
$stat_table .= "<tr><td class='no-edit'>".count($market_hash_name)."</td>";
$stat_table .= "<td class='no-edit' id='spent_amount'>".$spent_amount."</td>";
$stat_table .= "<td class='no-edit' id='received_amount'>".$received_amount."</td>";
$stat_table .= "<td class='no-edit' id='loss'>".$loss."</td>";
$stat_table .= "<td class='no-edit' id='full_percent'>".$full_percent."</td>";
$stat_table .= "</table>";

$response = array(
	'result_table' => $result_table,
	'stat_table' => $stat_table
);

echo(json_encode($response));
?>