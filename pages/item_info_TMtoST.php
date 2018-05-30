<?php

// Проверка пользователя.
if(!isset($_SESSION['steamid'])){
	header('Location: index.php?page=access_denied.php');
}else{
	$steamid = $_SESSION['steamid'];
}

/*
Запрашиваем историю покупок конкретного предмета.
*/
include('service/bots_API_keys.php');
include_once("login_data.php");
$user_steamid = $steamid;
$id = "2077670040_188530139";
$url = "https://market.csgo.com/api/ItemHistory/".$id."/?key=". $bot_secret_key[15];
$inv = curl_init($url);
curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($inv, CURLOPT_HEADER, false);
curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
curl_setopt($inv, CURLOPT_TIMEOUT, 5);
$output_curl = curl_exec($inv);
curl_close($inv);

if(($content = curl_exec($ch)) !== false) {
	$data = json_decode($output_curl)->history;
	$i = 0;
	foreach( $data as $element ){
		$l_price[$i] = $element->l_price;
		$l_time[$i] = $element->l_time;
		$i++;
	}
	$json_decode_data = json_decode($output_curl);
	$number = $json_decode_data->number;
	$MIN_price = $json_decode_data->min;
	$average_price = $json_decode_data->average;
	$MAX_price = $json_decode_data->max;
}else{
	echo("<script>alert('Error! Not connection!');</script>");
}

/*Читаем БД, достаем все предметы*/
require_once("service/dbconnect.php");
$select_data = mysql_query("SELECT * FROM bought_items WHERE user_steamid='$user_steamid'");
$i=0;
while ($row = mysql_fetch_assoc($select_data)) {	
	$item_market_name[$i] = $row['market_hash_name'];
	$sell_price[$i] =$row['sell_price'];
	$buy_price[$i] =$row['buy_price'];
	$buy_date[$i] =$row['timestamp'];
	$classid_instanceid[$i] =$row['classid_instanceid'];
	$i++;
}

?>

<?php 
	for($i=0;($i<count($l_price)) && ($i<100);$i++){
		$val_array_str = $val_array_str . ("[" . $i . "," . $l_price[$i]/100 . ",'" . "P: " . $l_price[$i]/100 ." | T: ". gmdate("Y.m.d H:i:s ", $l_time[$i]) . "'],");
	}

?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawCurveTypes);
var dataArray = [<?php echo($val_array_str);?>];
console.log(dataArray) ;
function drawCurveTypes() {
	//ff
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'X');
    data.addColumn('number', 'Item');
	data.addColumn({type:'string', role:'tooltip'});

    data.addRows(dataArray);

     var options = {
     hAxis: {
          title: 'Number of the last purchased item (descending)'
     },
     vAxis: {
          title: 'Item price,rub'
     },
     series: {
          1: {curveType: 'function'}
     },
        height: 400,
		width: 1100
     };

     var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
     chart.draw(data, options);
}
</script>
<div class="statistics_table">
<table class="simple-little-table">
	<tr>
		<th>№</th>
        <th>Market hash name</th>
        <th>Buy price</th>
        <th>Sell price</th>
        <th>Date</th>
        <th>Link</th>
    </tr>
<?php
for($i=count($item_market_name)-1;$i>=0;$i--){
	//echo("<a >");
	echo("<tr class='' id='".$classid_instanceid[$i]."' onClick=\"downloadData('" .$classid_instanceid[$i]. "','" .$sell_price[$i]. "','" .$buy_price[$i]. "')\"><td>".$i."</td>");
	echo("<td>".$item_market_name[$i]."</td>");
	echo("<td>".$sell_price[$i]."</td>");
	echo("<td>".$buy_price[$i]."</td>");
	echo("<td>".$buy_date[$i]."</td>");
	echo("<td><a href=https://market.csgo.com/item/" . str_replace("_", "-", $classid_instanceid[$i]) . " target='_blank'>LINK</a></td></tr>");
}
?>
</table>
</div>
<div class="item_information">
	<div id="data-loaded">
    	<img src="../images/preloaders/preloader_3_BIG.gif" alt="Preloader" width="150px" height="150px;">
    </div>
	<div class="info" id="information_field">
    <div class="main_information">
    	<div class="market_name">
        	<b id="marketName">M4A4 | Buzz Kill (Прямо с завода)</b>
        </div>
        <div class="propert type" id="type">
        	Винтовка
        </div>
        <div class="propert slot" id="slot">
        	Обыч.
        </div>
        <div class="propert quality" id="quality">
        	Прямо с завода
        </div>
        <div class="propert rarity" id="rarity">
        	Тайное качество
        </div>
        <div class="clear"></div>
       
        <div class="desc collection">
        	<span id="collection">The Glove Collection</span>
        </div>
        <div class="desc description">
        	<p id="description">M4A4 — более точный, но слабый аналог АК-47 — полностью автоматическая штурмовая винтовка, которая находится исключительно на вооружении у спецназа. This Sektor Industry firearm has been sleekly painted in yellow and green. There's one at every party.</p>
        </div>
        
    </div>
    <div class="item_img">
    	<div class="item_pic" id="item_ing_png">
    		<img src='https://cdn.csgo.com/item_2077670040_188530139.png' width="256px">
    	</div>
    	<div class="item_bg_shadow">
        	<img src='../images/item_shadow.png' width="256px">
        </div>
    </div>
    <div class="clear"></div>
    <div>
    <div class="item_price">
    	<div class="price_stat">
        	<p><b>Цена покупки и продажи</b></p>
        	<div class="hist_container">
                <b id="buyPrice">1920.35</b>
                <span>Buy price</span>
            </div>
            <div class="hist_container">
                <b id="sellPrice">2214.50</b>
                <span>Sell price</span>
            </div>
            <div class="hist_container">
                <b class="price_rersent" id="profit">15.31%</b>
                <span>Profit</span>
            </div>
            <div class="hist_container">
                <b class="price_rersent" id="profit_end">12.56%</b>
                <span>End Profit</span>
            </div>
            <div class="clear"></div>
        </div>

        <div class="stat_history">
        	<p><b>Статистика последних покуп</b>ок</p>
            <div class="hist_container">
                <b  id="number"><?php echo($number); ?></b>
                <span>Amount</span>
            </div>
            <div class="hist_container">
                <b id="MINPrice"><?php echo($MIN_price/100); ?></b>
                <span>MIN price</span>
            </div>
            <div class="hist_container">
                <b id="AVERAGEPrice"><?php echo($average_price/100); ?></b>
                <span>Average price</span>
            </div>
            <div class="hist_container">
                <b id="MAXPrice"><?php echo($MAX_price/100); ?></b>
                <span>MAX price</span>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    </div>
    <div class="clear"></div>
    </div>
    <div class="clear"></div>
    
    <div id="chart_div"></div>

</div>

 
<script>
$(document).ready(function(){
    $('#data-loaded').hide();
  
});
function downloadData(classid_instanceid,buyPrice,sellPrice){
	$('#information_field').hide();
	$('#chart_div').hide();
	$('#data-loaded').show();
	
	$.ajax({
		type: "POST",
		url: 'pages/item_info/action_item.php', 
		cache: false,
		dataType: 'json',
		data:{tid:classid_instanceid},
		success: function(response){
			var bg_color = document.querySelectorAll('.table_line_act');
			for (var i = 0; i < bg_color.length; i++) {//Скрываем и опускаем все блоки и кнопки.
				bg_color[i].style.backgroundColor = "#ffffff";
  			} 
			document.getElementById(classid_instanceid).style.backgroundColor = "#C5C5C5";
			
			document.getElementById('marketName').innerHTML = response.marketName;
			document.getElementById('type').innerHTML = response.type;
			document.getElementById('slot').innerHTML = response.slot;
			document.getElementById('quality').innerHTML = response.quality;
			document.getElementById('rarity').innerHTML = response.rarity;
			document.getElementById('collection').innerHTML = response.collection;
			document.getElementById('description').innerHTML = response.description;
			document.getElementById('item_ing_png').innerHTML = "<img src='https://cdn.csgo.com/item_"+classid_instanceid+".png' width='256px'>";
			
			document.getElementById('buyPrice').innerHTML = buyPrice;
			document.getElementById('sellPrice').innerHTML = sellPrice;
			var profit = (((sellPrice*100)/buyPrice)-100).toFixed(2);
			document.getElementById('profit').innerHTML = profit + "%";
			var v = (sellPrice/1.15)*100;
			var profit_end = ((v/buyPrice)-100).toFixed(2);
			document.getElementById('profit_end').innerHTML = profit_end + "%";
			
			//
			//document.getElementById(rarity).innerHTML = response.marketName;
			$('#data-loaded').hide();
			$('#information_field').show();
			$('#chart_div').show();
		}
	});	
	//UpdATE plot
	/*$.ajax({
		type: "POST",
		url: 'pages/item_info/updatePlot.php', 
		cache: false,
		dataType: 'json',
		data:{tid:classid_instanceid},
		success: function(res){
			document.getElementById('number').innerHTML = res.number;
			document.getElementById('MINPrice').innerHTML = res.minPrice;
			document.getElementById('AVERAGEPrice').innerHTML = res.averagePrice;
			document.getElementById('MAXPrice').innerHTML = res.maxPrice;
			//console.log(res.dataArray) ;
			dataArray = [res.dataArray];
			
			google.charts.load('current', {packages: ['corechart', 'line']});
			//var dataArray =  res.dataArray.substr(0);
			//alert(dataArray);
			console.log(dataArray) ;
			alert(dataArray);
			
			google.charts.setOnLoadCallback(function drawCurveTypes(){
				var data = new google.visualization.DataTable();
				data.addColumn('number', 'X');
				data.addColumn('number', 'Item');
				data.addColumn({type:'string', role:'tooltip'});
			
				data.addRows(dataArray);
				var options = {
				hAxis: { title: 'Number of the last purchased item (descending)'},
				vAxis: { title: 'Item price,rub' }, 
				series: {1: {curveType: 'function'}}, height: 400, width: 1130 };
			
				var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			});
			
		}
	});	*/
	
	


	
	
}

</script>
  
  