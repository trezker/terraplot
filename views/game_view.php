<!DOCTYPE html>
<html>
<head>
<title>Terraplot</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
var canvas = null;
var context = null;
var img_townhall = null;
var img_farm = null;
var img_warrior = null;
var img_grass = null;
var map = new Array();
var menu = null;
var canvas_offset = null;

var menu_nogame = new Array()
menu_nogame["mouse_x"] = 0;
menu_nogame["mouse_y"] = 0;
menu_nogame["draw"] = function() {
	context.fillStyle="#CCCCCC";
	context.fillRect(270, 190, 100, 100);

	if(mouse_inside(270, 190, 370, 218)) {
		context.fillStyle="#AAA";
		context.fillRect(270, 190, 100, 28);
	}

	context.fillStyle="#000";
	context.font="16px Georgia";
	
	draw_centered_text("New game", 320, 210);
}
menu_nogame["onclick"] = function() {
	if(mouse_inside(270, 190, 370, 218)) {
		$.ajax({
			type: 'POST',
			url: '/',
			data: {
				id: id
			},
			success: function(data) {
				if(ajax_logged_out(data)) return;
				if(data !== false) {
				}
			}
		});
		menu = null;
		draw();
	}
}

function mouse_inside(x1, y1, x2, y2) {
	if(menu.mouse_x < x1 || menu.mouse_x > x2 || menu.mouse_y < y1 || menu.mouse_y > y2) {
		return false;
	}
	return true;
}

function draw_centered_text(text, x, y) {
	textmeasure = context.measureText(text);
	context.fillText(text, x - textmeasure.width/2, y);
}

//$(document).ready(function() {
$(window).load(function() {
	canvas = document.getElementById("terraplot_canvas");
	context = canvas.getContext("2d");
	canvas_offset = $("#terraplot_canvas").offset();
	
	img_townhall = document.getElementById("img_townhall");
	img_farm = document.getElementById("img_farm");
	img_warrior = document.getElementById("img_warrior");
	img_grass = document.getElementById("img_grass");

	for(x = 0; x < 20; x++)
	{
		for(y = 0; y < 15; y++)
		{
			set_tile(x, y, new Array());
		}
	}

	tile = get_tile(1, 1)
	tile.building = img_townhall;
	set_tile(1, 1, tile);
	
	tile = get_tile(2, 1)
	tile.unit = img_warrior;
	set_tile(2, 1, tile);
	
	menu = menu_nogame;
	
	draw();

	$(document).keyup(function(event){
	});
	
	$("#terraplot_canvas").mousemove(function(event) {
		if(menu) {
			menu.mouse_x = event.pageX - canvas_offset.left;
			menu.mouse_y = event.pageY - canvas_offset.top;
			menu.draw();
		}
	});
	$("#terraplot_canvas").click(function(event) {
		if(menu) {
			menu.onclick(event);
		}
	});
});

function get_tile(x, y) {
	return map[y*20+x];
}

function set_tile(x, y, d) {
	map[y*20+x] = d;
}

function draw() {
	//context.strokeRect(0, 0, canvas.width, canvas.height);
	//context.fillStyle="#FF0000";
	
	for(x = 0; x < 20; x++)
	{
		for(y = 0; y < 15; y++)
		{
			var tile = get_tile(x, y);
			draw_tile(img_grass, x, y);
			if(tile["building"]) {
				draw_tile(tile["building"], x, y);
			}
			if(tile["unit"]) {
				draw_tile(tile["unit"], x, y);
			}
		}
	}
	
	draw_tile(img_townhall, 3, 3);
	draw_tile(img_farm, 2, 3);
	draw_tile(img_warrior, 3, 3);
	draw_tile(img_warrior, 2, 3);

	draw_tile(img_townhall, 16, 3);
	draw_tile(img_townhall, 3, 11);
	draw_tile(img_townhall, 16, 11);
	
	if(menu) {
		menu["draw"]();
	}
}

function draw_tile(image, x, y) {
	context.drawImage(image, x*32, y*32);
}

</script>
</head>

<body>
<h1>Terraplot</h1>
<canvas id="terraplot_canvas" width="640" height="480" style="border: 0px;">
Your browser does not support the canvas element.
</canvas>

<img id="img_townhall" src="data/images/townhall.png" />
<img id="img_farm" src="data/images/farm.png" />
<img id="img_warrior" src="data/images/warrior.png" />
<img id="img_grass" src="data/images/grass.png" />

<span onclick="draw()">Redraw</span>

</body>
