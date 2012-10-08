var canvas = null;
var context = null;
var images = new Array();
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
			url: '/game/new_game',
			data: {
			},
			success: function(data) {
				//if(ajax_logged_out(data)) return;
				if(data !== false) {
					clear_map();
					var map = data.data.map;
					for (var i = 0; i < map.length; i++) {
						var serv = map[i];
						tile = get_tile(serv.x, serv.y)
						if(serv.building) {
							tile.building = serv.building;
						}
						if(serv.warrior) {
							tile.warrior = serv.warrior;
						}
					}
					draw();
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
	
	images["townhall"] = document.getElementById("img_townhall");
	images["farm"] = document.getElementById("img_farm");
	images["warrior"] = document.getElementById("img_warrior");
	images["grass"] = document.getElementById("img_grass");

	clear_map();
/*
	tile = get_tile(1, 1)
	tile.building = "townhall";
	//set_tile(1, 1, tile);
	
	tile = get_tile(3, 1)
	tile.building = "farm";
	//set_tile(3, 1, tile);

	tile = get_tile(2, 1)
	tile.unit = "warrior";
	//set_tile(2, 1, tile);
*/
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

function clear_map() {
	for(x = 0; x < 20; x++) {
		for(y = 0; y < 15; y++) {
			set_tile(x, y, new Array());
		}
	}
}

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
				draw_tile(images[tile["building"]], x, y);
			}
			if(tile["unit"]) {
				draw_tile(images[tile["unit"]], x, y);
			}
		}
	}

	if(menu) {
		menu["draw"]();
	}
}

function draw_tile(image, x, y) {
	context.drawImage(image, x*32, y*32);
}
