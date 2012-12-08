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
				if(ajax_logged_out(data)) return;
				if(data.success !== false) {
					menu = null;
					update_map(data.data);
				}
			}
		});
	}
}

function load_game(game_id) {
	$.ajax({
		type: 'POST',
		url: '/game/load_game',
		data: {
			game_id: game_id
		},
		success: function(data) {
			if(ajax_logged_out(data)) return;
			if(data.success !== false) {
				menu = null;
				update_map(data.data);
			}
		}
	});
}

function update_map(data) {
	clear_map();
	var map = data.map;
	for (var i = 0; i < map.length; i++) {
		var serv = map[i];
		tile = get_tile(parseInt(serv.X, 10), parseInt(serv.Y, 10))
		if(serv.Owner_turn) {
			tile.owner_turn = serv.Owner_turn;
		}
		if(serv.Building_name) {
			tile.building = serv.Building_name;
		}
		if(serv.warrior) {
			tile.warrior = serv.warrior;
		}
	}
	draw();
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

$(window).load(function() {
	canvas = document.getElementById("terraplot_canvas");
	context = canvas.getContext("2d");
	canvas_offset = $("#terraplot_canvas").offset();
	
	images["townhall"] = document.getElementById("img_townhall");
	images["farm"] = document.getElementById("img_farm");
	images["warrior"] = document.getElementById("img_warrior");
	images["grass"] = document.getElementById("img_grass");

	clear_map();

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
	for(x = 0; x < 20; x++) {
		for(y = 0; y < 15; y++) {
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
	context.lineWidth=3;
	for(x = 0; x < 20; x++) {
		for(y = 0; y < 15; y++) {
			var tile = get_tile(x, y);
			if(tile.owner_turn) {
				alert(tile.owner_turn);
				if(tile.owner_turn == 0) {
					context.strokeStyle = "rgba(255, 0, 0, 0.25)";
				}
				if(tile.owner_turn == 1) {
					context.strokeStyle = "rgba(0, 255, 0, 0.25)";
				}
				if(tile.owner_turn == 2) {
					context.strokeStyle = "rgba(0, 0, 255, 0.25)";
				}
				if(tile.owner_turn == 3) {
					context.strokeStyle = "rgba(0, 255, 255, 0.25)";
				}
				context.strokeRect(x*32 + 0.5, y*32 + 0.5, 31, 31);
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
