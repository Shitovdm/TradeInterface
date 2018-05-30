<?php
session_start();
// Проверка пользователя.
if(!isset($_SESSION['steamid'])){
	header('Location: /index.php?page=access_denied.php');
}else{
	$steamid = $_SESSION['steamid'];
}
require_once("service/dbconnect.php");

$select_data = mysql_query("SELECT * FROM real_bought_items_STtoTM WHERE user_steamid='$steamid'");

$sell_price_0_1=0;
$sell_price_1_50=0;
$sell_price_50_250=0;
$sell_price_250_1000=0;
$sell_price_1000_5000=0;
$sell_price_5000_inf=0;

$buy_price_0_1=0;
$buy_price_1_50=0;
$buy_price_50_250=0;
$buy_price_250_1000=0;
$buy_price_1000_5000=0;
$buy_price_5000_inf=0;

$i=0;
while ($row = mysql_fetch_assoc($select_data)) {	
	$market_hash_name[$i] = $row['market_hash_name'];
	$buy_price_steam[$i] =$row['buy_price_steam'];
	$sell_price_tm[$i] =$row['sell_price_tm'];
	if($sell_price_tm[$i] == 0){ // Если предмет еще не продан.
		$not_sell_items_amount++;
		$not_sell_items_summ += $buy_price_steam[$i];
		$not_sell_items_share;
	}else{// Уже проданные предметы.
		$already_sold_items_amount++;
		$already_sold_items_buy_summ += $buy_price_steam[$i];
		$already_sold_items_sell_summ += $sell_price_tm[$i];
	}
	
	$spent_amount += $buy_price_steam[$i];
	$received_amount += $sell_price_tm[$i];
	 
	// Для графиков.
	$sell_price[$i] = $sell_price_tm[$i];
	$buy_price[$i] = $buy_price_steam[$i];
	if((int)$sell_price[$i] <= 1){$sell_price_0_1++;}
	if(((int)$sell_price[$i] > 1) && ((int)$sell_price[$i] <= 50)){$sell_price_1_50++;}
	if(((int)$sell_price[$i] > 50) && ((int)$sell_price[$i] <= 250)){$sell_price_50_250++;}
	if(((int)$sell_price[$i] > 250) && ((int)$sell_price[$i] < 1000)){$sell_price_250_1000++;}
	if(((int)$sell_price[$i] > 1000) && ((int)$sell_price[$i] < 5000)){$sell_price_1000_5000++;}
	if((int)$sell_price[$i] >= 5000){(int)$sell_price_1000_inf++;}
	//Продажа.
	if((int)$buy_price[$i] <= 1){$buy_price_0_1++;}
	if(((int)$buy_price[$i] > 1) && ((int)$buy_price[$i] <= 50)){$buy_price_1_50++;}
	if(((int)$buy_price[$i] > 50) && ((int)$buy_price[$i] <= 250)){$buy_price_50_250++;}
	if(((int)$buy_price[$i] > 250) && ((int)$buy_price[$i] < 1000)){$buy_price_250_1000++;}
	if(((int)$buy_price[$i] > 1000) && ((int)$buy_price[$i] < 5000)){$buy_price_1000_5000++;}
	if((int)$buy_price[$i] >= 5000){(int)$buy_price_1000_inf++;}
	
	$i++;
}

//Процент для уже переработаннх предметов.
$already_sold_full_percent = number_format( (($already_sold_items_sell_summ*100)/$already_sold_items_buy_summ)-100 , 2, '.', '');

$full_percent = number_format( (($received_amount*100)/$spent_amount)-100 , 2, '.', '');
$loss = $received_amount - $spent_amount;
for($i=0;$i<count($market_hash_name);$i++){
	$share[$i] = number_format( (($buy_price_steam[$i] * 100)/$spent_amount) , 2, '.', '');
}
?>
<div class="main">
    <div class="statistics_table edit_statistics_table scroll-table" id="main_table">
        <table class="simple-little-table simple-little-table-statistic scroll-load-content" id="append-content-table">
            <tr>
                <th>#</th>
                <th>Market hash name</th>
                <th>Buy price, rub</th>
                <th>Sell price, rub</th>
                <th>Difference, rub</th>
                <th>Percent, %</th>
                <th>Share, %</th>
            </tr>
            <tr>
            	<td class="no-edit" style="padding:0px;"><img class="no-edit" style="margin-left:10px; cursor:pointer;" onClick="saveItem_inDB()" src="../../images/icons/add_button.png" width="32px;"></td>
                <td class="no-edit"><input id="market_hash_name" type="text" placeholder="M4A4 | Radiation Hazard(Well-Worn)" name="market_hash_name" width="300px"></td>
                <td class="no-edit"><input id="buy_price_steam" type="text" placeholder="00.00" name="buy_price_steam"></td>
                <td class="no-edit"><input id="sell_price_tm" type="text" placeholder="00.00" name="sell_price_tm"></td>
                <td class="no-edit" colspan="3">
                	<input type="button" value="FN" name="Factory New" title="Factory New/Прямо с завода" onClick="add_quality(this.name)">
                    <input type="button" value="WW" name="Well-Worn" title="Well-Worn/Поношеное" onClick="add_quality(this.name)">
                    <input type="button" value="BS" name="Battle-Scarred" title="Battle-Scarred/Закаленное в боях" onClick="add_quality(this.name)">
                    <input type="button" value="MW" name="Minimal Wear" title="Minimal Wear/Немного поношеное" onClick="add_quality(this.name)">
                    <input type="button" value="FT" name="Field-Tested" title="Field-Tested/После полевых испытаний" onClick="add_quality(this.name)">
                </td>
            </tr>
        <?php
			for($i=count($market_hash_name)-1;$i>=(count($market_hash_name)-20);$i--){
				if($sell_price_tm[$i] == 0){ 
					$null_value = "null-value"; 
				}else{ 
					$null_value = "";
				}
				echo("<tr><td class='no-edit calculate-selector' id='row-".($i+1)."' onClick='select_row(this.id)'>" . ($i + 1) . "</td>");
				echo("<td class='no-edit' id='name-".($i+1)."'>".$market_hash_name[$i]."</td>");
				echo("<td class='buy-price-steam-class' num=" . ($i+1) . "  operation ='buy_price_steam'>".$buy_price_steam[$i]."</td>");
				echo("<td class='sell-price-tm-class ".$null_value."' num=" . ($i+1) . "  operation ='sell_price_tm'>".$sell_price_tm[$i]."</td>");
				echo("<td class='no-edit' id='diff-".($i+1)."'>".($sell_price_tm[$i] - $buy_price_steam[$i])."</td>");
				echo("<td class='no-edit' id='percent-".($i+1)."'>".number_format(((($sell_price_tm[$i]*100)/$buy_price_steam[$i])-100), 2, '.', '')."</td>");
				echo("<td class='no-edit' id='share-".($i+1)."'>".$share[$i]."</td></tr>");
			}
        ?>
        </table>
    </div>
    
    <div style="min-height:0px" class="statistics_table ST-TM_stat" id="stat_table">
        <table class="simple-little-table simple-little-table-statistic ST-TM-stat-table">
            <tr>
                <th>Amount</th>
                <th>Spent amount, rub</th>
                <th>Received amount, rub</th>
                <th>Difference, rub</th>
                <th>Full percent, %</th>  
            </tr>
            
        <?php
			echo("<tr><td class='no-edit' id='items_amount'>".count($market_hash_name)."</td>");
			echo("<td class='no-edit' id='spent_amount'>".$spent_amount."</td>");
			echo("<td class='no-edit' id='received_amount'>".$received_amount."</td>");
			echo("<td class='no-edit' id='loss'>".$loss."</td>");
			echo("<td class='no-edit' id='full_percent'>".$full_percent."</td>");
        ?>
        </table>
    </div>

    <div style="min-height:0px" class="statistics_table ST-TM_stat">
        <table class="simple-little-table simple-little-table-statistic ST-TM-stat-table">
            <tr>
                <th>Amount</th>
                <th>Spent amount, rub</th>
                <th>Received amount, rub</th>
                <th>Difference, rub</th>
                <th>Full percent, %</th>  
            </tr>
            <tr>
            	<td class='no-edit' id="selected-amount">0</td>
                <td class='no-edit' id="selected-spent">0</td>
                <td class='no-edit' id="selected-received">0</td>
                <td class='no-edit' id="selected-difference">0</td>
                <td class='no-edit' id="selected-percent">0</td>
            </tr>
        </table>
    </div>
    
	
    
	<div class="profile_tradeData profile_statistics ST-TM_stat">
        <div id="gistogram_stat" style="width: 100%; height:300px;"></div>
    </div>

    <div style="min-height:0px;margin-top:8px;" class="statistics_table ST-TM_stat">
        <table title="Forecast" class="simple-little-table simple-little-table-statistic ST-TM-stat-table">
            <tr>
                <th title="Amount of not sold items.">Amount</th>
                <th title="Summ of not sold items.">Spent, rub</th>
                <th title="Percent of all purchased itrms.">Share, %</th>
                <th>Possible received, rub</th>
                <th>Possible received, %</th>  
            </tr>
            
        <?php
			echo("<tr><td class='no-edit' id='forecast-amount'>".$not_sell_items_amount."</td>");
			echo("<td class='no-edit' id='forecast-summ'>".$not_sell_items_summ."</td>");
			echo("<td class='no-edit' id='forecast-share'>".number_format((($not_sell_items_summ*100)/$spent_amount), 2, '.', '')."</td>");
			echo("<td class='no-edit' id='forecast-pos-profit'>".number_format(($not_sell_items_summ*0.85), 2, '.', '')."</td>");
			echo("<td class='no-edit' id='forecast-unknown'>-15</td>");
        ?>
        	<tr>
            	<td class='no-edit' id="forecast-1" colspan="5">Possible after the sale of all things not sold:</td>
            </tr>
            <tr>
            	<td class='no-edit' id="forecast-2" colspan="1" title="Possible spent amount."><?php echo($spent_amount); ?></td>
                <td class='no-edit' id="forecast-3" colspan="1" title="Possible received amount."><?php echo(number_format($received_amount + ($not_sell_items_summ*0.85), 2, '.', '')); ?></td>
                <td class='no-edit' id="forecast-4" colspan="1" title="Possible difference."><?php echo($spent_amount-number_format($received_amount + ($not_sell_items_summ*0.85), 2, '.', '')); ?></td>
                <td class='no-edit' id="forecast-5" colspan="1" title="Possible full percent."><?php echo(number_format( ((($received_amount + ($not_sell_items_summ*0.85))*100)/$spent_amount)-100 , 2, '.', '')); ?></td>
                <td class='no-edit' id="forecast-2" colspan="1" title="Already sold items."><?php echo($already_sold_full_percent); ?></td>
            </tr>
        </table>
        
    </div>
</div>
<script>
$(document).ready(function(){
	edit_value_cells();
});
// Редактирует значение ячейки.
function edit_value_cells(){
	$('td').click(function(e){
		//ловим элемент, по которому кликнули
		var t = e.target || e.srcElement;
		//получаем название тега
		var block_id = t.id;
		var elm_name = t.tagName.toLowerCase();
		console.log(elm_name);
		//если это инпут или спец. класс - ничего не делаем
		if(elm_name == 'input' || $('#'+block_id).hasClass('no-edit')){
			return false;
		}
		var old_value = $(this).html();
		var val = $(this).html();
		var code = '<input type="text" id="edit" value="'+val+'" />';
		$(this).empty().append(code);
		$('#edit').focus();
		$('#edit').blur(function(){
			// Пересчет общих значений статистики.
			reCalculate($(this).val(),$(this).parent(),old_value);
			saveInformation($(this).val(),$(this).parent());
			var val = $(this).val();
			$(this).parent().empty().html(val);
		});
	});
}

// Подгрузка записей при прокрутке.
//запуск функции при прокрутке
$(".scroll-table").on("scroll", scrolling);
var amount_items = <?php echo(count($market_hash_name));?>;
var lower_limit = 20;
function scrolling(){
	if(amount_items > lower_limit){
		var currentHeight = $(this).children(".scroll-load-content").height();
		if($(this).scrollTop() >= (currentHeight - $(this).height()-100)){
			$(this).unbind("scroll");
			loader();
		}
	}
	
}
function loader(){         
	$.ajax({
		type:"POST",
		url:"pages/statistic/Steam_to_TM/loading_records.php",
		data:{ lower_limit: lower_limit},
		success:function(data){
			//alert(data);
			document.getElementById('append-content-table').innerHTML += data;
			$(".scroll-table").on("scroll", scrolling);
			lower_limit += 20;
			edit_value_cells();
		}
	});
}

// Format a number with grouped thousands.
function number_format( number, decimals, dec_point, thousands_sep ){	
	// 
	// +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// +	 bugfix by: Michael White (http://crestidg.com)
	var i, j, kw, kd, km;
	// input sanitation & defaults
	if( isNaN(decimals = Math.abs(decimals)) ){decimals = 2;}
	if( dec_point == undefined ){ dec_point = ",";}
	if( thousands_sep == undefined ){ thousands_sep = ".";}
	i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
	if( (j = i.length) > 3 ){ j = j % 3;} else{ j = 0;}
	km = (j ? i.substr(0, j) + thousands_sep : "");
	kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
	//kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
	kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


	return km + kw + kd;
}
// Выбирает выбранную строку и считает цены.
var buyPriceSumm = 0;
var sellPriceSumm = 0;
var amountSelected = 0;
function select_row(id){
	var parent = $('#'+id).parent('tr');
	if(!parent.hasClass('selected-row')){
		//$('#'+id).addClass('selected-row');
		parent.addClass('selected-row');
		// Считаем суммы цен.
		amountSelected++;
		buyPriceSumm += Number(parent.children('.buy-price-steam-class').html());
		sellPriceSumm += Number(parent.children('.sell-price-tm-class').html());
	}else{
		amountSelected--;
		//parent.removeClass('selected-row');
		parent.removeAttr('class');
		buyPriceSumm -= Number(parent.children('.buy-price-steam-class').html());
		sellPriceSumm -= Number(parent.children('.sell-price-tm-class').html());
	}
	// Пушим в таблицу.
	var format_buyPriceSumm = number_format(buyPriceSumm, 2, '.', '');
	var format_sellPriceSumm = number_format(sellPriceSumm, 2, '.', '');
	$('#selected-amount').html(amountSelected);
	$('#selected-spent').html(format_buyPriceSumm);
	$('#selected-received').html(format_sellPriceSumm);
	$('#selected-difference').html(number_format((format_buyPriceSumm - format_sellPriceSumm), 2, '.', ''));
	$('#selected-percent').html(number_format((((format_sellPriceSumm * 100)/format_buyPriceSumm) - 100), 2, '.', ''));
}

// Вставляет в поле ввода market_hash_name выбранное качество.
function add_quality(name){
	var tmp = $('#market_hash_name').val();
	$('#market_hash_name').val(tmp + "(" + name + ")") ;
}
// Добавляет значение в БД.
function saveItem_inDB(){
	var market_hash_name = document.getElementById("market_hash_name").value;
	var buy_price_steam = document.getElementById("buy_price_steam").value;
	var sell_price_tm = document.getElementById("sell_price_tm").value;
	$.ajax({
        url: 'pages/search/steam_to_tm/stat_place_boughtItems.php', 
        cache: false,
        type:'POST',
        dataType: 'json',
		data: {tmarket_hash_name: market_hash_name, tbuy_price_steam: buy_price_steam, tsell_price_tm: sell_price_tm},
		success: function(responce){
			// обновляем таблицу.
			console.log("refresh");
			document.getElementById('main_table').innerHTML = responce.result_table;
			document.getElementById('stat_table').innerHTML = responce.stat_table;	
			buyPriceSumm = 0;
			sellPriceSumm = 0;
			amountSelected = 0;
			$('#selected-amount').html("0");
			$('#selected-spent').html("0");
			$('#selected-received').html("0");
			$('#selected-difference').html("0");
			$('#selected-percent').html("0");
		}
    });
}

// Сохраняет измененное значение в базу данных.
function saveInformation(val,cell){
	$.ajax({
        url: 'pages/search/steam_to_tm/stat_paste_info.php', 
        cache: false,
        type:'POST',
        dataType: 'json',
		data: {value: val, operation: cell.attr("operation"), num: cell.attr("num")}
    });
}
// Функция пересчета общей выгоды. val - измененное значение, cell - измененная ячейка.
function reCalculate(new_val,cell,old_val){
	var received = Number($("#received_amount").text());// Получено при продаже(старое значение).
	var spent = Number($("#spent_amount").text());// Потрачено при покупке(старое значение).
	if(cell.attr("operation") == "buy_price_steam"){
		spent = (spent - Number(old_val)) + Number(new_val);
		$("#spent_amount").text(number_format(spent, 2, '.', ''));
	}else if(cell.attr("operation") == "sell_price_tm"){
		received = (received - Number(old_val)) + Number(new_val);
		$("#received_amount").text(number_format(received, 2, '.', ''));
	}
	var difference = (received - spent);
	var percent = ((received * 100)/spent) - 100;
	$("#loss").text(number_format(difference, 2, '.', ''));
	$("#full_percent").text(number_format(percent, 2, '.', ''));
}

</script>
<script src="https://www.google.com/jsapi"></script>
<script>
   google.load("visualization", "1", {packages:["corechart"]});
   google.setOnLoadCallback(drawChart);
   function drawChart() {
    var data = google.visualization.arrayToDataTable([
	   ['Item Price', 'Buying', 'Selling'],
	   ['<1 rub', <?php echo($sell_price_0_1); ?>, <?php echo($buy_price_0_1); ?>],
	   ['1-50 rub', <?php echo($sell_price_1_50); ?>, <?php echo($buy_price_1_50); ?>],
	   ['50-250 rub', <?php echo($sell_price_50_250); ?>, <?php echo($buy_price_50_250); ?>],
	   ['250-1000 rub', <?php echo($sell_price_250_1000); ?>, <?php echo($buy_price_250_1000); ?>],
	   ['1000-5000 rub', <?php echo($sell_price_1000_5000); ?>, <?php echo($buy_price_1000_5000); ?>],
	   ['5000< rub', <?php echo($sell_price_5000_inf); ?>, <?php echo($buy_price_5000_inf); ?>],
    ]);
    var options = {
     title: 'Items amount',
     hAxis: {title: 'Price'},
     vAxis: {title: 'Amount'}
    };
    var chart = new google.visualization.ColumnChart(document.getElementById('gistogram_stat'));
    chart.draw(data, options);
   }
</script>