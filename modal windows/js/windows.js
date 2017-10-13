ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false

var TopPanel_height = "30px";
var TopPanel_height_OLD = "";

var mouseDown_c = false;//	Флаг нажатия кнопки перемещения окна.
var tmpConteinerId = "";//	ID перемещаемого окна.

var depression_resize = false; //	Флаг нажатия кнопки ресайза.
var direction_resize = "";// Направление изменения размера окна.

var tmp_Zindex = 1;// Индекс для окон.

function activeWindow(id){// Функция выводит блок на передний план.
	var block_number = id.substring(13);
	tmp_Zindex++;
	document.getElementById(block_number + "_window").style.zIndex = tmp_Zindex;
}

function Resize(id,direction){// Функция вызывается при изменении размера окна.
	direction_resize = direction;
	if(depression_resize){ 
		depression_resize = false;
	}else{
		depression_resize = true;
		tmpConteinerId = id;
	}
}

function hideContent(id){
	var block_number = id.substring(5);
	if(document.getElementById("content-block-" + block_number).style.display == "none"){
		$("#content-block-" + block_number).fadeIn('fast');
		document.getElementById(block_number + "_window").style.height = TopPanel_height_OLD;
	}else{
		 $("#content-block-" + block_number).fadeOut('fast');
		 TopPanel_height_OLD =  document.getElementById(block_number + "_window").style.height;
		 document.getElementById(block_number + "_window").style.height = TopPanel_height;
	}
}

function moveWindow(id){
	if(mouseDown_c){ 
		mouseDown_c = false;
	}else{
		mouseDown_c = true;
		tmpConteinerId = id;
	}
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
	
	if(mouseDown_c){// Если нажата кнопка изменения позиции окна.
		tmpID = tmpConteinerId.substring(5) + "_window";//	ID окна, которое мы хотим переместить.
		document.getElementById(tmpID).style.top =  mouse_y - 14;//Новая позиция окна по Y.
		document.getElementById(tmpID).style.left =  mouse_x - 14;//Новая позиция окна по X.
	}
	if(depression_resize){// Если нажаты кнопки изменения размера окна.
		tmpID = tmpConteinerId.substring(9) + "_window";//	ID окна, размер которого меняем.
		var position_y_start = document.getElementById(tmpID).style.top;// Позиция начала окна по y.
		var position_x_start = document.getElementById(tmpID).style.left;// Позиция начала окна по x.
		position_y_start = position_y_start.split('p')[0];
		position_x_start = position_x_start.split('p')[0];
		var position_y_end = mouse_y;
		var position_x_end = mouse_x;
		switch(direction_resize){// Выбираем в каком направлении расширять окно.
			case "n":
				document.getElementById(tmpID).style.height =  position_y_end - position_y_start;
				break;	
			case "w":
				document.getElementById(tmpID).style.width =  position_x_end - position_x_start;
				break;
			case "nw":
				document.getElementById(tmpID).style.height =  position_y_end - position_y_start;
				document.getElementById(tmpID).style.width =  position_x_end - position_x_start;
				break;
		}
	}
}
init();