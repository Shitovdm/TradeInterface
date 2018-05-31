<?php
    require_once("service/dbconnect.php");
    session_start();
    require_once("other/encodeORdecode.php");

    if (!isset($_SESSION['steamid'])) {
        header('Location: /index.php?page=access_denied.php');
    } else {
        $steamid = $_SESSION['steamid'];
    }


    $sell_price_0_1 = 0;
    $sell_price_1_5 = 0;
    $sell_price_5_50 = 0;
    $sell_price_50_250 = 0;
    $sell_price_250_1000 = 0;
    $sell_price_1000_inf = 0;

    $buy_price_0_1 = 0;
    $buy_price_1_5 = 0;
    $buy_price_5_50 = 0;
    $buy_price_50_250 = 0;
    $buy_price_250_1000 = 0;
    $buy_price_1000_inf = 0;

    $sell_price_sum = 0;
    $buy_price_sum = 0;
    $select_data = mysql_query("SELECT * FROM bought_items WHERE user_steamid='$steamid'");
    while ($row = mysql_fetch_assoc($select_data)) {
        $item_market_name[$i] = $row['market_hash_name'];
        $sell_price[$i] = $row['sell_price'];
        $buy_price[$i] = $row['buy_price'];
        $classid_instanceid[$i] = $row['classid_instanceid'];
        $sell_price_sum += $sell_price[$i];
        $buy_price_sum += $buy_price[$i];

        if ((int) $sell_price[$i] <= 1) {
            $sell_price_0_1++;
        }
        if (((int) $sell_price[$i] > 1) && ((int) $sell_price[$i] <= 5)) {
            $sell_price_1_5++;
        }
        if (((int) $sell_price[$i] > 5) && ((int) $sell_price[$i] <= 50)) {
            $sell_price_5_50++;
        }
        if (((int) $sell_price[$i] > 50) && ((int) $sell_price[$i] <= 250)) {
            $sell_price_50_250++;
        }
        if (((int) $sell_price[$i] > 250) && ((int) $sell_price[$i] < 1000)) {
            $sell_price_250_1000++;
        }
        if ((int) $sell_price[$i] >= 1000) {
            (int) $sell_price_1000_inf++;
        }

        
        if ((int) $buy_price[$i] <= 1) {
            $buy_price_0_1++;
        }
        if (((int) $buy_price[$i] > 1) && ((int) $buy_price[$i] <= 5)) {
            $buy_price_1_5++;
        }
        if (((int) $buy_price[$i] > 5) && ((int) $buy_price[$i] <= 50)) {
            $buy_price_5_50++;
        }
        if (((int) $buy_price[$i] > 50) && ((int) $buy_price[$i] <= 250)) {
            $buy_price_50_250++;
        }
        if (((int) $buy_price[$i] > 250) && ((int) $buy_price[$i] < 1000)) {
            $buy_price_250_1000++;
        }
        if ((int) $buy_price[$i] >= 1000) {
            (int) $buy_price_1000_inf++;
        }

        $i++;
    }
    $persent_sum = ((($buy_price_sum * 0.85 ) * 100) / ($sell_price_sum)) - 100;
    
    $steamid = $_SESSION['steamid'];
    $select_data = mysql_query("SELECT *
                                                    FROM users 
                                                    WHERE steamid = '$steamid'");
    while ($row = mysql_fetch_assoc($select_data)) {
        $secretKey = $row['secretKey'];
        $password = $row['password'];
        $SteamGuardCode = $row['SteamGuardCode'];
    }
    if ($secretKey == "") {
        $visible_code = "The key is missing!";
    } else {
        $visible_code = (substr(decode_this($secretKey), 0, 4)) . "****************************";
    }
    if ($password == "") {
        $password = "The password is missing!";
    } else {
        for ($i = 0; $i < strlen(decode_password($password)); $i++) {
            $stars .= "*";
        }
        $password = (substr(decode_password($password), 0, 4)) . $stars;
    }
    if ($SteamGuardCode == "") {
        $SteamGuardCode = "The SteamGuardCode is missing!";
    } else {
        $SteamGuardCode = (substr(decode_this($SteamGuardCode), 0, 4)) . "************************";
    }


    $url = "https://market.csgo.com/api/GetMoney/?key=" . decode_this($secretKey);
    $inv = curl_init($url);
    curl_setopt($inv, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($inv, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($inv, CURLOPT_HEADER, false);
    curl_setopt($inv, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($inv, CURLOPT_TIMEOUT, 5);
    $output_curl = curl_exec($inv);
    curl_close($inv);

    $json_decode_data = json_decode($output_curl);
    $cash = ($json_decode_data->money) / 100;
?>
<div class="profile">
    <div class="profile_userInformation">
        <div class="profile_userData">
            <div class="profile_username">
                <b><?php echo($_SESSION["nikname"]); ?></b>
            </div>
            <div class="profile_avatar">
                <img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/<?php echo($_SESSION["fullavatar"]); ?>">
            </div>
        </div>
        <div class="profile_userData">
            <div class="profile_username">
                <b>Your cash</b>
            </div>

            <table class="profile_cash">
                <tr>
                    <td><b>Current balance:</b></td>
                    <td><b><?php echo($cash); ?></b></td>
                    <td><b>&#8381;</b></td>
                    <td><div class="profile_cash_update" onClick="profile_cash_update()"><kbd>&#8634;</kbd></div></td>
                </tr>
            </table>

            <div class="profile_cash_history">
                <span onClick="showModalWindow('recent_purchases')">50 recent purchases</span>
            </div>
        </div>
    </div>
    <div class="profile_tradeData">
        <div class="profile_instruction">
            <b>Be sure to read!</b>
            <p><b>Attention!</b> Never give out secret keys. Any attempt to obtain any of your secret keys can result in the loss of your money on your account. When you enter the key in the field, it will be encoded and any operations with the key will be performed only on the server side.</p>
            <p><b>We guarantee the confidentiality of keys, but we do not bear any liability for misuse (in particular, the transfer of the key to third parties).</b></p>
            <p>You can delete or change the private key at any time by inserting the key into the key entry field and clicking on the "Check" button.</p>
            <p>Find your secret keys will help <a onClick="$('#profile_modal_FAQ').show();">FAQ</a>, carefully read it, to avoid any mistakes.</p>

        </div>
        <table class="profile_tradeField">
            <tr>
                <td colspan="4"><hr align="center" size="1" width="98%" color="#ccc"  /></td>
            </tr>
        </table>
        <table class="profile_tradeField">

            <tr>
                <td><p class="check_result"><b>Please, enter your password here:</b></p></td>
                <td><input class="check_result dataField" type="text" value="<?php echo($password); ?>" name="password" id="password"></td>
                <td><input class="check_result dataButton" type="button" placeholder="Check" name="check_password" value="Check" onClick="checkANDsend_working_capacity('password')"></td>
                <td>
                    <div class="check_result">
                        <img src="images/preloaders/preloader_circle.gif" width="24px;" id="preloader_password">
                        <span id="password_false" style="font-size:24px;color:#FF0004;display:none;">&#10008;</span>
                        <span id="password_true" style="font-size:24px;color:#00EB5C;display:none;">&#10004;</span>
                        <span id="password_wait" style="font-size:24px;color:#FFE81C;display:none;">&#10008;</span>
                    </div>
                </td>
            </tr>

            <tr>
                <td><p class="check_result"><b>Please, enter your SteamGuardCode here:</b></p></td>
                <td><input class="check_result dataField" type="text" value="<?php echo($SteamGuardCode); ?>" name="SteamGuardCode" id="SteamGuardCode"></td>
                <td><input class="check_result dataButton" type="button" placeholder="Check" name="check_SteamGuardCode" value="Check" onClick="checkANDsend_working_capacity('SteamGuardCode')"></td>
                <td>
                    <div class="check_result">
                        <img src="images/preloaders/preloader_circle.gif" width="24px;" id="preloader_SteamGuardCode">
                        <span id="SteamGuardCode_false" style="font-size:24px;color:#FF0004;display:none;">&#10008;</span>
                        <span id="SteamGuardCode_true" style="font-size:24px;color:#00EB5C;display:none;">&#10004;</span>
                        <span id="SteamGuardCode_wait" style="font-size:24px;color:#FFE81C;display:none;">&#10008;</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4"><hr align="center" size="1" width="98%" color="#ccc" /></td>
            </tr>
            <tr>
                <td><p class="check_result"><b>Please, enter your API secret key here:</b></p></td>
                <td><input class="check_result dataField" type="text" value="<?php echo($visible_code); ?>" name="secret_key" id="secret_key"></td>
                <td><input class="check_result dataButton" type="button" placeholder="Check" name="check_secretKey" value="Check" onClick="checkANDsend_working_capacity('secret_key')"></td>
                <td>
                    <div class="check_result">
                        <img src="images/preloaders/preloader_circle.gif" width="24px;" id="preloader_secret_key">
                        <span id="secret_key_false" style="font-size:24px;color:#FF0004;display:none;">&#10008;</span>
                        <span id="secret_key_true" style="font-size:24px;color:#00EB5C;display:none;">&#10004;</span>
                        <span id="secret_key_wait" style="font-size:24px;color:#FFE81C;display:none;">&#10008;</span>
                    </div>
                </td>
            </tr>




        </table>
    </div>

    <div class="calculation_results">
        <div class="stat_history">
            <form class="profile_statistic_input_form">
                <b>Enter time interval:</b>
                <b>From: </b>
                <input type="text" name="date-start" class="date-statistic" id="date-start" value="<?php echo(date("d.m.Y")); ?>" placeholder="dd.mm.yyyy">
                <b>To: </b>
                <input type="text" name="date-end" class="date-statistic" id="date-end" value="<?php echo(date("d.m.Y")); ?>" placeholder="dd.mm.yyyy">
                <input type="button" value="Update" onClick="profile_upload_statistic()">
            </form>
            <div class="hist_container">
                <b id="amount"><?php echo(count($item_market_name)); ?> </b>
                <span>Amount</span>
            </div>
            <div class="hist_container">
                <b id="sell_price_sum"><?php echo($sell_price_sum); ?> &#8381;</b>
                <span>Purchased items</span>
            </div>
            <div class="hist_container">
                <b id="buy_price_sum"><?php echo(number_format(($buy_price_sum * 0.85), 2, '.', '')); ?> &#8381;</b>
                <span>Sold items</span>
            </div>
            <div class="hist_container">
                <b id="full_persent"><?php echo(number_format($persent_sum, 2, '.', '')); ?></b>
                <span>Full persent</span>
            </div>
            <div class="hist_container">
                <b id="full_summ"><?php echo(number_format((($buy_price_sum * 0.85) - $sell_price_sum), 2, '.', '')); ?> &#8381;</b>
                <span>Full profit</span>
            </div>
            <div class="clear"></div>
        </div>

    </div>
    <div class="profile_tradeData profile_statistics">
        <div id="gistogram_stat" style="width: 100%; height:300px;"></div>
    </div>



</div>

<script>
    $(document).ready(function () {
        $("#preloader_secret_key").hide();
        $("#preloader_password").hide();
        $("#preloader_SteamGuardCode").hide();

        $("#password_wait").show();
        $("#SteamGuardCode_wait").show();
        $("#secret_key_wait").show();
    });

    function checkANDsend_working_capacity(id) {
        var checking_field = document.getElementById(id).value;

        $("#" + id + "_true").hide();
        $("#" + id + "_false").hide();
        $("#" + id + "_wait").hide();
        $("#preloader_" + id).show();
        $.ajax({
            type: "POST",
            url: 'pages/profile/check_secret_key.php',
            cache: false,
            dataType: 'json',
            data: {tchecking_field: checking_field, ttype: id},
            success: function (response) {
                $("#preloader_" + id).hide();
                if (response.flag == true) {
                    $("#" + id + "_true").fadeIn('low');
                } else {
                    $("#" + id + "_false").fadeIn('low');
                }
            }
        });
    }
    function showModalWindow(info) {
        $.ajax({
            url: 'pages/profile/50_recent_purchases.php',
            cache: false,
            dataType: 'json',
            success: function (response) {
                document.getElementById('profile_modal_purchases_list').innerHTML = response;
                $("#profile_modal_recent_purchases").show();
            }
        });
    }

    function profile_upload_statistic() {
        var date_from = document.getElementById("date-start").value;
        var date_to = document.getElementById("date-end").value;
        if (date_from != "" && date_to != "") {
            $.ajax({
                url: 'pages/profile/statistic_between.php',
                cache: false,
                dataType: 'json',
                type: 'GET',
                data: {tfrom: date_from, tto: date_to},
                success: function (response) {
                    document.getElementById('amount').innerHTML = response.amount;
                    document.getElementById('sell_price_sum').innerHTML = response.sell_price_sum + " &#8381;";
                    document.getElementById('buy_price_sum').innerHTML = response.buy_price_sum + " &#8381;";
                    document.getElementById('full_persent').innerHTML = response.full_persent;
                    document.getElementById('full_summ').innerHTML = response.full_summ + " &#8381;";
                }
            });
        } else {
            alert("Please enter between date!");
        }

    }

</script>
<script src="https://www.google.com/jsapi"></script>
<script>
    google.load("visualization", "1", {packages: ["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Item Price', 'Buying', 'Selling'],
            ['<1 rub', <?php echo($sell_price_0_1); ?>, <?php echo($buy_price_0_1); ?>],
            ['1-5 rub', <?php echo($sell_price_1_5); ?>, <?php echo($buy_price_1_5); ?>],
            ['5-50 rub', <?php echo($sell_price_5_50); ?>, <?php echo($buy_price_5_50); ?>],
            ['50-250 rub', <?php echo($sell_price_50_250); ?>, <?php echo($buy_price_50_250); ?>],
            ['250-1000 rub', <?php echo($sell_price_250_1000); ?>, <?php echo($buy_price_250_1000); ?>],
            ['1000< rub', <?php echo($sell_price_1000_inf); ?>, <?php echo($buy_price_1000_inf); ?>],
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