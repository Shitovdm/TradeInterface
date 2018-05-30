<?php
/*
*	Страница поиска выгодных вещей при переводе из Стима в ТМ.
*	На странице
*
*/
//Функция принимает массив и возвращет массив только с уникальными значениями.
function UNIQUE_array($array){
	//Сортируем,оставляя категории в единичном экземпляре.
	$UNIQUE_array = array_unique($array);//Оставляем только не пустые элементы массива.
	$k=0;
	for($i=0;$i<count($array);$i++){
		if($UNIQUE_array[$i] != ''){
			$uni_array[$k] = $UNIQUE_array[$i];
			$k++;
		}
	}
	return($uni_array);
}

// Проверка пользователя.
if(!isset($_SESSION['steamid'])){
	header('Location: /index.php?page=access_denied.php');
}else{
	$steamid = $_SESSION['steamid'];
}

require_once("service/dbconnect.php");

$select_data = mysql_query("SELECT * FROM searchList_SteamToTM");
$i=0;
while($row = mysql_fetch_assoc($select_data)){	
	$weapon[$i] =$row['weapon'];
	$quality[$i] =$row['quality'];
	$name[$i] =$row['name'];
	$category[$i] =$row['category'];
	$type[$i] =$row['type'];
	$i++;
}
$sort_weapon = UNIQUE_array($weapon);
$sort_quality = UNIQUE_array($quality);
$sort_name = UNIQUE_array($name);
$sort_category = UNIQUE_array($category);
$sort_type = UNIQUE_array($type);
?>
<div class="top_panel_steamTOTm_page">
	
    <div class="search_param_steamTOTm_page">
        <div class="left_side">
            <div class="form_search_name"><span>Weapon:</span></div>
            <div class="form_search_name"><span>Name:</span></div>
            <div class="form_search_name"><span>Quality:</span></div>
            <div class="form_search_name"><span>Category:</span></div>
            <div class="form_search_name"><span>Type:</span></div>
        </div>
        <div class="right_side">
            <form class='search_form select_search_param'>
                <select size='1' id='Weapon'>
                <option selected value="0">Все</option>
                <?php
                    for($i=0;$i<count($sort_weapon);$i++){
                        echo("<option value='".$sort_weapon[$i]."'>".$sort_weapon[$i]."</option>");
                    }
                ?>
                </select>
            </form>
            <form class='search_form select_search_param'>
                <select size='1' id='Name'>
                <option selected value="0">Все</option>
                <?php
                    for($i=0;$i<count($sort_name);$i++){
                        echo("<option value='".$sort_name[$i]."'>".$sort_name[$i]."</option>");
                    }
                ?>
                </select>
            </form>
            <form class='search_form select_search_param'>
                <select size='1' id='Quality'>
                <option selected value="0">Все</option>
                <?php
                    for($i=0;$i<count($sort_quality);$i++){
                        echo("<option value='".$sort_quality[$i]."'>".$sort_quality[$i]."</option>");
                    }
                ?>
                </select>
            </form>
            <form class='search_form select_search_param'>
                <select size='1' id='Category'>
                <option selected value="0">Все</option>
                <?php
                    for($i=0;$i<count($sort_category);$i++){
                        echo("<option value='".$sort_category[$i]."'>".$sort_category[$i]."</option>");
                    }
                ?>
                </select>
            </form>
            <form class='search_form select_search_param'>
                <select size='1' id='Type'>
                <option selected value="0">Все</option>
                <?php
                    for($i=0;$i<count($sort_type);$i++){
						
                        echo("<option value='".$sort_type[$i]."'>".$sort_type[$i]."</option>");
                    }
                ?>
                </select>
            </form>
        </div>
	</div>
    
    <div class="search_param_steamTOTm_page double_window">
    
    	<div class="process_steamTOTm_page">
            <div class="amount_items_DB">
        	<b>Amount of items in database: <b id="amount_serch_items"></b></b>
        </div>
        <div class="amount_upload_items">
        	<form class='search_form'>
            	<b>Choose amount of uploaded items: </b>
                <select size='1' id='amount_upload_items'>
                    <option selected value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </form>
        </div> 
        </div>
    
    	<div class="action_steamTOTm_page">
        	<table class="result_table">
    			<tr>
        			<td><input onClick="downloading_SteamTOTm()" type="button" value="Upload" class="action_button" alt="Upload new items" title="Upload new items"></td> 
                    <td><input type="button" class="action_button" value="Login" title="Re login" alt="Re login" onClick="re_login()"></td>
                    <td><input onClick="clear_resultTable_SteamTOTm()" type="button" value="Clear" class="action_button" alt="Clear table" title="Clear table"></td>
                    
                    <td><input type="button" class="action_button" value="Save" title="Save all orders" alt="Save all orders" onClick=""></td>
        		</tr>
                <tr>
                	<td><input type="button" class="action_button" value="Refresh" alt="Refresh my orders list" title="Refresh my orders list" onClick="refresh_orders()"></td>
                    <td><input type="button" class="action_button" value="Orders" title="Load orders list" alt="Load orders list" onClick="load_order_list()"></td>
                    <td><input type="button" class="action_button" value="ClearLog" title="Clear refresh log" alt="Clear refresh log" onClick="document.getElementById('refresh_log').innerHTML = '';"></td>
                    <td><input type="button" class="action_button" value="Remove" title="Remove all orders" alt="Remove all orders" onClick=""></td>
                </tr>
    		</table>
        </div>  
    </div>
    
    <div class="other_param_steamTOTm_page">
    	<div class="STtoTM_log" id="STtoTM_log">
			<p>You can choose paraneters and upload new items.</p>
        	<p>Do not press "UPLOAD" button more than once every 20 seconds. This may lead to Steam ban.</p>
        	<p>You must use english version of Steam.</p>	
		</div>
    </div>
    
    <div class="search_param_steamTOTm_page">
    	<div class="amount_items_DB">
            <input class="checkbox_SteamTOTm" type="checkbox" id="STtoTM_auto_login"  name="auto_login">
        	<b> Turn ON/OFF auto login </b>
            <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Включение автоматического логина Стима. Осуществляется каждые 10 минут');" alt="Click">
        </div>
        <div class="amount_items_DB">
            <input class="checkbox_SteamTOTm" type="checkbox" id="STtoTM_loading_by_circle"  name="loading by circle">
        	<b> Turn ON/OFF loading by circle </b>
            <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Включение функции круговой загрузки предметов.');" alt="Click">
        </div>
        <div class="amount_items_DB">
            <input class="checkbox_SteamTOTm" type="checkbox" id="STtoTM_auto_orders"  name="auto_orders">
        	<b> Turn ON/OFF auto expose orders </b>
            <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Автоматическое выставление ордера на предмет, как только он найдется.');" alt="Click">
        </div>
        <div class="amount_items_DB">
            <input class="checkbox_SteamTOTm" type="checkbox" id="STtoTM_auto_clear_logs"  name="auto_clear_logs">
        	<b> Turn ON/OFF auto clear logs </b>
            <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Автоматичесая отчистка логов. Выполняется каждые 10 минут.');" alt="Click">
        </div>
        <div class="amount_items_DB">
            <input class="checkbox_SteamTOTm" type="checkbox" id="STtoTM_auto_clear_result_table"  name="auto_clear_result_table">
        	<b> Turn ON/OFF clear result table </b>
            <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Автоматическая отчистка таблицы найденных предметов. Выполняется каждый час.');" alt="Click">
        </div>   
    </div>
    
    <div class="search_param_steamTOTm_page double_window">
    	<div class="process_steamTOTm_page" id="process_steamTOtm">
        	<div class="ActionsBlock">
                <b>Current action:</b>
                <div class="currentActions" id="load_search_AND_order"><b>Search and order...</b></div>
                <div class="currentActions"  id="load_withdrawel"><b>Output objects from CSGO TM...</b></div>
                <div class="currentActions"  id="load_reception"><b>Confirmation of the output item...</b></div>
                <div class="currentActions"  id="load_steamsell"><b>Placement of items for sale...</b></div>
                <div class="currentActions"  id="load_reLogin"><b>Login to your Steam account...</b></div>
                <div class="currentActions"  id="load_online"><b>Online request in CSGO TM...</b></div>
                <div class="currentActions"  id="load_order_list"><b>Loading order list...</b></div>
                <div class="currentActions"  id="delete_mybuyorders"><b>Deleting buy order...</b></div>
                <div class="currentActions"  id="place_mybuyorder"><b>Place buy order...</b></div>
                <div class="currentActions"  id="refresh_buyorders"><b>Refreshing buy orders...</b></div>
        	</div>
            <img class="currentActions_Preloader"  src="images/preloaders/6.svg" id="load_icon"> 
            <div class="clear"></div>
        </div>
        
        <div class="action_steamTOTm_page">
        	<div class="amount_items_DB">
            	<input class="checkbox_SteamTOTm" type="checkbox" id="STtoTM_auto_uploading"  name="auto_uploading">
        		<b> Turn ON/OFF auto uploading</b>
            	<img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Включение автоматический подгрузки предметов по выбранным параметрам. Подгрузка осуществляется каждые 30 секунд.');" alt="Click">
                <input type="text" id="lower_limit_upload" value="0" style="width:30px; text-align:center;margin-left:20px;">
        	</div>
        	<div class="amount_items_DB">
            	<input class="checkbox_SteamTOTm" type="checkbox" id="STtoTM_auto_refresh_list_orders"  name="auto_refresh_orders">
                <b> Turn ON/OFF auto update orders list </b>
                <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Автоматическая подгрузка списка выставленных запросов на покупку в Стиме. Проверка осуществляется каждые 30 секунд.');" alt="Click">
       		</div>
        <div class="amount_items_DB">
        	<input class="checkbox_SteamTOTm" type="checkbox" id="STtoTM_auto_control"  name="auto_control_orders">
        	<b> Turn ON/OFF auto control orders </b>
            <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Включение автоматический проверки рентабельности всех выставленных запросов. Проверка осуществляется каждые 40 секунд.');" alt="Click">
            <input type="text" id="lower_limit_refresh" value="1" style="width:30px; text-align:center;margin-left:20px;">
        </div>
        </div>
    </div>
     
</div>
<div class="main_info">
    <div class="main_panel_steamTOTm_page">
        <div class="result ST_TM_result">
            <table id="header_table" class="simple-little-table result_table">
                <tr>
                    <th>#</th>
                    <th>Img</th>
                    <th>Name</th>
                    <th>Highest<br>buy Steam:</th>
                    <th>Lowest<br>sell Steam:</th>
                    <th>Order<br>price TM:</th>
                    <th>Steam->TM[%]:</th>
                    <th>Order</th>
                    <th>csgo.Tm<br>link</th>
                    <th>Steam<br>link</th>
                    <th>Status</th>
                </tr>
            </table>
            <table id="result_table" class="simple-little-table result_table"></table>
            <table id="sort_table" class="simple-little-table result_table"></table>
            
        </div>
    </div>
    <div class="Steam_mybuyorder">
        <table id="mybuyorders_table" class="mybuyorders_table">
            <tr>
                <th colspan="4">My buy orders (<b id="amount_mybyuorders">0</b>)<b style="float:right; margin-right:20px;">Ballance: 0</b></th>
            </tr>
            <tr>
                <th>Name</th>
                <th>Amount</th>
                <th>Price</th>
                <th></th>
            </tr>
            <tr>
            <th colspan="4"></th>
            </tr>
        </table>
        <div class="refresh_log" id="refresh_log">
        	<p>This is a log of operations with orders.</p>
        </div>
        <div id="log_tmp" style="display:none"></div>
    </div>
</div>
<div class="clear"></div>
<div class="most_popular_list_SteamTOTm"></div>

<script type="text/javascript" src="js/jquery.sticky.js"></script>
<script>
/* Добавление контента в начало блока.*/
function add_to_start(item_id,content){
	document.getElementById('log_tmp').innerHTML = document.getElementById(item_id).innerHTML;
	document.getElementById(item_id).innerHTML = content + document.getElementById('log_tmp').innerHTML;
}

$(window).load(function(){
	$("#process_steamTOtm").sticky({ topSpacing: 0 });
	
});
$('#process_steamTOtm').on('sticky-start', function() { 
		document.getElementById('process_steamTOtm').style.opacity = "0.85";
	});
	
$('#process_steamTOtm').on('sticky-end', function() { document.getElementById('process_steamTOtm').style.opacity = "1"; });

$(document).ready(function(){
	$("#sort_table").hide();//Скрываем вспомогательную таблицу.
	$("#header_table").hide();//Скрываем таблицу в которой находится хедер.(несколько таблиц для правильного отображения в порядке убывания)
	document.getElementById('result_table').innerHTML = document.getElementById('header_table').innerHTML;//При загрузке показываем только хедер.
//Скрываем прелоадер
   $("#load_search_AND_order").hide();
   $("#load_withdrawel").hide();
   $("#load_reception").hide();
   $("#load_steamsell").hide();
   $("#load_reLogin").hide();
   $("#load_online").hide();
   $("#load_order_list").hide();//Ожидание закгрузки списка ордеров
   $("#delete_mybuyorders").hide();
   $("#place_mybuyorder").hide();
   $("#refresh_buyorders").hide();
   $("#load_icon").hide();
   //Считаем количество предметов, доступных к поиску.
   $.ajax({
		url: 'pages/search/steam_to_tm/search_quantity.php', 
		cache: false,
		type:'POST',
		dataType: 'json',
		data:{"tweapon": weapon.value, "tname": window.weapon_name.value, "tquality": quality.value, "tcategory": category.value, "ttype": type.value},
		success: function(response){
			document.getElementById('amount_serch_items').innerHTML = response;
		}
	});
});

//	Функция скрывает прелоадер.
function hidePreloader(){
	if( ($("#load_search_AND_order").css("display") == "none") && ($("#load_withdrawel").css("display") == "none") &&
	    ($("#load_reception").css("display") == "none") && ($("#load_steamsell").css("display") == "none") &&
		($("#load_reLogin").css("display") == "none") && ($("#load_online").css("display") == "none") && 
		($("#load_order_list").css("display") == "none") && ($("#delete_mybuyorders").css("display") == "none") &&
		($("#place_mybuyorder").css("display") == "none") && ($("#refresh_buyorders").css("display") == "none")){
			$("#load_icon").hide();
	}
}

/*Обрабатываем изменения в параметрах поиска.*/
var weapon = document.getElementById("Weapon");
window.weapon_name = document.getElementById("Name");
var quality = document.getElementById("Quality");
var category = document.getElementById("Category");
var type = document.getElementById("Type");
var lower_limit = 0;//первоначальная граница загрузки.
//	Обработчик изменений.
weapon.onchange = function(){
	$.ajax({
		url: 'pages/search/steam_to_tm/weapon_name_sorting.php', 
		cache: false,
		type:'POST',
		dataType: 'json',
		data:{"tweapon": weapon.value},
		success: function(response){
			document.getElementById('Name').innerHTML = response;
			$.ajax({
				url: 'pages/search/steam_to_tm/search_quantity.php', 
				cache: false,
				type:'POST',
				dataType: 'json',
				data:{"tweapon": weapon.value, "tname": document.getElementById("Name").value, "tquality": quality.value, "tcategory": category.value, "ttype": type.value},
				success: function(response){
					document.getElementById('amount_serch_items').innerHTML = response;
				}
			});
		}
	});
	lower_limit = 0;
}
window.weapon_name.onchange = function(){
	$.ajax({
		url: 'pages/search/steam_to_tm/search_quantity.php', 
		cache: false,
		type:'POST',
		dataType: 'json',
		data:{"tweapon": weapon.value, "tname": window.weapon_name.value, "tquality": quality.value, "tcategory": category.value, "ttype": type.value},
		success: function(response){
			document.getElementById('amount_serch_items').innerHTML = response;
		}
	});
	lower_limit = 0;
}
quality.onchange = function(){
	$.ajax({
		url: 'pages/search/steam_to_tm/search_quantity.php', 
		cache: false,
		type:'POST',
		dataType: 'json',
		data:{"tweapon": weapon.value, "tname": window.weapon_name.value, "tquality": quality.value, "tcategory": category.value, "ttype": type.value},
		success: function(response){
			document.getElementById('amount_serch_items').innerHTML = response;
		}
	});
	lower_limit = 0;
}
category.onchange = function(){
	$.ajax({
		url: 'pages/search/steam_to_tm/search_quantity.php', 
		cache: false,
		type:'POST',
		dataType: 'json',
		data:{"tweapon": weapon.value, "tname": window.weapon_name.value, "tquality": quality.value, "tcategory": category.value, "ttype": type.value},
		success: function(response){
			document.getElementById('amount_serch_items').innerHTML = response;
		}
	});
	lower_limit = 0;
}
type.onchange = function(){
	$.ajax({
		url: 'pages/search/steam_to_tm/search_quantity.php', 
		cache: false,
		type:'POST',
		dataType: 'json',
		data:{"tweapon": weapon.value, "tname": window.weapon_name.value, "tquality": quality.value, "tcategory": category.value, "ttype": type.value},
		success: function(response){
			document.getElementById('amount_serch_items').innerHTML = response;
		}
	});
	lower_limit = 0;
}
//	Загрузка новых вещей по выбранным параметрам.
var downloading_SteamTOTm_FLAG = true; // Флаг занятости функции.
function downloading_SteamTOTm(){
	//	Изменяем флаг занятости функции.
	if(downloading_SteamTOTm_FLAG){
		downloading_SteamTOTm_FLAG = false;
		$("#load_search_AND_order").show();
		$("#load_icon").show();
		
		var amount = document.getElementById("amount_upload_items");
		$.ajax({
			url: "pages/search/steam_to_tm/SteamToTM.php",
			type: "POST",
			data: {"tamount": amount.value , "tlower_limit": lower_limit ,"tweapon": weapon.value, "tname": window.weapon_name.value, "tquality": quality.value, "tcategory": category.value, "ttype": type.value},
			cache: false,
			dataType: 'json',
			success: function(response){
				if(response.response_str == 0){
					add_to_start("STtoTM_log",'<p>Items not found. Check search settings!</p>');
					//	Загрузка по кругу.
					if($('#STtoTM_loading_by_circle').prop('checked') ){
						lower_limit = 0;
						add_to_start("STtoTM_log",'<p>Starting new lap.</p>');
					}
				}else{
					document.getElementById('sort_table').innerHTML = response.response_str + document.getElementById('sort_table').innerHTML;//Наполняем вспомогательную таблицу.
					document.getElementById('result_table').innerHTML = document.getElementById('header_table').innerHTML + document.getElementById('sort_table').innerHTML;//Наполняем основную таблицу.
					lower_limit = Number(lower_limit) + Number(amount.value);
					var tmp = '<p>Uploaded items: ' + amount.value + '.</p>';
					add_to_start("STtoTM_log",tmp);
					//	Выставление ордера.
					var order_list = eval(response.order_items);
					for(var y = 0; y < amount.value; y++){
						if(order_list[y][0] == "order"){
							if($('#STtoTM_auto_orders').prop('checked')){
								var market_name = order_list[y][1];
								var order_price = order_list[y][2];
								place_buyorder(market_name, order_price);
							}
						}
					}	
				}
				document.getElementById('lower_limit_upload').value = lower_limit;
				$("#load_search_AND_order").hide();
				 hidePreloader()
				//$("#load_icon").hide();
				downloading_SteamTOTm_FLAG = true;
			 }
		 });
	}
	

}
//	Удаление ордера.
var delete_mybuyorderFlag = true;
function delete_mybuyorder(order_number){
	if(delete_mybuyorderFlag){
		delete_mybuyorderFlag = false;
		$("#load_icon").show();
		$("#delete_mybuyorders").show();
		$.ajax({
			url: 'pages/search/steam_to_tm/delete_buyorder.php', 
			cache: false,
			type:'POST',
			dataType: 'json',
			data:{"torder_number": order_number},
			success: function(response){
				if(response.status == 1){
					var tmp = '<p>Delete order ' + order_number + ' success!</p>';
					add_to_start("STtoTM_log",tmp);
				}else{
					var tmp = '<p>Error when deleting order ' + order_number + '! Error code: ' + response.error_code + '; Description: ' + response.error_description + ';</p>';
					add_to_start("STtoTM_log",tmp);
				}
				 hidePreloader()
				//$("#load_icon").hide();
				$("#delete_mybuyorders").hide();
				delete_mybuyorderFlag = true;
				load_order_list();
			}
		});
	}
	
}

//	Очистка таблицы поиска выгодных вещей.
function clear_resultTable_SteamTOTm(){
	add_to_start("STtoTM_log",'<p>Result table cleared.</p>');
	//document.getElementById('STtoTM_log').innerHTML += '<p>Result table cleared.</p>';
	document.getElementById('result_table').innerHTML = document.getElementById('header_table').innerHTML;
	document.getElementById('sort_table').innerHTML = '';
}
//	Функция размещения заказа на покупку нужной вещи.
function place_buyorder(market_hash_name, price){
	$("#load_icon").show();
	$("#place_mybuyorder").show();
	var tmp = '<p>Placing order. Item: ' + market_hash_name + '; Price: ' + price + ';</p>';
	add_to_start("STtoTM_log",tmp);
	$.ajax({
		url: 'pages/search/steam_to_tm/place_buyorder.php', 
		cache: false,
		type:'POST',
		dataType: 'json',
		data:{"tmarket_hash_name": market_hash_name, "tprice": price},
		success: function(response){
			if(response.status == 1){
				var tmp = '<p>Placing order ' + response.buy_orderid + ' success!</p>';
				add_to_start("STtoTM_log",tmp);
			}else{
				var tmp = '<p>Error when response order! Error code: ' + response.status + '; Description: ' + response.message + '</p>';
				add_to_start("STtoTM_log",tmp);
			}
			 hidePreloader()
			//$("#load_icon").hide();
			$("#place_mybuyorder").hide();
			load_order_list();
		}
	});
	
}
//	Функция обновления выставленных заказов на покупку вещей в Steam.
var lower_limit_refresh = 1;
var refresh_ordersFlag = true;
function refresh_orders(){
	if(refresh_ordersFlag){
		refresh_ordersFlag = false;
		add_to_start("STtoTM_log","<p>Start refresh function.</p>");
		$("#load_icon").show();
		$("#refresh_buyorders").show();
		var lower_limit_refresh = document.getElementById('lower_limit_refresh').value;
		var amount = parseInt(document.getElementById('amount_mybyuorders').innerHTML);
		if( (lower_limit_refresh > amount) || (lower_limit_refresh == 0) ){
			lower_limit_refresh = 1;	
		}
		document.getElementById('lower_limit_refresh').value = lower_limit_refresh;
		$.ajax({
			url: 'pages/search/steam_to_tm/refresh_buyorders.php', 
			cache: false,
			type:'POST',
			dataType: 'json',
			data:{"tlower_limit_refresh": (lower_limit_refresh-1)},
			success: function(response){
				if(response.status == "Success"){
					if(response.action == "leave"){
						lower_limit_refresh++;
					}
					var tmp = "<p>" + response.logs + "</p>";
					add_to_start("refresh_log",tmp);
				}else{
					var tmp = "<p>" + response.status + "</p>";
					add_to_start("refresh_log",tmp);
				}
				document.getElementById('lower_limit_refresh').value = lower_limit_refresh;
				 hidePreloader()
				//$("#load_icon").hide();
				$("#refresh_buyorders").hide();
				refresh_ordersFlag = true;
				load_order_list();	
			}
		});	
	}
				
}
//	Обновление сессионных файлов
function re_login(){
	$("#load_reLogin").show();
	$("#load_icon").show();
	$.ajax({
		url: 're_login.php', 
		cache: false,
		dataType: 'json',
		success: function(response){
			$("#load_reLogin").hide();
			 hidePreloader()
			//$("#load_icon").hide();
			$("#log").append("<p>" + response.status + "</p>");// Для страницы TM->Steam
			add_to_start("STtoTM_log","<p>" + response.status + "</p>");
		}
	});	
}

//	Автоматическая подгрузка вещей, удовлетворяющих указанным условиям поиска.
setInterval(function(){
	if($('#STtoTM_auto_uploading').prop('checked')){
		downloading_SteamTOTm();
	}
}
,10000) ;
//	Автоматическое обновление списка ордеров.
setInterval(function(){
	if($('#STtoTM_auto_refresh_list_orders').prop('checked')){
		load_order_list();
	}
}
,30000) ;
//	Автоматическая проверка выгодности ордеров.
setInterval(function(){
	if($('#STtoTM_auto_control').prop('checked')){
		refresh_orders();
	}
}
,20000) ;
//	Автоматический логин.
setInterval(function(){
	if($('#STtoTM_auto_login').prop('checked')){
		re_login();
	}
}
,600000) ;
//	Отчистка логов.
setInterval(function(){
	if($('#STtoTM_auto_login').prop('checked')){
		document.getElementById('refresh_log').innerHTML = '';
		document.getElementById('STtoTM_log').innerHTML = '';
	}
}
,6000000) ;
//	Лтчистка таблицы.
setInterval(function(){
	if($('#STtoTM_auto_login').prop('checked')){
		clear_resultTable_SteamTOTm();
	}
}
,6000000) ;










//	Обновление списка выставленных ордеров.
var load_order_listFlag = true;
function load_order_list(){
	if(load_order_listFlag){
		load_order_listFlag = false;
		$("#load_icon").show();
		$("#load_order_list").show();
		$.ajax({
			url: 'pages/search/steam_to_tm/load_order_list.php', 
			cache: false,
			type:'POST',
			dataType: 'json',
			success: function(response){
				if(response.status == null){
					add_to_start("STtoTM_log","<p>Error. Please login!</p>");
				}else{
					document.getElementById('mybuyorders_table').innerHTML = response.data;
					document.getElementById('amount_mybyuorders').innerHTML = response.amount;
					var tmp = '<p>Success load ' + response.amount + ' items.</p>';
					add_to_start("STtoTM_log",tmp);
				}
				$("#load_icon").hide();
				$("#load_order_list").hide();
				load_order_listFlag = true;
			}
		});
	}
	
}
</script>