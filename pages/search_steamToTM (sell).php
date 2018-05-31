<?php

if(!isset($_SESSION['steamid'])){
	header('Location: /index.php?page=access_denied.php');
}else{
	$steamid = $_SESSION['steamid'];
}
?>

<div class="steamToTM_sell_main">
     <div class="steamToTM_sell_control_panel">
     	<div class="steamToTM_sell_control_panel_param">
     		<div class="process_steamTOTm_sell" id="process_steamTOtm (sell)">
            	<b>Current action:</b>
            	<div id="load_user_inventory"><b>Load user inventory...</b></div>
                <div id="refresh_prices_user_inventory"><b>Refreshing prices...</b></div>
                <div id="get_discount_user_inventory"><b>Getting discount...</b></div>
                <div id="calculating_user_inventory"><b>Calculating...</b></div>
            	<img src="images/preloaders/preloader_2.gif" id="load_icon">
       	 </div>
        </div>
     	<div class="steamToTM_sell_control_panel_param">
        	<b>Your SteamID:</b>
            <input id="steamId_field" type="text" value="<?php echo($_SESSION['steamid']);?>">
        </div>
        <div class="steamToTM_sell_control_panel_param">
        	<b>Load inventory:</b>
            <input type="button" onclick="steamToTM_sell_load_inventory()" name="load_user_inventory" value="Upload">
        </div>
        <div class="steamToTM_sell_control_panel_param">
        	<b>Hide not commodity items:</b>
            <input type="checkbox" checked>
        </div>
        <div class="steamToTM_sell_control_panel_param">
        	<b>Auto load prices:</b>
            <input type="checkbox">
        </div>
        <div class="steamToTM_sell_control_panel_param">
        	<b>Get discount:</b>
            <input type="button" onclick="get_discount()" value="Get">
            <p>
            	<b>Discount on purchase: </b><b id="buy_discount">-</b><br>
                <b>Discount for sale: </b><b id="sell_fee">-</b>
            </p>
        </div>
        <div class="steamToTM_sell_control_panel_param quick_calc">
        	<b id="quick_calc_header">Quick calc:</b><br>
            <b>Buy price:</b>
            <input id="quick_calc_buy_price" type="text" placeholder="00.00" onChange="quick_calc()"><br>
            <b>Sell price</b>
            <input id="quick_calc_sell_price" type="text" placeholder="00.00" onChange="quick_calc()"><br>
            <b id="quick_calc_result">NaN</b>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="steamToTM_sell_control_panel_param quick_calc">
            <b>Number:</b>
            <input id="quick_calc_buy_price_2" type="text" placeholder="00.00" onChange="quick_calc()"><br>
            <b>Percent:</b>
            <input id="quick_calc_sell_price_2" type="text" placeholder="00.00" onChange="quick_calc()"><br>
            <b id="quick_calc_result_2">NaN</b>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="steamToTM_sell_control_panel_param quick_calc">
        	<p>Paste bought items into database on <a href="index.php?page=pages/item_info_STtoTM.php" target="_blank">page</a></p>
        </div>
    </div>


	<div class="steamToTM_sell_user_items_table">
    	<div class="steamToTM_sell_table">
            <table id="steamToTM_sell_table_id" class="simple-little-table">
                <tbody>
                    <tr>
                        <th class="steamToTM_sell_cell_th">Image:</th>
                        <td id="Image:_310786355-0" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/310786355-0-PP-Bizon | Modern Hunter (Field-Tested)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/PP-Bizon | Modern Hunter (Field-Tested)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpotLO_JAlf2-r3eShM-Nmkq42Ek_LmPYTck29Y_chOhujT8om7igXiqko4ZD3yJNfEewc-NAvWqAe8kL3pg8K8uZ-czXQx6SJwt3qIzgv330_ujn9SNQ/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_310810067-0" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/310810067-0-P250 | Nuclear Threat (Battle-Scarred)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/P250 | Nuclear Threat (Battle-Scarred)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpopujwezhzw8zGZDZH_8iknZCOqPDmNr7fqWNU6dNoteXA54vwxgTl80o9ZD32ctPAcQZtaQ6EqVK5lObsgcO8tMufznsxvSVx5yqInhapwUYbh-Ttohg/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_992204697-519977179" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/992204697-519977179-Desert Eagle | Sunset Storm 弐 (Field-Tested)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/Desert Eagle | Sunset Storm 弐 (Field-Tested)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgposr-kLAtl7PLFTi5H7c-im5KGqOT8PLHeqWZU7Mxkh9bN9J7yjRqw8kQ6YGmmdYSVcwY2YVDR_QDtlLrqhcS1vJvOyiQyuyUi7SrcyRTin1gSOYWPW-cx/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2521767801-0" class="steamToTM_sell_cell">
                            <img src="images/icons/no_photo.png" width="150px;"></td>
                        <td id="Image:_519984334-519977179" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/519984334-519977179-P2000 | Chainmail (Minimal Wear)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/P2000 | Chainmail (Minimal Wear)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpovrG1eVcwg8zJfAJB5N2_mo2KnvvLP7LWnn9u5MRjjeyPp9rw0FDhrkNtMW-ico7BIQ47Mw3T_gLowOjnhpbp6pvLwXJivCZ0sWGdwULfMeVBVg/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_310776847-480085569" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/310776847-480085569-USP-S | Dark Water (Minimal Wear)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/USP-S | Dark Water (Minimal Wear)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpoo6m1FBRp3_bGcjhQ0927q5qOleX1DL_QhGBu5Mx2gv3--Y3nj1H6qhc4ZGn6doTAIAA2YlDV-Qe3xO7n0cLqtc7Ly3djuXQlsCmPlhy1hAYMMLLPDZXOFA/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2536383019-480085569-M4A4 | Zirka (Field-Tested)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/M4A4 | Zirka (Field-Tested)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpou-6kejhzw8zbZTxQ096klZaEqPrxN7LEm1Rd6dd2j6eT8I-iiQK2rUo6YWv0cNWVcgM_aV2GrwPrlbrvhpK1tZ7Mz3tj6SJx-z-DyOOk6P2x/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2536461826-188530139-M4A4 | Hellfire (Battle-Scarred)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/M4A4 | Hellfire (Battle-Scarred)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpou-6kejhjxszFJTwW09SzmIyNnuXxDLPUl31I18lwmO7Eu4nx0QWy-RZtMWuicoTGdA9qZQvYqQe9l-nqgp-07sjImyQ1snUg5HzD30vgPRZ0K_c/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2536468449-188530139-Nova | Ghost Camo (Minimal Wear)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/Nova | Ghost Camo (Minimal Wear)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpouLWzKjhzw8zLcDBN08u5m4S0lfvhNoTdn2xZ_Pp9i_vG8MLx3gex-0U9YGGmcoWcdFc3ZV2Erwfqxr3u1MK16MzAmyNks3Z343-JgVXp1jwjyNzI/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div><a href="https://market.csgo.com/item/2536447858-188530139-P2000 | Red FragCam (Field-Tested)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/P2000 | Red FragCam (Field-Tested)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpovrG1eVcwg8zAaAJS49Cvq4OKmvjLPr7Vn35c18lwmO7Eu9yg3Q3s-0U-MG_2IY7HdFBraVvV-gXswbjmjcLu6J_BzSNrunQq5SnD30vgSYWmWx8/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2536959719-188530139-P250 | Undertow (Field-Tested)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/P250 | Undertow (Field-Tested)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpopujwezhh3szYI2gS096zlYSOk8jkMrLfglRc7cF4n-T--Y3nj1H6qBc5az3zIoKUcQM6NQyF-lC2wujv1pC478jPwSFl63ZxsCnfmxa0ggYMMLI7UzsRBg/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2536551320-519977179-Desert Eagle | Sunset Storm 弐 (Battle-Scarred)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/Desert Eagle | Sunset Storm 弐 (Battle-Scarred)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgposr-kLAtl7PLFTi5H7c-im5KGqOT8PLHeqWNU6dNoteXA54vwxgyx_xFuYjj1d4KQelRoMA3TqFDtxOe6jZ7q6szIy3ZgvCFwsHaJmRKpwUYbGuFNcRU/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2537666435-188530139-P250 | Steel Disruption (Minimal Wear)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/P250 | Steel Disruption (Minimal Wear)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpopujwezhh3szMdS1D-NizmpOOqOT9P63UhFRd4cJ5ntbN9J7yjRrn_UFuYzvwLIKVew9rNV7RqVPsyLy-g5Lt6pXAwCBrsyJ34S7ZzBC_n1gSOZc29THf/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2537662881-519977179-Desert Eagle | Sunset Storm 弐 (Field-Tested)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/Desert Eagle | Sunset Storm 弐 (Field-Tested)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgposr-kLAtl7PLFTi5H7c-im5KGqOT8PLHeqWZU7Mxkh9bN9J7yjRqw8kQ6YGmmdYSVcwY2YVDR_QDtlLrqhcS1vJvOyiQyuyUi7SrcyRTin1gSOYWPW-cx/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2537991201-519977179-MAC-10 | Nuclear Garden (Battle-Scarred)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/MAC-10 | Nuclear Garden (Battle-Scarred)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpou7umeldf0v73fyhB4Nm3hr-YnOL4P6iCqWZQ65QhteHE9Jrst1i1uRQ5fW-hcILAcQdqZ1iB_ljqxOvm1sLu6c_JwXA2vnYh53iOmUa0gx8aardxxavJjH-kPLk/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2537718633-0-Five-SeveN | Jungle (Field-Tested)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/Five-SeveN | Jungle (Field-Tested)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgposLOzLhRlxfbGTi5N09ajmoeHksj5Nr_Yg2Zu5MRjjeyP99msiwDnrUM_ZG_xI9CUewNrYljR8lC8kOq61JW8tZycwHI3uCIh7WGdwULVYjnE5g/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2538749054-0-MAC-10 | Urban DDPAT (Battle-Scarred)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/MAC-10 | Urban DDPAT (Battle-Scarred)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpou7umeldf2-r3dTlS7ciJgZKJqP_xMq3IqWdQ-sJ0xLnEpNjx21G3qBI4MW-hdYadIQBoaF7TqQW-w-6608e86c-byCcwuCA8pSGKIWVWG2s/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2538099090-188530139-CZ75-Auto | Tread Plate (Field-Tested)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/CZ75-Auto | Tread Plate (Field-Tested)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpotaDyfgZf0v73dTRD4dO4kL-bm_bgNoTck29Y_chOhujT8om721ey-0VvMTzyLNfHcgM_MF-F_AW4xevn0Ze075yfyntkvXNx53zangv330-0qQ45jg/360fx360f" width="150px;">
                        </td>
                        <td id="Image:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <div>
                                <a href="https://market.csgo.com/item/2538764922-519977179-M4A4 | Radiation Hazard (Well-Worn)" target="_blank">TM</a>
                            </div>
                            <div>
                                <a href="http://steamcommunity.com/market/listings/730/M4A4 | Radiation Hazard (Well-Worn)" target="_blank">STEAM</a>
                            </div>
                            <img src="http://community.edgecast.steamstatic.com/economy/image/-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpou-6kejhzw8zGZDZH_8iknZCOqPjmMrXWk1Rc7cF4n-T--Y3nj1H6qBFoYWr0cdPHdgBoNFvY8wTslL-9h8Tq7p_AnXtgunYq43bUyhSz1QYMMLJner3f7w/360fx360f" width="150px;">
                        </td>
                    </tr>
                    <tr>
                        <th class="steamToTM_sell_cell_th">Name:</th>
                        <td id="Name:_310786355-0" class="steamToTM_sell_cell">PP-Bizon | Modern Hunter </td><td id="Name:_310810067-0" class="steamToTM_sell_cell">P250 | Nuclear Threat </td>
                        <td id="Name:_992204697-519977179" class="steamToTM_sell_cell">Desert Eagle | Sunset Storm 弐 </td>
                        <td id="Name:_2521767801-0" class="steamToTM_sell_cell"></td>
                        <td id="Name:_519984334-519977179" class="steamToTM_sell_cell">P2000 | Chainmail </td>
                        <td id="Name:_310776847-480085569" class="steamToTM_sell_cell">USP-S | Dark Water </td>
                        <td id="Name:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">M4A4 | Zirka </td>
                        <td id="Name:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">M4A4 | Hellfire </td>
                        <td id="Name:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Nova | Ghost Camo </td>
                        <td id="Name:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">P2000 | Red FragCam </td>
                        <td id="Name:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">P250 | Undertow </td>
                        <td id="Name:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Desert Eagle | Sunset Storm 弐 </td>
                        <td id="Name:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">P250 | Steel Disruption </td>
                        <td id="Name:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Desert Eagle | Sunset Storm 弐 </td>
                        <td id="Name:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">MAC-10 | Nuclear Garden </td>
                        <td id="Name:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">Five-SeveN | Jungle </td>
                        <td id="Name:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">MAC-10 | Urban DDPAT </td>
                        <td id="Name:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">CZ75-Auto | Tread Plate </td>
                        <td id="Name:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">M4A4 | Radiation Hazard </td>
                    </tr>
                    <tr>
                        <th class="steamToTM_sell_cell_th">Quality:</th>
                        <td id="Quality:_310786355-0" class="steamToTM_sell_cell">(Field-Tested)</td>
                        <td id="Quality:_310810067-0" class="steamToTM_sell_cell">(Battle-Scarred)</td>
                        <td id="Quality:_992204697-519977179" class="steamToTM_sell_cell">(Field-Tested)</td>
                        <td id="Quality:_2521767801-0" class="steamToTM_sell_cell">Spectrum 2 Case</td>
                        <td id="Quality:_519984334-519977179" class="steamToTM_sell_cell">(Minimal Wear)</td>
                        <td id="Quality:_310776847-480085569" class="steamToTM_sell_cell">(Minimal Wear)</td>
                        <td id="Quality:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">(Field-Tested)</td>
                        <td id="Quality:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">(Battle-Scarred)</td>
                        <td id="Quality:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">(Minimal Wear)</td>
                        <td id="Quality:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">(Field-Tested)</td>
                        <td id="Quality:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">(Field-Tested)</td>
                        <td id="Quality:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">(Battle-Scarred)</td>
                        <td id="Quality:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">(Minimal Wear)</td>
                        <td id="Quality:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">(Field-Tested)</td>
                        <td id="Quality:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">(Battle-Scarred)</td>
                        <td id="Quality:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">(Field-Tested)</td>
                        <td id="Quality:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">(Battle-Scarred)</td>
                        <td id="Quality:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">(Field-Tested)</td>
                        <td id="Quality:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">(Well-Worn)</td>
                    </tr>
                    <tr>
                        <th class="steamToTM_sell_cell_th">Price of bought:</th>
                        <td id="Price of bought:_310786355-0" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;310786355-0&quot;)" id="price_of_bought_310786355-0" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_310810067-0" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;310810067-0&quot;)" id="price_of_bought_310810067-0" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_992204697-519977179" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;992204697-519977179&quot;)" id="price_of_bought_992204697-519977179" style="text-align:center;height:20px;"></td>
                        <td id="Price of bought:_2521767801-0" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2521767801-0&quot;)" id="price_of_bought_2521767801-0" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_519984334-519977179" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;519984334-519977179&quot;)" id="price_of_bought_519984334-519977179" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_310776847-480085569" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;310776847-480085569&quot;)" id="price_of_bought_310776847-480085569" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2536383019-480085569&quot;)" id="price_of_bought_2536383019-480085569" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2536461826-188530139&quot;)" id="price_of_bought_2536461826-188530139" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2536468449-188530139&quot;)" id="price_of_bought_2536468449-188530139" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2536447858-188530139&quot;)" id="price_of_bought_2536447858-188530139" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2536959719-188530139&quot;)" id="price_of_bought_2536959719-188530139" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2536551320-519977179&quot;)" id="price_of_bought_2536551320-519977179" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2537666435-188530139&quot;)" id="price_of_bought_2537666435-188530139" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2537662881-519977179&quot;)" id="price_of_bought_2537662881-519977179" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2537991201-519977179&quot;)" id="price_of_bought_2537991201-519977179" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2537718633-0&quot;)" id="price_of_bought_2537718633-0" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2538749054-0&quot;)" id="price_of_bought_2538749054-0" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2538099090-188530139&quot;)" id="price_of_bought_2538099090-188530139" style="text-align:center;height:20px;">
                        </td>
                        <td id="Price of bought:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="text" placeholder="00.00" onchange="calculate(this.value,&quot;2538764922-519977179&quot;)" id="price_of_bought_2538764922-519977179" style="text-align:center;height:20px;">
                        </td>
                    </tr>
                    <tr>
                        <th class="steamToTM_sell_cell_th">Steam real:</th>
                        <td id="Steam real:_310786355-0" class="steamToTM_sell_cell">144.82</td>
                        <td id="Steam real:_310810067-0" class="steamToTM_sell_cell">341.49</td>
                        <td id="Steam real:_992204697-519977179" class="steamToTM_sell_cell">454.48</td>
                        <td id="Steam real:_2521767801-0" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_519984334-519977179" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_310776847-480085569" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam real:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                    </tr>
                    <tr>
                        <th class="steamToTM_sell_cell_th">ST⇒ST real:</th>
                        <td id="ST⇒ST real:_310786355-0" class="steamToTM_sell_cell" style="color: rgb(14, 204, 0);">18.01</td><td id="ST⇒ST real:_310810067-0" class="steamToTM_sell_cell" style="color: red;">-5.51</td>
                        <td id="ST⇒ST real:_992204697-519977179" class="steamToTM_sell_cell" style="color: red;">-5.44</td><td id="ST⇒ST real:_2521767801-0" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST real:_519984334-519977179" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST real:_310776847-480085569" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST real:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST real:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST real:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST real:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST real:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST real:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST real:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST real:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST real:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST real:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST real:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST real:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST real:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td></tr><tr><th class="steamToTM_sell_cell_th">ST⇒ST order:</th>
                        <td id="ST⇒ST order:_310786355-0" class="steamToTM_sell_cell" style="color: red;">-46.40</td><td id="ST⇒ST order:_310810067-0" class="steamToTM_sell_cell" style="color: red;">-21.33</td>
                        <td id="ST⇒ST order:_992204697-519977179" class="steamToTM_sell_cell" style="color: red;">-8.35</td><td id="ST⇒ST order:_2521767801-0" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST order:_519984334-519977179" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST order:_310776847-480085569" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST order:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST order:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST order:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST order:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST order:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST order:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST order:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST order:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST order:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST order:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST order:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒ST order:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒ST order:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td></tr><tr><th class="steamToTM_sell_cell_th">Steam order:</th>
                        <td id="Steam order:_310786355-0" class="steamToTM_sell_cell">65.78</td><td id="Steam order:_310810067-0" class="steamToTM_sell_cell">284.32</td>
                        <td id="Steam order:_992204697-519977179" class="steamToTM_sell_cell">440.5</td><td id="Steam order:_2521767801-0" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam order:_519984334-519977179" class="steamToTM_sell_cell">NaN</td><td id="Steam order:_310776847-480085569" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam order:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="Steam order:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam order:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="Steam order:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam order:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="Steam order:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam order:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="Steam order:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam order:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="Steam order:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam order:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="Steam order:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="Steam order:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td></tr><tr><th class="steamToTM_sell_cell_th">TM real:</th><td id="TM real:_310786355-0" class="steamToTM_sell_cell">103</td>
                        <td id="TM real:_310810067-0" class="steamToTM_sell_cell">310</td><td id="TM real:_992204697-519977179" class="steamToTM_sell_cell">450.35</td>
                        <td id="TM real:_2521767801-0" class="steamToTM_sell_cell">NaN</td><td id="TM real:_519984334-519977179" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM real:_310776847-480085569" class="steamToTM_sell_cell">NaN</td><td id="TM real:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM real:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="TM real:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM real:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="TM real:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM real:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="TM real:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM real:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="TM real:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM real:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="TM real:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM real:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td><td id="TM real:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                    </tr>
                    <tr>
                        <th class="steamToTM_sell_cell_th">TM order:</th>
                        <td id="TM order:_310786355-0" class="steamToTM_sell_cell">96.08</td><td id="TM order:_310810067-0" class="steamToTM_sell_cell">260.79</td>
                        <td id="TM order:_992204697-519977179" class="steamToTM_sell_cell">436.2</td>
                        <td id="TM order:_2521767801-0" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_519984334-519977179" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_310776847-480085569" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                        <td id="TM order:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">NaN</td>
                    </tr>
                    <tr>
                        <th class="steamToTM_sell_cell_th">ST⇒TM real:</th>
                        <td id="ST⇒TM real:_310786355-0" class="steamToTM_sell_cell" style="color: red;">-8.81</td>
                        <td id="ST⇒TM real:_310810067-0" class="steamToTM_sell_cell" style="color: red;">-6.81</td>
                        <td id="ST⇒TM real:_992204697-519977179" class="steamToTM_sell_cell" style="color: rgb(14, 204, 0);">1.80</td>
                        <td id="ST⇒TM real:_2521767801-0" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒TM real:_519984334-519977179" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_310776847-480085569" class="steamToTM_sell_cell">Unknown</td><td id="ST⇒TM real:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM real:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                    </tr>
                    <tr>
                        <th class="steamToTM_sell_cell_th">ST⇒TM order:</th>
                        <td id="ST⇒TM order:_310786355-0" class="steamToTM_sell_cell" style="color: red;">-14.94</td>
                        <td id="ST⇒TM order:_310810067-0" class="steamToTM_sell_cell" style="color: red;">-21.60</td>
                        <td id="ST⇒TM order:_992204697-519977179" class="steamToTM_sell_cell" style="color: red;">-1.40</td>
                        <td id="ST⇒TM order:_2521767801-0" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_519984334-519977179" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_310776847-480085569" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                        <td id="ST⇒TM order:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">Unknown</td>
                    </tr>
                    <tr>
                        <th class="steamToTM_sell_cell_th">Sell in Tm:</th>
                        <td id="Sell in Tm:_310786355-0" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;310786355-0&quot;)">
                        </td><td id="Sell in Tm:_310810067-0" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;310810067-0&quot;)">
                        </td>
                        <td id="Sell in Tm:_992204697-519977179" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;992204697-519977179&quot;)">
                        </td>
                        <td id="Sell in Tm:_2521767801-0" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2521767801-0&quot;)">
                        </td>
                        <td id="Sell in Tm:_519984334-519977179" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;519984334-519977179&quot;)">
                        </td>
                        <td id="Sell in Tm:_310776847-480085569" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;310776847-480085569&quot;)">
                        </td>
                        <td id="Sell in Tm:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2536383019-480085569&quot;)">
                        </td>
                        <td id="Sell in Tm:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2536461826-188530139&quot;)">
                        </td>
                        <td id="Sell in Tm:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2536468449-188530139&quot;)">
                        </td>
                        <td id="Sell in Tm:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2536447858-188530139&quot;)">
                        </td>
                        <td id="Sell in Tm:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2536959719-188530139&quot;)">
                        </td>
                        <td id="Sell in Tm:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2536551320-519977179&quot;)">
                        </td>
                        <td id="Sell in Tm:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2537666435-188530139&quot;)">
                        </td>
                        <td id="Sell in Tm:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2537662881-519977179&quot;)">
                        </td>
                        <td id="Sell in Tm:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2537991201-519977179&quot;)">
                        </td>
                        <td id="Sell in Tm:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2537718633-0&quot;)">
                        </td>
                        <td id="Sell in Tm:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2538749054-0&quot;)">
                        </td>
                        <td id="Sell in Tm:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2538099090-188530139&quot;)">
                        </td>
                        <td id="Sell in Tm:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:50%;float:left;" value="Order price" onclick="sell_in_TM()">
                            <input type="button" style="width:50%;float:right;" value="Real price" onclick="sell_in_TM(&quot;2538764922-519977179&quot;)">
                        </td>
                    </tr>
                    <tr>
                        <th class="steamToTM_sell_cell_th">Refresh:</th>
                        <td id="Refresh:_310786355-0" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;310786355-0&quot;,&quot;PP-Bizon | Modern Hunter (Field-Tested)&quot;)">
                        </td>
                        <td id="Refresh:_310810067-0" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;310810067-0&quot;,&quot;P250 | Nuclear Threat (Battle-Scarred)&quot;)">
                        </td>
                        <td id="Refresh:_992204697-519977179" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;992204697-519977179&quot;,&quot;Desert Eagle | Sunset Storm 弐 (Field-Tested)&quot;)">
                        </td>
                        <td id="Refresh:_2521767801-0" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2521767801-0&quot;,&quot;Spectrum 2 Case&quot;)">
                        </td>
                        <td id="Refresh:_519984334-519977179" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;519984334-519977179&quot;,&quot;P2000 | Chainmail (Minimal Wear)&quot;)">
                        </td>
                        <td id="Refresh:_310776847-480085569" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;310776847-480085569&quot;,&quot;USP-S | Dark Water (Minimal Wear)&quot;)">
                        </td>
                        <td id="Refresh:_2536383019-480085569" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2536383019-480085569&quot;,&quot;M4A4 | Zirka (Field-Tested)&quot;)">
                        </td>
                        <td id="Refresh:_2536461826-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2536461826-188530139&quot;,&quot;M4A4 | Hellfire (Battle-Scarred)&quot;)">
                        </td>
                        <td id="Refresh:_2536468449-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2536468449-188530139&quot;,&quot;Nova | Ghost Camo (Minimal Wear)&quot;)">
                        </td>
                        <td id="Refresh:_2536447858-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2536447858-188530139&quot;,&quot;P2000 | Red FragCam (Field-Tested)&quot;)">
                        </td>
                        <td id="Refresh:_2536959719-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2536959719-188530139&quot;,&quot;P250 | Undertow (Field-Tested)&quot;)">
                        </td>
                        <td id="Refresh:_2536551320-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2536551320-519977179&quot;,&quot;Desert Eagle | Sunset Storm 弐 (Battle-Scarred)&quot;)">
                        </td>
                        <td id="Refresh:_2537666435-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2537666435-188530139&quot;,&quot;P250 | Steel Disruption (Minimal Wear)&quot;)">
                        </td>
                        <td id="Refresh:_2537662881-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2537662881-519977179&quot;,&quot;Desert Eagle | Sunset Storm 弐 (Field-Tested)&quot;)">
                        </td>
                        <td id="Refresh:_2537991201-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2537991201-519977179&quot;,&quot;MAC-10 | Nuclear Garden (Battle-Scarred)&quot;)">
                        </td>
                        <td id="Refresh:_2537718633-0" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2537718633-0&quot;,&quot;Five-SeveN | Jungle (Field-Tested)&quot;)">
                        </td>
                        <td id="Refresh:_2538749054-0" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2538749054-0&quot;,&quot;MAC-10 | Urban DDPAT (Battle-Scarred)&quot;)">
                        </td>
                        <td id="Refresh:_2538099090-188530139" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2538099090-188530139&quot;,&quot;CZ75-Auto | Tread Plate (Field-Tested)&quot;)">
                        </td>
                        <td id="Refresh:_2538764922-519977179" style="opacity:0.2;" class="steamToTM_sell_cell">
                            <input type="button" style="width:100%;" value="Refresh" onclick="refresh_prices(&quot;2538764922-519977179&quot;,&quot;M4A4 | Radiation Hazard (Well-Worn)&quot;)">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>

function number_format( number, decimals, dec_point, thousands_sep ) {
    var i, j, kw, kd, km;

    if( isNaN(decimals = Math.abs(decimals)) ){
            decimals = 2;
    }
    if( dec_point == undefined ){
            dec_point = ",";
    }
    if( thousands_sep == undefined ){
            thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if( (j = i.length) > 3 ){
            j = j % 3;
    } else{
            j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");

    return km + kw + kd;
}


$(document).ready(function(){
    $("#load_user_inventory").hide();
    $("#refresh_prices_user_inventory").hide();
    $("#get_discount_user_inventory").hide();
    $("#calculating_user_inventory").hide();
    $("#load_icon").hide();
});

function get_discount(){
    $("#get_discount_user_inventory").show();
    $("#load_icon").show();
    $.ajax({
        url: 'pages/search/steam_to_tm (sell)/get_discount.php', 
        cache: false,
        type:'POST',
        dataType: 'json',
        success: function(response){
            document.getElementById('buy_discount').innerHTML = response.buy_discount;
            document.getElementById('sell_fee').innerHTML = response.sell_fee;
            $("#get_discount_user_inventory").hide();
            $("#load_icon").hide();
        }
		
    });
}
function steamToTM_sell_load_inventory(){
    $("#load_user_inventory").show();
    $("#load_icon").show();
    var steamID = document.getElementById('steamId_field').value;
    var hide_tradable = false;
    $.ajax({
        url: 'pages/search/steam_to_tm (sell)/load_inventory.php', 
        cache: false,
        type:'POST',
        dataType: 'json',
        data: {'tsteamID':steamID,'thide_tradable':hide_tradable},
        success: function(response){
            document.getElementById('steamToTM_sell_table_id').innerHTML = response;
            $("#load_user_inventory").hide();
            $("#load_icon").hide();
        }

    });
}

function refresh_prices(classid_instanceid,market_hash_name){
    $("#refresh_prices_user_inventory").show();
    $("#load_icon").show();
    $.ajax({
        url: 'pages/search/steam_to_tm (sell)/refresh_prices.php', 
        cache: false,
        type:'POST',
        dataType: 'json',
        data: {'tclassid_instanceid':classid_instanceid,'tmarket_hash_name':market_hash_name},
        success: function(response){
            document.getElementById('Steam real:_' + classid_instanceid).innerHTML = response.Steam_real;
            document.getElementById('ST⇒ST real:_' + classid_instanceid).innerHTML = response.ST_to_ST_real;
            document.getElementById('ST⇒ST order:_' + classid_instanceid).innerHTML = response.ST_to_ST_order;
            document.getElementById('Steam order:_' + classid_instanceid).innerHTML = response.Steam_order;
            document.getElementById('TM real:_' + classid_instanceid).innerHTML = response.TM_real;
            document.getElementById('TM order:_' + classid_instanceid).innerHTML = response.TM_order;
            document.getElementById('ST⇒TM real:_' + classid_instanceid).innerHTML = response.ST_to_TM_real;
            document.getElementById('ST⇒TM order:_' + classid_instanceid).innerHTML = response.ST_to_TM_order;

            $("#refresh_prices_user_inventory").hide();
            $("#load_icon").hide();
        }

    });
}
function calculate(price_bought,classid_instanceid){
    var sell_discount = 7.65;
    var most = 1 - (sell_discount / 100);

    var my_price = Number(price_bought);
    var steam_real = Number(document.getElementById('Steam real:_' + classid_instanceid).innerHTML);
    var steam_order = Number(document.getElementById('Steam order:_' + classid_instanceid).innerHTML);
    var TM_real = Number(document.getElementById('TM real:_' + classid_instanceid).innerHTML);
    var TM_order = Number(document.getElementById('TM order:_' + classid_instanceid).innerHTML);

    var ST_ST_real = (((steam_real * 0.85) * 100)/my_price)-100;
    var ST_ST_order = (((steam_order * 0.85) * 100)/my_price)-100;
    var ST_TM_real = (((TM_real * most) * 100) / my_price)-100;
    var ST_TM_order = (((TM_order * most) * 100) / my_price)-100;

    if(ST_ST_real > 0){document.getElementById('ST⇒ST real:_' + classid_instanceid).style.color = "#0ECC00";}
    else{document.getElementById('ST⇒ST real:_' + classid_instanceid).style.color = "red";}
    if(ST_ST_order > 0){document.getElementById('ST⇒ST order:_' + classid_instanceid).style.color = "#0ECC00";}
    else{document.getElementById('ST⇒ST order:_' + classid_instanceid).style.color = "red";}

    if(ST_TM_real > 0){document.getElementById('ST⇒TM real:_' + classid_instanceid).style.color = "#0ECC00";}
    else{document.getElementById('ST⇒TM real:_' + classid_instanceid).style.color = "red";}
    if(ST_TM_order > 0){document.getElementById('ST⇒TM order:_' + classid_instanceid).style.color = "#0ECC00";}
    else{document.getElementById('ST⇒TM order:_' + classid_instanceid).style.color = "red";}

    document.getElementById('ST⇒ST real:_' + classid_instanceid).innerHTML = number_format(ST_ST_real, 2, '.', '');
    document.getElementById('ST⇒ST order:_' + classid_instanceid).innerHTML = number_format(ST_ST_order, 2, '.', '');
    document.getElementById('ST⇒TM real:_' + classid_instanceid).innerHTML = number_format(ST_TM_real, 2, '.', '');
    document.getElementById('ST⇒TM order:_' + classid_instanceid).innerHTML = number_format(ST_TM_order, 2, '.', '');
}

function quick_calc(){
    $("#calculating_user_inventory").show();
    $("#load_icon").show();
    var buy_price = Number(document.getElementById('quick_calc_buy_price').value);
    var sell_price = Number(document.getElementById('quick_calc_sell_price').value);

    var percent = ((sell_price * 100)/buy_price)-100;
    document.getElementById('quick_calc_result').innerHTML = number_format(percent, 2, '.', '');
    $("#calculating_user_inventory").hide();
    $("#load_icon").hide();
}

</script>