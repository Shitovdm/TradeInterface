<?php
if (!isset($_SESSION['steamid'])) {
    header('Location: access_denied.php');
}
$user_data = array(
    'mckimley' => '*****',
    'alfa09' => '*****',
    'Sia\'guess' => '*****'
);

$i = 0;
foreach ($user_data as $element => $value) {
    $user_nickname[$i] = $element;
    $user_steamID[$i] = $value;
    $i++;
}
?>

<div>
    <table id="user_inventory_result_table">
        <?php
        for ($j = 0; $j < count($user_data); $j++) {
            echo('<tr><td>');
            echo('<div class="profile_cash_update central" onClick="user_inventory_updateORdownload(' . $user_steamID[$j] . ')"><kbd>&#8634;</kbd></div>');
            echo('<b>' . $user_nickname[$j] . '</b></br>');
            echo('<a href="http://steamcommunity.com/profiles/' . $user_steamID[$j] . '">' . $user_steamID[$j] . '</a>');
            echo('</td><td id="download_inventory_content' . $user_steamID[$j] . '"><b>Please, click update button.</b></td></tr>');
        }
        ?>
    </table>
</div>
<script>

    function user_inventory_updateORdownload(steamID) {
        $.ajax({
            url: 'pages/user_inventory/download_data.php',
            cache: false,
            type: 'POST',
            dataType: 'json',
            data: {'tsteamID': steamID},
            success: function (response) {
                document.getElementById('download_inventory_content' + steamID).innerHTML = response;
            }
        });
    }
</script>