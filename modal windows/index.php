<html>
<head>
    <title>
    </title>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
	<div class="container" id="window">
    	<div class="top-panel">
         	<span class="move-icon" onClick="mouseOnclick()"><img src="images/icons/move.png" width="24px" height="24px;"></span>
        	<span id="first" class="hide-icon" onClick="hideContent()">&#9776;</span>
            <b>Window</b>
           
        </div>
    	<div id="first_content" class="content">
        	<h1>The turnip</h1>
        	<p>Grandpa planted a turnip. The turnip grew bigger and bigger. Grandpa came to pick the turnip, pulled and pulled but couldn't pull it up! Grandpa called Grandma. Grandma pulled Grandpa, Grandpa pulled the turnip. They pulled and pulled but couldn't pull it up! Granddaughter came. Granddaughter pulled Grandma, Grandma pulled Grandpa, and Grandpa pulled the turnip. They pulled and pulled but couldn't pull it up!</p>
        </div>
        <div class="clear"></div>
    </div>
    <div class="cursor-position">
    	<span id="xy"></span>
    </div>
</body>
</html>
<script type="text/javascript">
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false

var mouseDown_c = false;


function hideContent(){
	if(document.getElementById('first_content').style.display == "none"){
		$("#first_content").fadeIn('fast');
	}else{
		 $("#first_content").fadeOut('fast');
	}
}

function mouseOnclick(){
	if(mouseDown_c){ mouseDown_c = false;}else{mouseDown_c = true;}
}

function init() {
    if(ns4){
		document.captureEvents(Event.MOUSEMOVE);
	}
    document.onmousemove = mousemove;
}
function mousemove(event) {
    var mouse_x = y = 0;
    if(document.attachEvent != null) {
        mouse_x = window.event.clientX;
        mouse_y = window.event.clientY;
    }else if (!document.attachEvent && document.addEventListener) {
        mouse_x = event.clientX;
        mouse_y = event.clientY;
    }
    status="x = " + mouse_x + ", y = " + mouse_y;
    document.getElementById('xy').innerHTML = "x = " + mouse_x + ", y = " + mouse_y;
	mouse_y_pos = mouse_y;
	mouse_x_pos = mouse_x;
	if(mouseDown_c){
		document.getElementById('window').style.top =  mouse_y-14;
		document.getElementById('window').style.left =  mouse_x-14;
	}
}
init();
</script>