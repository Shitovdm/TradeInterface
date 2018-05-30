<?php
/*
*	Скрипт вытаскивает из Стима список выставленных ордеров.
*	
*
*/
// Сессия для получения куков.
session_start();
$cookie_path = "../../auth/cookie_" . $_SESSION["steamid"] . "/h2px74b0c98dn2m11.txt";
/*	Запрос к маркеты стима для получения исходного кода страницы.
*	В запросе в качестве куков используются записи, сделанные скриптом main.php при авторизации.
*	Для успешной работы скрипта необходимо заходить на страницу скрипта только из под index.php.
*/
$url = "http://steamcommunity.com/market/";
$c = curl_init();
curl_setopt($c, CURLOPT_HEADER, false);
curl_setopt($c, CURLOPT_NOBODY, false);
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)");
//curl_setopt($c, CURLOPT_COOKIEFILE, '../../../cookiejar.txt'); //Для скрипта , выполняющегося не из под index.php
curl_setopt($c, CURLOPT_COOKIEFILE, $cookie_path);
curl_setopt($c, CURLOPT_HTTPHEADER, array('Referer: http://store.steampowered.com/?l=russian'));
curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$output_curl = curl_exec($c);
curl_close($c);
	
	//	Вытаскиваем балланс.
	$preg_item_CLASS_INSTANCE = preg_match_all(("/(marketWalletBalanceAmount\">)[0-9.,]{1,}/"),(string)$output_curl, $item_CLASS_INSTANCE);
	for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
		$ballance = str_replace(",", ".", substr($item_CLASS_INSTANCE[0][$i],27));
	}
	
	// Вытаскиваем из кода страницы данные.
	// Вытаскиваем номер ордера.
	$orderNumberAmount = 0;
	$preg_item_CLASS_INSTANCE = preg_match_all(("/(mbuyorder_)[0-9]{2,}/"),(string)$output_curl, $item_CLASS_INSTANCE);
	for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
		//$classid_instanceid[$i]=substr(substr($item_CLASS_INSTANCE[0][$i],0,-1),11);
		$order_number[$i]=substr($item_CLASS_INSTANCE[0][$i],10);
		$orderNumberAmount++;
	}
	
	// Количество предметов которые, были выставлены мной на продажу.
	
	// Вытаскиваем количество.
	$preg_item_CLASS_INSTANCE = preg_match_all(("/(<span id=\"my_market_selllistings_number\">)[0-9]{1,}/"),(string)$output_curl, $item_CLASS_INSTANCE);
	for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
		$sell_order_amount=substr($item_CLASS_INSTANCE[0][$i],41);	
	}
	
	
	// Вытаскиваем название предмета.
	$namesAmount = 0;
	$preg_item_CLASS_INSTANCE = preg_match_all(("/(<a class=\"market_listing_item_name_link\" href=\")[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхчшщъыьэюя弐0-9a-zA-Z:\/.%->|\"\s]{2,}/"),(string)$output_curl, $item_CLASS_INSTANCE);
	for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
		$tmp[$i]=$item_CLASS_INSTANCE[0][$i];
		$order_link[$i] = $tmp[$i];
		$preg_tmp = preg_match_all(("/(\>)[АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхчшщъыьэюя弐0-9a-zA-Z:\/.%-|\"\s]{2,}/"),(string)$tmp[$i], $preg_order_name);
		for ($j = 0; $j < $preg_tmp; $j++){
			$order_name[$i]=substr($preg_order_name[0][$j],1);
			$namesAmount++;
		}
	}
	// Обрезаем элементы, которые относится к ордерам продажи а не покупки.
	$amountUnseting = $namesAmount - $orderNumberAmount;
	for($k = 0; $k < $orderNumberAmount; $k++){
		$order_name[$k] = $order_name[($amountUnseting + $k)];
	}
	
	
	// Вытаскиваем картинку предмета.
	$preg_item_CLASS_INSTANCE = preg_match_all(("/(<img id=\"mybuyorder_)[0-9a-zA-Z\"_\s:\/-=.-]{2,}(srcset)/"),(string)$output_curl, $item_CLASS_INSTANCE);
	for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
		$tmp[$i]=$item_CLASS_INSTANCE[0][$i];
		$preg_order_img = preg_match_all(("/(src=\")[0-9a-zA-Z_\s:\/-=.-]{2,}/"),(string)$tmp[$i], $item_order_img);
		for ($j = 0; $j < $preg_order_img; $j++){
			$order_img_src[$i]=substr($item_order_img[0][$j],5);
		}
	}

	// Вытаскиваем количество.
	$preg_item_CLASS_INSTANCE = preg_match_all(("/(<span class=\"market_listing_inline_buyorder_qty\">)[0-9]{1}/"),(string)$output_curl, $item_CLASS_INSTANCE);
	for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
		$order_amount[$i]=(int)substr($item_CLASS_INSTANCE[0][$i],49);	
	}
	
	// Вытаскиваем цену запроса.
	$preg_item_CLASS_INSTANCE = preg_match_all(("/(@<\/span>)[a-z0-9руб\s.,]{1,}/"),(string)$output_curl, $item_CLASS_INSTANCE);
	for ($i = 0; $i < $preg_item_CLASS_INSTANCE; $i++){
		$order_price_only_numeric[$i] = (float)str_replace(",", ".", substr($item_CLASS_INSTANCE[0][$i],8,-10));	
	}
	$order_game = 'Counter-Strike: Global Offensive';
	//	Строим вывод.
	
	$data = '<tr><th colspan="4">My buy orders (<b id="amount_mybyuorders">0</b>)<b style="float:right; margin-right:20px;">Ballance: '.$ballance.'</b></th></tr><tr><th>Name</th><th>Amount</th><th>Price</th><th></th></tr>';
	for($i=0;$i<count($order_number);$i++){
		$data .= '<td><div><div class="mybuyorder_img">';
		$data .= '<small style="color:#EBEBEB;float:left;position:absolute;margin-top:31px;">' . ($i+1) . '</small>';
		$data .= '<img src="' . $order_img_src[$i] . '" width="42px" height="42px"></div>';
		$data .= '<div class="mybuyorder_info"><div class="mybuyorder_name">';
		$data .= '<a target="_blank" href="http://steamcommunity.com/market/">' . substr($order_name[$i], 0 ,-20) . '</a></div>';
		$data .= '<div class="clear"></div>';
		$data .= '<div class="mybuyorder_info_game">' . $order_game . "</div></div></td>";
		$data .= '<td><span>' . $order_amount[$i] . '</span></td>';
		$data .= '<td><span>' . $order_price_only_numeric[$i] . ' rub </span></td>';
		$data .= '<td><span><div class="pointed" onClick="delete_mybuyorder(\'' . $order_number[$i] . '\')">Cancel</div></span></td></tr>';
		
	}
	$data .= '<tr><th colspan="4"></th></tr>';
$response = array(
	'amount' => count($order_number),
	'data' => $data,
	'status' => $ballance
);
	echo json_encode($response);
	
?>