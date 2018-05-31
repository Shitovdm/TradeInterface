<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trade Interface</title>
    <link rel="shortcut icon" href="images/icon.ico" type="image/x-icon">
    <link href="css/animate.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/landing-animation-chart.css">
    <link href="css/startpage.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/external/p5.js"></script>
    <script type='text/javascript' charset='utf-8' src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'></script>
    <script src="js/dist/jquery.viewportchecker.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/p5.js/0.5.6/addons/p5.dom.js"></script>
</head>
<body>

<div class="animation-chart">
	<script type="text/javascript" src="js/landing-animation-chart.js"></script>
</div>
<div class="landing-page">
    <div class="start-page-container">
        <div class="start-page-content post">
            <img class="hero-logo" src="images/image.png" width="200px" alt="Logo">
            <h1 class="hero-title">Trade Interface</h1>
            <h2 class="hero-subtitle">Trade CSGO skins fast and easy with Trade Interface!</h2>
            <div class="hero-button-wrapper fadeIn animation-button">
                <a class="button button-red" href="/index.php?page=pages/search_TMtoSteam.php">Get Started</a>
                <a class="button button-blue" href="/index.php?page=pages/version.php">Version</a>
                <a class="button button-black" href="https://github.com/Shitovdm/Steam_trade" target="_blank">GitHub</a>
            </div>
        </div>
        <hr>
        <div class="start-page-content">
            <div class="feature-container post">
                <div id="first-block" class="feature-text float-left">
                    <div class="feature-title-block">
                        <a href="/index.php?page=pages/search_TMtoSteam.php"><span class="pill">Go over</span></a>
                        <h3 class="feature-title">Best items on CSGO TM</h3>
                        <div class="clear"></div>
                    </div>
                    <p class="feature-description">Set your search preferences and automatically buy, sell, display and confirm the most profitable items on <a href="https://market.csgo.com" target="_blank">market.csgo.com</a>.</p>
                </div>
                <div class="feature-image float-left">
                    <img src="images/start_page/automatic.png" width="145px">
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="feature-container post">
                <div  id="second-block" class="feature-text float-right">
                    <div class="feature-title-block">
                        <a href="/index.php?page=pages/search_steamToTM (orders).php"><span class="pill">Go over</span></a>
                        <h3 class="feature-title">Most actual buy orders</h3>
                        <div class="clear"></div>
                    </div>
                    <p class="feature-description">Set buy orders in Steam and keep it the lowest automatically.</p>
                </div>
                <div class="feature-image float-right">
                     <img src="images/start_page/buy.png" width="140px">
                </div>
                <div class="clear"></div>
            </div>
              
            <div class="feature-container post">
                <div  id="third-block" class="feature-text float-left">
                    <div class="feature-title-block">
                        <a href="/index.php?page=pages/search_steamToTM (sell).php"><span class="pill">Go over</span></a>
                        <h3 class="feature-title">Sell your items favorably</h3>
                        <div class="clear"></div>
                    </div>
                    <p class="feature-description">Price analytics of items bought by orders.</p>
                </div>
                <div class="feature-image float-left">
                     <img src="images/start_page/sell.png" width="140px">
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="feature-container post">
                <div  id="fourth-block" class="feature-text float-right">
                    <div class="feature-title-block">
                        <a href="/index.php?page=pages/item_info_TMtoST.php"><span class="pill">Go over</span></a>
                        <h3 class="feature-title">Explore your statistics</h3>
                        <div class="clear"></div>
                    </div>
                    <p class="feature-description">The chart reflecting the statistics of items you buy and sell.</p>
                </div>
                <div class="feature-image float-right">
                    <img src="images/start_page/statistics.png" width="140px">
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="feature-container post">
                <div  id="fifth-block" class="feature-text float-left">
                    <div class="feature-title-block">
                        <a href="/index.php?page=pages/item_info_STtoTM.php"><span class="pill">Go over</span></a>
                        <h3 class="feature-title">Explore your sold items</h3>
                        <div class="clear"></div>
                    </div>
                    <p class="feature-description">The table that contains the list of items you ever bought and sold.</p>
                </div>
                <div class="feature-image float-left">
                    <img src="images/start_page/list.png" width="165px">
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <hr>
        <div class="start-page-content post">
            <div class="feature-small">
                <div class="feature-small-icon">
                    <img src="images/start_page/Safety.png" width="64px">
                </div>
                <h4 class="feature-small-title">Safety<h4>
                <p class="feature-small-description">All account data is well protected.</p>
            </div>
            <div class="feature-small">
                <div class="feature-small-icon">
                    <img src="images/start_page/Steam.png" width="64px">
                </div>
                <h4 class="feature-small-title">Steam Support<h4>
                <p class="feature-small-description">Powered using Steam Community.</p>
            </div>
            <div class="feature-small">
                <div class="feature-small-icon">
                    <img src="images/start_page/API.png" width="64px">
                </div> 
                <h4 class="feature-small-title">CSGO TM API<h4>
                <p class="feature-small-description">Generating API fot automatic trades.</p>
            </div>
            <div class="feature-small">
                <div class="feature-small-icon">
                    <img src="images/start_page/easy.png" width="64px">
                </div>
                <h4 class="feature-small-title">Easy to use<h4>
                <p class="feature-small-description">Most actions are automatised.</p>
            </div>
            
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="start-page-footer">
        <img src="images/icons/icon_charts.svg">
        <p class="footer-note">The page design was borrowed from <a href="http://www.chartjs.org/" target="_blank">chartjs.org</a></p>
    </div>
</div>
</body>
</html>

<script>
$(document).ready(function() {
        $('#defaultCanvas0').addClass("animated fadeIn");
        $('.start-page-container').addClass("animated fadeIn");
        $('.post').addClass("hidden").viewportChecker({
        classToAdd: 'visible fadeIn',
        repeat: true,
        offset: 50
        });
});
</script>
