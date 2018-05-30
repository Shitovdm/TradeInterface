<?php
/*
*	Страница поиска выгодных вещей при переводе из ТМ в Стим.
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

if(!isset($_SESSION['steamid'])){
	header('Location: /index.php?page=access_denied.php');
}else{
	$steamid = $_SESSION['steamid'];
}

require_once("service/dbconnect.php");
include_once("login_data.php");

$select_data = mysql_query("SELECT * FROM searchList_TMToSteam");
$i=0;
while ($row = mysql_fetch_assoc($select_data)) {	
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
<div class="toolbar">
    <div class="source_celect">
    	<div class="select_button" id="settings" onClick="selectBlock('settings')">
            <a>Settings</a>
        </div>
        <div class="select_button" id="tradebots" onClick="selectBlock('tradebots')">
            <a>Tradebots</a>
        </div>
        <div class="select_button" id="our_list" onClick="selectBlock('our_list')">
            <a>Our list</a>
        </div>
        <div class="select_button" id="our_buttons" onClick="selectBlock('our_buttons')">
            <a>Buttons</a>
        </div>
        <div class="select_button" id="our_func" onClick="selectBlock('our_func')">
            <a>Functions</a>
        </div>
        <div class="select_button" id="our_proxy" onClick="selectBlock(this.id)">
            <a>Proxy</a>
        </div>
    </div>
    <div class="fields">
    	<div class="select_field" id="settings_field">
            <div class="settings_block">
                <div class="amount_items_DB">
                    <input class="checkbox_SteamTOTm" type="checkbox" id="search_upload_items"  name="search_upload_items">
                    <b> Auto search/upload items </b>
                    <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert(Включение автоматической подгрузки предметов. Подгрузка выполняется каждые ');" alt="Click">
                </div>
                <div class="amount_items_DB">
                    <input class="checkbox_SteamTOTm" type="checkbox" id="auto_withdrawel"  name="auto_withdrawel">
                    <b> Auto withdrawal items </b>
                    <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Автоматический вывод предметов. Выполняется согласно последнему сценарию в этом файле.');" alt="Click">
                </div>
                <div class="amount_items_DB">
                    <input class="checkbox_SteamTOTm" type="checkbox" id="auto_sell_items_in_steam"  name="auto_sell_items_in_steam">
                    <b> Auto selling items in Steam </b>
                    <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Автоматическая продажа выведенных предметов в Steam. Выполняется каждые 4 минуты.');" alt="Click">
                </div>
        	</div>
            
            <div class="settings_block">
                <div class="amount_items_DB">
                    <input class="checkbox_SteamTOTm" type="checkbox" id="auto_trade"  name="auto_trade">
                    <b> Buy found items </b>
                    <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Включение автоматического логина Стима. Осуществляется каждые 10 минут');" alt="Click">
                </div>
                <div class="amount_items_DB">
                    <input class="checkbox_SteamTOTm" type="checkbox" id="auto_login_in_steam"  name="auto_login_in_steam">
                    <b> Turn ON/OFF auto login </b>
                    <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Автоматический re login в Стиме. Выполняется каждые 7 минут.');" alt="Click">
                </div>
                <div class="amount_items_DB">
                    <input class="checkbox_SteamTOTm" type="checkbox" id="loading_items_by_circle"  name="loading_items_by_circle">
                    <b> Turn ON/OFF loading by circle </b>
                    <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Включение круговой загрузки предметов.');" alt="Click">
                </div>
        	</div>
            
            <div class="settings_block">
                <div class="amount_items_DB">
                    <input class="checkbox_SteamTOTm" type="checkbox" id="auto_clear_tableANDlog"  name="auto_clear_tableANDlog">
                    <b> Auto clear log and table </b>
                    <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Автоматическая отчистка таблицы предметов и лога. Выполняется каждые 30 минут.');" alt="Click">
                </div>
                <div class="amount_items_DB">
                    <input class="checkbox_SteamTOTm" type="checkbox" id="auto_send_online_request"  name="auto_send_online_request">
                    <b> Auto send online requests in TM </b>
                    <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Автоматическая отправка запросов онлайн на TM. Отправка осуществляется каждые 3 минуты.');" alt="Click">
                </div>
                <div class="amount_items_DB">
                    <input class="checkbox_SteamTOTm" type="checkbox" id="auto_refresh_user_cash"  name="auto_refresh_user_cash">
                    <b> Auto refresh user ballance </b>
                    <img src="../images/information.png" class="information_icon" width="24px" height="24px"  onClick="alert('Автоматическое обновление баланса на TM и Steam. Выполняется каждые 3 минуты.');" alt="Click">
                </div>
        	</div>
            
   		</div>
        <div class="select_field" id="tradebots_field">
            <div class="container" id="elma">
                <div class="selectors" onClick="selected('https://steamcommunity.com/id/Elmagnar/inventory/json/730/2/','elma')">[Tradebot]<br>Elma</div>
                <div class="links">
                    <div class="inventory_link"><a href="http://steamcommunity.com/id/Elmagnar/inventory/#730" target="_blank">Items</a></div>
                    <div class="offer_link"><a href="https://steamcommunity.com/tradeoffer/new/?partner=259203704&token=z5d5gxDH" target="_blank">Offer</a></div>
                </div>
            </div>
            
            <div class="container" id="dana">
                <div class="selectors" onClick="selected('https://steamcommunity.com/profiles/76561198231453904/inventory/json/730/2/','dana')">[Tradebot]<br>Dana</div>
                <div class="links">
                    <div class="inventory_link"><a href="https://steamcommunity.com/profiles/76561198231453904/inventory/#730" target="_blank">Items</a></div>
                    <div class="offer_link"><a href="https://steamcommunity.com/tradeoffer/new/?partner=271188176&token=iV5YXq-o" target="_blank">Offer</a></div>
                </div>
            </div>
             
            <div class="container" id="alex">
                <div class="selectors" onClick="selected('https://steamcommunity.com/profiles/76561198236936650/inventory/json/730/2/','alex')">[Tradebot]<br>Alex</div>
                <div class="links">
                    <div class="inventory_link"><a href="https://steamcommunity.com/profiles/76561198236936650/inventory/#730" target="_blank">Items</a></div>
                    <div class="offer_link"><a href="https://steamcommunity.com/tradeoffer/new/?partner=276670922&token=Lm48jT0f" target="_blank">Offer</a></div>
                </div>
            </div>
            
            <div class="container" id="beta">
                <div class="selectors" onClick="selected('https://steamcommunity.com/profiles/76561198236954926/inventory/json/730/2/','beta')">[Tradebot]<br>Beta</div>
                <div class="links">
                    <div class="inventory_link"><a href="http://steamcommunity.com/profiles/76561198236954926/inventory/#730" target="_blank">Items</a></div>
                    <div class="offer_link"><a href="https://steamcommunity.com/tradeoffer/new/?partner=276689198&token=wfv9UbtH" target="_blank">Offer</a></div>
                </div>
            </div>
            
            <div class="container" id="cora">
                <div class="selectors" onClick="selected('https://steamcommunity.com/profiles/76561198204830825/inventory/json/730/2/','cora')">[Tradebot]<br>Cora</div>
                <div class="links">
                    <div class="inventory_link"><a href="http://steamcommunity.com/profiles/76561198204830825/inventory/#730" target="_blank">Items</a></div>
                    <div class="offer_link"><a href="https://steamcommunity.com/tradeoffer/new/?partner=244565097&token=5r87t_3I" target="_blank">Offer</a></div>
                </div>
            </div>   	
        </div>
        <div class="select_field" id="our_list_field">
            <div class="container" id="TMtoSTEAMList">
                <div class="selectors" onClick="selected('TMtoSTEAMList','TMtoSTEAMList')">TM to STEAM</div>
                <div class="links">
                    <div class="inventory_link"><a href="http://trade.tm.xsph.ru/pages/lists/STEAMtoTMList.txt" target="_blank">Items</a></div>
                </div>
            </div>
            
            <div class="container" id="STEAMtoTMList">
                <div class="selectors" onClick="selected('STEAMtoTMList','STEAMtoTMList')">STEAM to TM</div>
                <div class="links">
                    <div class="inventory_link"><a href="http://trade.tm.xsph.ru/pages/lists/STEAMtoTMList.txt" target="_blank">Items</a></div>
                </div>
            </div>
            
            <div class="container" id="STEAMtoTMListOLD">
                <div class="selectors" onClick="selected('STEAMtoTMListOLD','STEAMtoTMListOLD')">STEAM to TM OLD</div>
                <div class="links">
                    <div class="inventory_link"><a href="http://secretskins.ru/pages/lists/STEAMtoTMListOLD.txt" target="_blank">Items</a></div>
                </div>
            </div>
            
            <div class="container" id="OutSearch">
                <div class="selectors" onClick="selected('OutSearch','OutSearch')">Out Search</div>
                <div class="links">
                    <div class="inventory_link"><a href="https://csgo.tm/" target="_blank">Items</a></div>
                </div>
            </div>
                
            <div class="container" id="CSGOTM_profitable">
                <div class="selectors" onClick="selected('CSGOTM_profitable','CSGOTM_profitable')">CSGOTM profitable</div>
                <div class="links">
                    <div class="inventory_link"><a href="http://secretskins.ru/pages/lists/CSGOTM_profitable.txt" target="_blank">Items</a></div>
                </div>
            </div>	
        </div>
    </div>

    <div class="select_field" id="our_buttons_field">
        <div class="container" id="withdrawel" onClick="withdrawel()">
            <div class="selectors"><b>Withdrawel</b></div>
             <div class="selectors">Withdraw ready to trade items.</div>
        </div>	
        <div class="container" id="steamsell" onClick="steamsell()">
            <div class="selectors"><b>Steamsell</b></div>
            <div class="selectors">We exhibit the last 5 items for sale on the trading platform.</div>
        </div>	
        <div class="container" id="re_login" onClick="re_login()">
            <div class="selectors"><b>Re login</b></div>
            <div class="selectors">Authorization on Steam, to work with the trading platform.</div>
        </div>
        <div class="container" id="online" onClick="open_modalWindow()">
            <div class="selectors"><b>Remember</b></div>
             <div class="selectors">Remember the contents of the inventory.</div>
        </div>	
        <div class="container" id="online" onClick="refresh_activeItems_CSGOTM()">
            <div class="selectors"><b>Refresh active list</b></div>
            <div class="selectors">Refresh list of active items.</div>
        </div>	
    </div>
    
    <div class="select_field" id="our_func_field">
        <div class="container" id="steamsellALL" onClick="steamsellALL()">
            <div class="selectors"><b>Steamsell ALL</b></div>
            <div class="selectors">We exhibit the last ALL items for sale on the trading platform.</div>
        </div>
    </div>
    
    <div class="select_field" id="our_proxy_field">
        <textarea id="textarea_proxyList" placeholder="Enter this your proxy..." name="source" rows=7 cols="40">
			<?php 
                echo(htmlspecialchars(file_get_contents('pages/lists/proxy/proxy_list.txt'), ENT_QUOTES));
            ?>
        </textarea>
        <input class="form_button_proxyList" type="button" name="clear" value="Clear" onClick="action_EnterList('clear',this.form)">
        <input class="form_button_proxyList" type="button" name="save" value="Save" onClick="action_EnterList('save',this.form)">
        <input class="form_button_proxyList" type="button" name="load" value="Load" onClick="action_EnterList('load',this.form)">
    </div>
    <div class="clear"></div>
</div>

<div class="toolbar" id="window-activeItems">
	<div class="source_celect">
    	<div onClick="refresh_activeItems_CSGOTM()" class="activeItems_activate">
        	<input id="activate_auto_loading" type="checkbox"><span>Activate auto-loading</span>
        </div>
        <div onClick="refresh_ballance_TM()" class="activeItems_activate">
        	<span>Tm cash: <b id="current_ballance_TM">null</b></span>
        </div>
        <div onClick="refresh_ballance_Steam()" class="activeItems_activate">
        	<span>Steam cash: <b id="current_ballance_Steam">null</b></span>
        </div>
    </div>
	<div id="activeItems_CSGOTM"></div>
	<div class="clear"></div>
</div>


<div class="io" id="io">
    <div class="main">
        <div class="result">
            <table id="result_table" class="simple-little-table result_table">
                <tr>
                    <th class="pointed" onClick="sortingBy(0,1)" onDblClick="sortingBy(0,2)">#</th>
                    <th>Img:</th>
                    <th>Name:</th>
                    <th class="pointed" onClick="sortingBy(3,1)" onDblClick="sortingBy(3,2)">Min<br>price TM:</th>
                    <th class="pointed" onClick="sortingBy(4,1)" onDblClick="sortingBy(4,2)">Steam<br>lowest:</th>
                    <th class="pointed" onClick="sortingBy(5,1)" onDblClick="sortingBy(5,2)">Steam<br>median:</th>
                    <th class="pointed" onClick="sortingBy(6,1)" onDblClick="sortingBy(6,2)">TM->Steam[%]:</th>
                    <th>csgo.Tm<br>link:</th>
                    <th>Steam<br>link:</th>
                    <th>Update:</th>
                    <th>Buy:</th>
                    <th>Remember:</th>
                    <th class="pointed" onClick="sortingBy(10,1)" onDblClick="sortingBy(10,2)">Steam<br>volume:</th>
                    <th>Status:</th>
                </tr> 
            </table>
            <table id="sort_result"></table>
            <table class="result_table">
                <tr>
                    <td colspan="15">
                    <div style="position: relative; left: 5px; text-align: left; top: 5px;" id="proxy_address" title="Last used proxy address."></div>
                        <div id="load">
                            <div id="downloading">Upload</div>
                            <div id="clear_table" onClick="clear_table()">Clear</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
        <div class="warnings" id="log">
            <p>
                <?php
                    session_start();
                    //Помещаем в логи ответ сервера при авторизации.
                    if(isset($_SESSION['steamid'])){
                        echo("<p>[" . date("d.m.Y H:i:s") . "] Login is success.</p>");
                    }else{
                        echo("<p>[" . date("d.m.Y H:i:s") . "] For you the interface is not available, please log in.</p>");
                    }
                ?>
            </p>	
        </div>
        <div class="warnings" style="margin-left:10px;" id="full_log">
        <div id="log_tmp" style="display:none"></div>
    </div>
</div>
<div class="second_half" id="add_menu">
    <div class="adding_form current_action_field">
        <b>Current action:</b>
        <div id="load_search_AND_buy"><b>Search and buying items...</b></div>
        <div id="load_withdrawel"><b>Output objects from CSGO TM...</b></div>
        <div id="load_reception"><b>Confirmation of the output item...</b></div>
        <div id="load_steamsell"><b>Placement of items for sale...</b></div>
        <div id="load_reLogin"><b>Login to your Steam account...</b></div>
        <div id="load_online"><b>Online request in CSGO TM...</b></div>
        <div id="load_activeItems"><b>Load active items from CSGO TM...</b></div>
        <div id="load_action_EnterList"><b>Processing lists...</b></div>
        <div id="refresh_ballance_TM"><b>Refreshing user cash...</b></div>
        
        <img src="images/preloaders/preloader_2.gif" id="load_icon">
    </div>
    <div class="clear"></div>
    <div class="adding_form formula"> 
    	<div class="amount_items_DB">
        	<b>Amount of items in database: <b id="amount_serch_items"></b></b>
        </div>
        <div class="amount_upload_items">
        	<form class='search_form'>
            	<b>Amount of uploaded items: </b>
                <select size='1' id='amount_upload_items'>
                    <option selected value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </form>
        </div>
        <div class="downloading_param">
            <b>Download items from:</b>
            <input placeholder="Amount" id="download_items_from" value="0">
            <div class="clear"></div>
        </div>
        
        <div class="downloading_param">
            <b>Buy items with profit(>):</b>
            <input placeholder="Profit" id="items_start_profit" value="30">
            <div class="clear"></div>
        </div>
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
        <div class="clear"></div>
    </div>
    <div class="clear"></div> 
    <div class="adding_form formula">
    	<div class="amount_items_in_enter_text">
        	<b>Amount items in enter text: <b id="amountItems_EnterList">
				<?php
					$count = 0;
                	$text = file_get_contents('pages/lists/page_source_code.txt');
					$preg_item_CLASS_INSTANCE = preg_match_all(("/(class=\"item hot\" href=\"item\/)[0-9_-]{2,}/"),(string)$text, $item_CLASS_INSTANCE);
					for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
						$count++;
					}
					echo($count);
                ?>
            </b></b>
        </div>
        <form class="input_form" name="forma" method="post" action="pages/lists/textarea_action.php" >
             <textarea id="textarea_EnterList" placeholder="Вставьте сюда исходный код страницы с предметами и нажмите save, чтобы распарсить список, или нажмите load, чтобы подгрузить существующий список." name="source" rows=6></textarea>
             <textarea id="textarea2_EnterList" name="items" rows=6 placeholder="Нажмите Save чтобы распарсить исходный код из поля выше, или load, чтобы загрузить уже существующий список."></textarea>
            <div class="clear"></div>
            <input class="form_button" type="button" name="clear" value="Clear" onClick="action_EnterList('clear',this.form)">
            <input class="form_button" type="button" name="save" value="Save" onClick="action_EnterList('save',this.form)">
            <input class="form_button" type="button" name="load" value="Load" onClick="action_EnterList('load',this.form)">
        </form>  
    </div>
</div>

<div id="transparent-bg" class="bg-modal-block">.</div>
<div class="modal-window" id="block-remember-items">
	<div class="title-block">
    	<b>Inventory</b>
    	<img onClick="close_modalWindow()" src="images/icons/close-20px.png" width="18px" alt="Close">
    </div>
    <div style="float:left">
        <div class="min-itemsList" id="min-itemsList">
        	<h6>Click "Refresh" to upload your inventory.</h6>
        </div>
        <div class="clear"></div>
        <div class="inventory-action">
            <div class="block-action">
            	<span class="action-button" onClick="action_modalWindow('upload-inventory')">Refresh</span>
                <span class="action-button" onClick="action_modalWindow('remember-all')">Save all</span>
                <span class="action-button" onClick="alert('Does\'t work');">Save some</span>
                <span class="action-button" onClick="alert('Does\'t work');">Add some</span>
				<span class="action-button" onClick="action_modalWindow('clear-all')">Clear all</span>
            	<span class="action-button" onClick="alert('Does\'t work');">Clear some</span>
            </div>
        </div>
    </div>
    <div class="preview">
    	<div class="inventory-hover-background">
        	<img id="preview-img" src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpopujwezhh3szYI2gS096zlYSOk8jkMrLfglRd4cJ5nqeT8Yjx2VDgqUU4N2-ldYSVegQ-YVnY-lPvx-6-1sDttcmYmyNkuCJ2-z-DyKbJCvT-" width="250px">
            <div class="prev-text">
            	<h3 id="preview-name" >P250 | Undertow</h3>
                <div id="preview-quality" class="description">Exterior: Factory New</div>
                <div id="preview-description" class="description">A low-recoil firearm with a high rate of fire, the P250 is a relatively inexpensive choice against armored opponents. It has been painted using metallic paints with a silver slide and a blue and black spotted pattern on the receiver.</div>
                <div id="preview-collection" class="description collection-description">The Arms Deal 3 Collection</div>
                <div id="preview-cache-expiration" class="description owner-descriptions">2017-10-31T07:00:00Z</div>
                <div id="preview-link" class="description link-description"><a href="http://steamcommunity.com/market/listings/730/" target="_blank">View in Community Market</a></div>
            </div> 
        </div>
    </div>
    <div class="clear"></div>
</div>

<script>
//	Функция отчищает текст внутри поля ввода исходного кода сайта(при поиске вещей). 
function action_EnterList(action,t){
	$("#load_action_EnterList").show();
	$("#load_icon").show();
	$.ajax({
		url: 'pages/search/tm_to_steam/textarea_action.php', 
		cache: false,
		type:'POST',
		dataType: 'json',
		data:{"t_action":action, "t_source_value":t.source.value},
		success: function(response){
			if(action == "load"){
				$("#textarea_EnterList").html(response.items[0]);
				$("#textarea2_EnterList").html(response.items[1]);
				var logs = '<p>' + response.date + response.logs + '</p>';
				add_to_start("log",logs);
			}
			
			if(action == "clear"){
				t.source.value = response.items;
				t.items.value = response.items;
				var logs = '<p>' + response.date + response.logs + '</p>';
				add_to_start("log",logs);
			}
			
			if(action == "save"){
				t.items.value = response.items;
				var logs = '<p>' + response.date + response.logs + ' Add ' + response.amount + ' new items.</p>';
				add_to_start("log",logs);
			}
			document.getElementById('amountItems_EnterList').innerHTML = response.amount;
			$("#load_action_EnterList").hide();
			$("#load_icon").hide();
			
		}
	});
}

// Загрузка предметов в листе.
function load_EnterList(){
	$("#textarea_EnterList").html("Uploaded list;");
}


var itemsData = []; // Большой массив с данными о предметах, находящихся в инвентаре.
/*
*	Скрипты модального окна сохранения инвентаря.
*/

// Скрипт выбора предмета по которому нажали.
function modal_select_item(min_item_id){
	var id = min_item_id.substr(9);
	if($('#' + min_item_id).hasClass('selected')){
		$('#' + min_item_id).removeClass('selected');
	}else{
		$('#' + min_item_id).addClass('selected');	
	}
	//	Выводим предмет на превью.
		$("#preview-img").attr("src", itemsData[id]['image']);
		$("#preview-name").html(itemsData[id]['name']);
		$("#preview-quality").html("Exterior:" + itemsData[id]['quality']);
		$("#preview-description").html(itemsData[id]['description']);
		$("#preview-collection").html(itemsData[id]['collection']);
		$("#preview-cache-expiration").html(itemsData[id]['cache_expiration']);
		//$("#preview-link").attr("src", itemsData[id]['link']);
}
// Скрипт выполнения всех операций в модальном окне.
function action_modalWindow(action){
	var items = null;
	$.ajax({
		url: 'pages/search/tm_to_steam/remember_inventory.php', 
		cache: false,
		type:'POST',
		dataType: 'json',
		data:{"t_action":action,"t_items":items},
		success: function(response){
			if(action == "upload-inventory"){
				document.getElementById('min-itemsList').innerHTML = response.min_items_content;
				itemsData = response.itemsData;
			}
			if(action == "clear-all"){
				document.getElementById('min-itemsList').innerHTML = '<h6>Click "Refresh" to upload your inventory.</h6>';
				alert(response);
			}
			if( (action == "remember-all") || (action == "remember-selected") ){
				alert(response);
			}
		}
	});
}
// Открываем модальное окно.
function open_modalWindow(){
	$("#block-remember-items").fadeIn("fast");
	$("#transparent-bg").fadeIn("fast");
}
// Закрываем модальное окно.
function close_modalWindow(){
	$("#block-remember-items").fadeOut("fast");
	$("#transparent-bg").fadeOut("fast");
}




var weapon = document.getElementById("Weapon");
window.weapon_name = document.getElementById("Name");
var quality = document.getElementById("Quality");
var category = document.getElementById("Category");
var type = document.getElementById("Type");
var lower_limit = 0;//первоначальная граница загрузки.

$(document).ready(function(){
	//Скрываем прелоадер
   $("#load_search_AND_buy").hide();
   $("#load_withdrawel").hide();
   $("#load_reception").hide();
   $("#load_steamsell").hide();
   $("#load_reLogin").hide();
   $("#load_online").hide();
   $("#load_icon").hide();
   $("#load_activeItems").hide();
   $("#load_action_EnterList").hide();
   $("#refresh_ballance_TM").hide();
   $("#refresh_ballance_Steam").hide();
   //Считаем количество предметов, доступных к поиску.
   $.ajax({
		url: 'pages/search/tm_to_steam/search_quantity.php', 
		cache: false,
		type:'POST',
		dataType: 'json',
		data:{"tweapon": weapon.value, "tname": window.weapon_name.value, "tquality": quality.value, "tcategory": category.value, "ttype": type.value},
		success: function(response){
			document.getElementById('amount_serch_items').innerHTML = response;
		}
	});
});

//	Обработчики событий смены параметров поиска.
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
				url: 'pages/search/tm_to_steam/search_quantity.php', 
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
		url: 'pages/search/tm_to_steam/search_quantity.php', 
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
		url: 'pages/search/tm_to_steam/search_quantity.php', 
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
		url: 'pages/search/tm_to_steam/search_quantity.php', 
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
		url: 'pages/search/tm_to_steam/search_quantity.php', 
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
//Скрывем и раскрываем доп. опции
$('#trigger_right').click(function() {
	if(document.getElementById('add_menu').style.display != 'none'){
		document.getElementById('add_menu').style.display = 'none';
		document.getElementById('io').style.width = '99%';
		document.getElementById('trigger_right').classList.add('open_right_col_closed');
	}else{
		document.getElementById('add_menu').style.display = 'block';
		document.getElementById('io').style.width = '80%';
		document.getElementById('trigger_right').classList.remove('open_right_col_closed');
	}
});


var bot_id = 'CSGOTM_profitable';
document.getElementById(bot_id).style.boxShadow = '0 0 10px 5px #737373';
function selected(botID,id){
	bot_id = botID;
	var container = document.querySelectorAll('.container');
	for (var i = 0; i < container.length; i++) {
    	container[i].style.boxShadow = "none";
  	} 
	document.getElementById(id).style.boxShadow = '0 0 10px 5px #737373';
}

var AutoTrade = "No";
$(function(){
   $("#downloading").click(function(){ //Выполняем если по кнопке кликнули
	downloading();
    });
});

/* Добавление контента в начало блока.*/
function add_to_start(item_id,content){
	document.getElementById('log_tmp').innerHTML = document.getElementById(item_id).innerHTML;
	document.getElementById(item_id).innerHTML = content + document.getElementById('log_tmp').innerHTML;
}

var downloading_FLAG = true;//Объявляем флаг занятости функции подгрузки новых предметовю.
function downloading(){
	if(downloading_FLAG){
		downloading_FLAG = false;//Показываем то что функция выполняется.
		$("#imgLoad").show(); //Показываем прелоадер
		var AutoTrade = "Unknown";
		if($('#auto_trade').prop('checked')){
			AutoTrade = "Yes";
		}else {
			AutoTrade = "No";
		}
		var amount = document.getElementById("amount_upload_items").value;
		var lower_limit = document.getElementById('download_items_from').value;
		//	Получим количество предметов в нашем листе.
		var amount_all_items = document.getElementById('amountItems_EnterList').innerHTML;
		var minimum_percentage = document.getElementById('items_start_profit').value;
		$("#load_search_AND_buy").show();
		$("#load_icon").show();
		 $.ajax({
			url: "pages/search/tm_to_steam/TmToSteam.php",
			type: "POST",
			data: {"amount":amount,"lower_limit": lower_limit, "bot_id": bot_id, "auto_trade": AutoTrade, "minimum_percentage": minimum_percentage,"tweapon": weapon.value, "tname": window.weapon_name.value, "tquality": quality.value, "tcategory": category.value, "ttype": type.value},
			cache: false,
			dataType: 'json',
			success: function(response){
				if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие 
					error = '<p>Fatal error!</p>';
					add_to_start("log",error);
				}else{
					if(response.items == ""){
						error = '<p>' + response.time +'Items not found. Problem with geting market hash name from csgotm! It is recommended that you check the search conditions.</p>';
						add_to_start("log",error);
						lower_limit = Number(lower_limit) + Number(amount);
					}else{//Успешное выполнение.
						document.getElementById('result_table').innerHTML += response.items;
						lower_limit = Number(lower_limit) + Number(amount);
						if(lower_limit - 1 >= amount_all_items){
							if($('#loading_items_by_circle').prop('checked')){
								lower_limit = 0;
							}
						}
						add_to_start("log",response.logs);
						add_to_start("log",response.buy_log);
					}
					document.getElementById('download_items_from').value = lower_limit;
					var tmp = '<p>' + response.steam_getPrice_log + '</p>';
					add_to_start("full_log",tmp);
					document.getElementById('proxy_address').innerHTML = response.proxy_address;
				}
				$("#load_search_AND_buy").hide();
				$("#load_icon").hide();
				downloading_FLAG = true;//Освобождаем функцию.
			 }
		  });
	}	
}

//	Обновление цены предмета
function update_itemPrices(id){
		$.ajax({
			type: "POST",
			cache: false,
			url: 'pages/search/tm_to_steam/update.php', 
			dataType: 'json',
			data:{tid:id},
			success: function(response){
				
				document.getElementById('priceTm' + id).innerHTML = response.priceTm;
				document.getElementById('priceSteamMedian' + id).innerHTML = response.priceSteamMedian;
				document.getElementById('priceSteamReal' + id).innerHTML = response.priceSteamReal;
				document.getElementById('TmToSteam' + id).innerHTML = response.TmToSteam;
				if(document.getElementById('TmToSteam' + id).classList.contains("green")){
					if(response.TmToSteam_class == "red"){
						document.getElementById('TmToSteam' + id).classList.remove("green");
						document.getElementById('TmToSteam' + id).classList.add("red");
					}
				}else{
					if(response.TmToSteam_class == "green"){
						document.getElementById('TmToSteam' + id).classList.remove("red");
						document.getElementById('TmToSteam' + id).classList.add("green");
					}
				}
				document.getElementById('buy_item' + id).innerHTML = response.Buy_response_field;
				
				add_to_start("log",response.UpdateLog);
				
			}
		});
}
//
//помещаем предмет в список выгодных вещей
function placeItem(classid_instanceid){
	$.ajax({
		type: "POST",
		url: 'pages/lists/placeItem_ourList.php', 
		cache: false,
		dataType: 'json',
		data:{tclassid_instanceid:classid_instanceid},
		success: function(){
			document.getElementById('update'+classid_instanceid).style.color = "#ddd";
		}
	});	
}

function buyItem(classid_instanceid, market_hash_name, buy_price, sell_price){
	$.ajax({
		type: "POST",
		url: 'pages/search/tm_to_steam/buy_item.php', 
		cache: false,
		dataType: 'json',
		data:{tclassid_instanceid:classid_instanceid, tmarket_hash_name:market_hash_name, t_buy_price:buy_price, t_sell_price:sell_price},
		success: function(response){
			add_to_start("log",response);
			update_itemPrices(classid_instanceid);
		}
	});	
}

//функция переключения между источниками поиска в хедере.
function selectBlock(id){
	var fields = document.querySelectorAll('.select_field');
	var buttons = document.querySelectorAll('.select_button');
	for (var i = 0; i < buttons.length; i++) {//Скрываем и опускаем все блоки и кнопки.
    	fields[i].style.display = "none";
		buttons[i].style.zIndex = "1";
  	} 
	document.getElementById(id+'_field').style.display = 'block';//Показывем выбранный блок.
	document.getElementById(id).style.zIndex = '3';//Поднимаем нажатую кнопку.
}
//Функция сортировки. Type-тип сортировки(1-по возростанию, 2-по убыванию).
function sortingBy(collomn,type){

	var table = document.getElementById('sort_result');
	/*if(table.innerHTML == ""){//Если это не первый запуск функции, то переносим значения из таблици преобразованных значений в первоначальную таблицу.
		table.innerHTML = document.getElementById('result_table').innerHTML;
	}*/
	table.innerHTML = document.getElementById('result_table').innerHTML;
	document.getElementById('result_table').innerHTML = '';//Очищаем первоначальную таблицу.
	var sum =0,tri=0,tdi=0,final,content;
	var array = [];
	var flagArray = [];
	var rows = table.rows.length;//Количество строк.
	for(i = 0; i<rows; i++){//Инициализируем массив со всеми нулевыми значениями.
		flagArray[i] = 0;
	}
	for(i=0;i<rows-1;i++){//Построение массива данных.
		var tr1 = table.getElementsByTagName("td")[collomn+(i*15)];//Опрашиваем все ячейки нужного столбца, чтобы достать из них данные.
		array[i] = parseFloat(tr1.innerHTML);//Строим массив со значениями.
	}
	var sortArray = array.sort(//Сортируем по возростанию или убыванию.
		function(a, b){
			if(type == "1"){
				return a-b;//По возростанию.
			}else{
				return b-a;//По убыванию.
			}	
		}
	);
	//Добавляем таблице шапку.
	document.getElementById('result_table').innerHTML = '<tr><th class="pointed" onClick="sortingBy(0,1)" onDblClick="sortingBy(0,2)">#</th><th>Img:</th><th>Name:</th><th class="pointed" onClick="sortingBy(3,1)" onDblClick="sortingBy(3,2)">Min<br>price TM:</th><th class="pointed" onClick="sortingBy(4,1)" onDblClick="sortingBy(4,2)">Steam<br>lowest:</th><th class="pointed" onClick="sortingBy(5,1)" onDblClick="sortingBy(5,2)">Steam<br>median:</th><th class="pointed" onClick="sortingBy(6,1)" onDblClick="sortingBy(6,2)">TM->Steam[%]:</th><th>csgo.Tm<br>link:</th><th>Steam<br>link:</th><th>Update:</th><th>Buy:</th><th>Remember:</th><th class="pointed" onClick="sortingBy(10,1)" onDblClick="sortingBy(10,2)">Steam<br>volume:</th><th>Status:</th></tr>';
	
	for(i=0;i<sortArray.length;i++){//Перебор всех числел, которые мы построили в определенном порядке.
		for(j=0;j<=sortArray.length;j++){//Перебор всех строк, для сравнения и определения где какая.
			tri = table.getElementsByTagName("tr")[1+j];//Все строки.
			tdi = table.getElementsByTagName("td")[collomn+(j*15)];//Все значения в ячейках.
			final = parseFloat(tdi.innerHTML);//Это число в текущей строке.
			if( (final == sortArray[i]) && (flagArray[j] != 1) ){//Если цифра в сортировке совпадает с числом в строке то выводим и проверяем на повтор.
				flagArray[j] = 1;//Флаг проверки, вывели ли мы эту строку.
				document.getElementById('result_table').innerHTML += tri.innerHTML;//Выводим строку.
				break;
			}
		}	
	}
	document.getElementById('sort_result').innerHTML = '';//Очищаем первоначальную таблицу.
	//Работае с внешним видом заголовков колонок.
	var table1 = document.getElementById("result_table");
	var th = table1.getElementsByTagName("th")[collomn];
	th.style = "color:#ccc;";
}


$(document).ready(function(){
    $("#profile_header_settings").hide();  
});
//Функция отчищает таблицу результатов.
function clear_table(){
	num = 0;
	document.getElementById('result_table').innerHTML = '<tr><th class="pointed" onClick="sortingBy(0,1)" onDblClick="sortingBy(0,2)">#</th><th>Img:</th><th>Name:</th><th class="pointed" onClick="sortingBy(3,1)" onDblClick="sortingBy(3,2)">Min<br>price TM:</th><th class="pointed" onClick="sortingBy(4,1)" onDblClick="sortingBy(4,2)">Steam<br>lowest:</th><th class="pointed" onClick="sortingBy(5,1)" onDblClick="sortingBy(5,2)">Steam<br>median:</th><th class="pointed" onClick="sortingBy(6,1)" onDblClick="sortingBy(6,2)">TM->Steam[%]:</th><th>csgo.Tm<br>link:</th><th>Steam<br>link:</th><th>Update:</th><th>Buy:</th><th>Remember:</th><th class="pointed" onClick="sortingBy(10,1)" onDblClick="sortingBy(10,2)">Steam<br>volume:</th><th>Status:</th></tr>';
	
}
function clear_log(){
	
}

//Реализация режима онлайн. Каждые 3 минуты скрипт отправляет на сервер запрос онлайна.
function online() { 
$("#load_online").show();
$("#load_icon").show();
	$.ajax({
		type: "POST",
		url: 'pages/autotrading/online.php', 
		dataType: 'json',
		success: function(response){
			add_to_start("log",response);
		}
	});
$("#load_online").hide();
$("#load_icon").hide();
}

/* Вывод купленного предмета, функция состоит из двух основных частей.
1. Отправляем запрос на TM на вывод купленных вещей.(withdrawel.php)
2. Принимаем трейд оффер.(reception.php)
 */
function withdrawel(){
	if($('#auto_withdrawel').prop('checked')) {
		withdrawel_FLAG = false;//Показываем то что функция выполняется.
		$("#load_withdrawel").show();
		$("#withdrawel_load").show();
		$("#load_icon").show();
  		$.ajax({
		url: 'pages/autotrading/withdrawel.php', 
		cache: false,
		dataType: 'json',
		success: function(response){
			$("#load_withdrawel").hide();
			$("#withdrawel_load").hide();
			$("#load_icon").hide();
			
			if(response.success){//Считаем количество успешных запросов.
				withdrawel_counter++;//Счетчик количества успешных запросов.
			}
			resp = "<p>" + response.withdrawel_log + "</p>";
			add_to_start("log",resp);
			//$("#log").append("<p>" + response.withdrawel_log + "</p>");
			$("#load_reception").show();
			$("#load_icon").show();
			$.ajax({
				type: "POST",
				url:"pages/autotrading/reception.php",
				cache:false,
				dataType:"json",
				data:
					{
						ttradeofferId:response.tradeofferId,
						tpartner:response.partner,
						tstatus:response.status
					},
				success: function(res){
					$("#load_icon").hide();
					$("#load_reception").hide();
					resp = "<p>" + res.confirmation_log + "</p>";
					add_to_start("log",resp);
					//$("#log").append("<p>" + res.confirmation_log + "</p>");
					withdrawel_FLAG = true;
				}
			});	
		}
	});
	}	
}

// Продаже вещей в стиме.
function steamsell(){
	$("#steamsell_load").show();
	$("#load_steamsell").show();
	$("#load_icon").show();
	$.ajax({
		type: "POST",
		url: 'pages/autotrading/steamsell.php', 
		cache: false,
		dataType: 'json',
		data: {},
		success: function(response){
			$("#steamsell_load").hide();
			$("#load_steamsell").hide();
			$("#load_icon").hide();
			resp = "<p>" + response.steamsell_log + "</p>";
			add_to_start("log",resp);
			//$("#log").append("<p>" + response.steamsell_log + "</p>");
		}
	});	
}

// Продаже вещей в стиме.
function steamsellALL(){
	$("#steamsell_load").show();
	$("#load_steamsell").show();
	$("#load_icon").show();
	$.ajax({
		type: "POST",
		url: 'pages/autotrading/steamsellALL.php', 
		cache: false,
		dataType: 'json',
		data: {},
		success: function(response){
			$("#steamsell_load").hide();
			$("#load_steamsell").hide();
			$("#load_icon").hide();
			resp = "<p>" + response.steamsell_log + "</p>";
			add_to_start("log",resp);
			//$("#log").append("<p>" + response.steamsell_log + "</p>");
		}
	});	
}


/*Обновление сессионных файлов*/
function re_login(){
	$("#load_reLogin").show();
	$("#load_icon").show();
	$.ajax({
		url: 're_login.php', 
		cache: false,
		dataType: 'json',
		success: function(response){
			$("#load_reLogin").hide();
			$("#load_icon").hide();
			resp = "<p>" + response.status + "</p>";
			add_to_start("log",resp);
			$("#STtoTM_log").append("<p>" + response.status + "</p>");// Для страницы Steam->TM
		}
	});	
}

//	Обновление списка активных предметов TM.
function refresh_activeItems_CSGOTM(){
	$("#load_activeItems").show();
	$("#load_icon").show();
	refresh_activeItems_FLAG = false;
	$.ajax({
		url: 'pages/autotrading/activeItems_CSGOTM.php', 
		cache: false,
		dataType: 'json',
		success: function(response){
			$("#load_activeItems").hide();
			$("#load_icon").hide();
			document.getElementById('activeItems_CSGOTM').innerHTML = response.itemsInfo;
			var logs = "<p>" + response.time + " Refreshing active items success.</p>";
			add_to_start("log",logs);
			refresh_activeItems_FLAG = true;
		}
	});	
}
// Запоминает инвернарь в данный момент, для дальнейшего предотвращения продажи этих предметов.
function remember(){
	$.ajax({
		url: 'pages/autotrading/remember_inventory.php', 
		cache: false,
		dataType: 'json',
		success: function(response){
			//document.getElementById('current_ballance_TM').innerHTML = response;
			var logs = "<p> Remember your inventory success.</p>";
			add_to_start("log",logs);
		}
	});	
}

//	Обновление балланса TM.
function refresh_ballance_TM(){
	$("#refresh_ballance_TM").show();
	$("#load_icon").show();
	refresh_user_cash_FLAG = false;
	$.ajax({
		url: 'pages/search/tm_to_steam/refresh_cash_TM.php', 
		cache: false,
		dataType: 'json',
		success: function(response){
			$("#refresh_ballance_TM").hide();
			$("#load_icon").hide();
			document.getElementById('current_ballance_TM').innerHTML = response.cash;
			var logs = "<p>" + response.time + " Refreshing cash success. Your ballance: " + response.cash + ".</p>";
			add_to_start("log",logs);
			refresh_user_cash_FLAG = true;
		}
	});	
}

//	Обновление балланса Steam.
function refresh_ballance_Steam(){
	$("#refresh_ballance_Steam").show();
	$("#load_icon").show();
	refresh_user_cash_FLAG = false;
	$.ajax({
		url: 'pages/search/tm_to_steam/refresh_cash_Steam.php', 
		cache: false,
		dataType: 'json',
		success: function(response){
			$("#refresh_ballance_Steam").hide();
			$("#load_icon").hide();
			document.getElementById('current_ballance_Steam').innerHTML = response.cash;
			var logs = "<p>" + response.time + " Refreshing Steam cash success. Your ballance: " + response.cash + ".</p>";
			add_to_start("log",logs);
			refresh_user_cash_FLAG = true;
		}
	});	
}

/*
*	Флаги для отслеживания выполнения запросов, предотвращающие 
*	множественные запросы разных функций.
*	запросы выполняются асинхронно, последовательно друг за другом.
*	Значения флагов: true-функция не выполняется, false-выполняется.
*/
var withdrawel_FLAG = true;//Флаг, отвечающий за доступность функции withdrawel
var steamsell_FLAG = true;//Флаг, отвечающий за доступность функции steamsell
var refresh_activeItems_FLAG = true;//Флаг, отвечающий за доступность функции refresh_activeItems_CSGOTM

/*	Прочие вспомогательные переменные.	*/
var withdrawel_counter = 0;//Счетчик количества выполненых запросов на вывод.

/*
*	Функция возвращает true, если в настоящее время не выполняется ни один запрос.
*/
function availability_of_request(){
	if(withdrawel_FLAG && steamsell_FLAG){
		flag = true;
	}else{
		flag = false;
	}
	return flag;
}




/*Выполняем действие если имеются предметы для вывода с CSGOTM*/
setInterval(function(){
	if(withdrawel_FLAG && refresh_activeItems_FLAG){//Если не выполняется функция withdrawel
		if($('#activate_auto_loading').prop('checked')){//Если стооит доп. галочка активации подгрузки.
			refresh_activeItems_CSGOTM();//Обновляем содержимое блока activeItems_CSGOTM.
		}
	}
	
	/*
	*	Выполняем функцию withdrawel, если прошлая отправка 
	*	завершена и есть предметы готовые к выводу
	*/
	if(withdrawel_FLAG){//Если не выполняется функция withdrawel
		var actionItems = new Array();//Массив текущих действий, выполняемых с предметом.
		var container = document.querySelectorAll('.active_item_CSGOTM_action b');//Читаем содержимое всех блоков.
		for (var i = 0; i < container.length; i++){//Перебираем все блоки для нахождения предмета готового к выводу.
			actionItems[i] = container[i].innerHTML;
			if(actionItems[i] == "GET"){
				withdrawel();//Производим запрос на вывод предмета и подтверждаем трейдоффер.
				break;
			}
  		}
	}
	/*
	*	Если не выполняются запросы к серверу маркета, и если количество
	*	успешных запросов больше 2х, Делаем запрос на продажу предметов в STEAM.
	*/
	if(availability_of_request()){
		if(withdrawel_counter >= 2){
			steamsell_FLAG = false;//Функция steamsell заняла место.
			//console.log("Go steamsell function.");
			steamsell();//Продаем предметы.
			withdrawel_counter = 0;//Обнуляем счетчик.
		}
	}
	
	
},15000) ;


//	Автоматическая подгрузка вещей, удовлетворяющих указанным условиям поиска.
setInterval(function(){
	if($('#search_upload_items').prop('checked')){
		if(downloading_FLAG){
			downloading();
		}
	}
}
,6000);

//	Автоматический вывод предметов. Реализованно в конце search_TMtoSteam

//	Автоматическая продажа выведенных веще в STEAMе. Выполняется каждые 4 минуты.
setInterval(function(){
	if($('#auto_sell_items_in_steam').prop('checked')){
		steamsell();
	}
}
,240000);

//	Автоматическая покупка предметов при их нахождении. Реализованно в функции downloading().

//	Автоматический ре-логин в Стиме, Выплняется каждые 7 минут.
setInterval(function(){
	if($('#auto_login_in_steam').prop('checked')){
		re_login();
	}
}
,420000);

//	Автоматическая отчистка таблицы результатов и лога.
setInterval(function(){
	if($('#auto_clear_tableANDlog').prop('checked')){
		clear_log();
		//clear_table();
	}
}
,1800000);


//	Автоматическая отправка online запросов.
setInterval(function(){
	if($('#auto_send_online_request').prop('checked')){
		online();
	}
}
,180000);

//	Обновление баланса TM.
setInterval(function(){
	if($('#auto_refresh_user_cash').prop('checked')){
		refresh_ballance_TM();
		//	Обновление баланса Steam.
		refresh_ballance_Steam();
	}
}
,190000);


</script>