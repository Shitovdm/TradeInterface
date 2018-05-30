var colheight = [];
var temp_random_height = [];
var current_action = [];
var dy = [];
// var dy = 0.001;

$(document).ready(function() {
	colheight_generator();
});

function setup() {
	var myCanvas = createCanvas(displayWidth, 380);
}

function colheight_generator() {
	for ( var i = 0; i < 100; i++){
		dy.push(Math.random()/100);
		colheight.push(-Math.random());
		temp_random_height.push(-Math.random());
		if (-Math.random() > -0.5) {
			current_action.push(true);
		} else {
			current_action.push(false);
		}
	}
}

function colheight_changer() {
	// array = [];
	for ( var i = 0; i < 100; i++){
		if (current_action[i]) {
			colheight[i] += dy[i];
		} else {
			colheight[i] -= dy[i];
		}
		if (colheight[i] >= 0) {
			current_action[i] = false;
			dy[i] = Math.random()/100;
		}
		if (colheight[i] <= temp_random_height[i]) {
			current_action[i] = true;
			temp_random_height[i] = -Math.random();
			dy[i] = Math.random()/100;
		}
	}
}

setInterval(colheight_changer,20);


function draw() {
	background(231);
	x = 0;
	for ( var i = 0; i <= 100; i++) {
		fill(210);
		noStroke();
		rect(5*x, height, windowWidth*0.008, colheight[i]*350);
		x += windowWidth*0.002;
	}
}