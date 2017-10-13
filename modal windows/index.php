<html>
<head>
    <title>
    </title>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/windows.js"></script>
</head>
<body>
	<div class="container" style="top:30px;left:10px;width:300px;height:inherit;" id="first_window">
        <div id="window-panel-first" onClick="activeWindow(this.id)" class="top-panel">
         	<span id="move-first" class="move-icon" onClick="moveWindow(this.id);"><img src="images/icons/move.png" width="24px" height="24px;"></span>
        	<span id="hide-first" class="hide-icon" onClick="hideContent(this.id)">&#9776;</span>
            <b>Window #1</b> 
        </div>
        
    	<div id="content-block-first" class="content">
        	<span class="n-resize" id="n-resize-first" onClick="Resize(this.id,'n')"></span>
        	<span class="w-resize" id="w-resize-first" onClick="Resize(this.id,'w')"></span>
    		<span class="nw-resize" id="d-resize-first"  onClick="Resize(this.id,'nw')"><img src="images/icons/resize.png" width="18px" height="18px"></span>
        	<h1>The turnip</h1>
        	<p>Grandpa planted a turnip. The turnip grew bigger and bigger. Grandpa came to pick the turnip, pulled and pulled but couldn't pull it up! Grandpa called Grandma. Grandma pulled Grandpa, Grandpa pulled the turnip. They pulled and pulled but couldn't pull it up! Granddaughter came. Granddaughter pulled Grandma, Grandma pulled Grandpa, and Grandpa pulled the turnip. They pulled and pulled but couldn't pull it up!</p>
             <img class="content-img" src="http://www.fun4child.ru/uploads/posts/2010-01/1264763755_repka.jpg" width="60%">
        </div>
        <div class="clear"></div>
    </div>
    
    
    <div class="container" style="top:30px;left:320px;width:300px;height:inherit;"  id="second_window">
    	<div id="window-panel-second" onClick="activeWindow(this.id)" class="top-panel">
         	<span id="move-second" class="move-icon" onClick="moveWindow(this.id);"><img src="images/icons/move.png" width="24px" height="24px;"></span>
        	<span id="hide-second" class="hide-icon" onClick="hideContent(this.id)">&#9776;</span>
            <b>Window #2</b>
        </div>
    	<div id="content-block-second" class="content">
        	<span class="n-resize" id="n-resize-second" onClick="Resize(this.id,'n')"></span>
        	<span class="w-resize" id="w-resize-second" onClick="Resize(this.id,'w')"></span>
    		<span class="nw-resize" id="d-resize-second"  onClick="Resize(this.id,'nw')"><img src="images/icons/resize.png" width="18px" height="18px"></span>
        	<h1>The bun</h1>
        	<p>Once there lived an old man and old woman. The old man said, "Old woman, bake me a bun." "What can I make it from? I have no flour." "Eh, eh, old woman! Scrape the cupboard, sweep the flour bin, and you will find enough flour. "The old woman picked up a duster, scraped the cupboard, swept the flour bin and gathered about two handfuls of flour. She mixed the dough with sour cream, fried it in butter, and put the bun on the window sill to cool. The bun lay and lay there. Suddenly it rolled off the window sill to the bench, from the bench to the floor, from the floor to the door. Then it rolled over the threshold to the entrance hall, from the entrance hall to the porch, from the porch to the courtyard, from the courtyard trough the gate and on and on.</p>
            <img class="content-img" src="http://www.fun4child.ru/uploads/posts/2010-01/1264764091_kolobok-angl.jpg" width="60%">
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="container" style="top:30px;left:630px;width:300px;height:inherit;"  id="third_window">
    	<div id="window-panel-third" onClick="activeWindow(this.id)" class="top-panel">
         	<span id="move-third" class="move-icon" onClick="moveWindow(this.id);"><img src="images/icons/move.png" width="24px" height="24px;"></span>
        	<span id="hide-third" class="hide-icon" onClick="hideContent(this.id)">&#9776;</span>
            <b>Window #3</b>
        </div>
    	<div id="content-block-third" class="content">
        	<span class="n-resize" id="n-resize-third" onClick="Resize(this.id,'n')"></span>
        	<span class="w-resize" id="w-resize-third" onClick="Resize(this.id,'w')"></span>
    		<span class="nw-resize" id="d-resize-third"  onClick="Resize(this.id,'nw')"><img src="images/icons/resize.png" width="18px" height="18px"></span>
        	<h1>The wooden house</h1>
        	<p>There stood a small wooden house (teremok) in the open field. A mouse ran by: - Little house, little house! Who lives in the little house? Nobody answered. The mouse went into the house and began to live there.</p>
            <p>A frog hopped by: - Little house, little house! Who lives in the little house? -I am a mouse. And who are you? - I am a frog. Let's live together. So the mouse and the frog began living together.</p>
            <img class="content-img" src="http://www.fun4child.ru/uploads/posts/2010-01/1264764507_teremok-angl.png" width="60%">
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="cursor-position">
    	<span id="xy"></span>
    </div>
</body>
</html>

<script type="text/javascript">

</script>