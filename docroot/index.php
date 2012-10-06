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

$(document).ready(function() {
	canvas = document.getElementById("terraplot_canvas");
	context = canvas.getContext("2d");
	img_townhall = document.getElementById("img_townhall");
	img_farm = document.getElementById("img_farm");
	img_warrior = document.getElementById("img_warrior");
	img_grass = document.getElementById("img_grass");
	draw();

	$(document).keyup(function(event){
	});
});

function draw() {
	//context.strokeRect(0, 0, canvas.width, canvas.height);
	//context.fillStyle="#FF0000";
	
	for(x = 0; x < 20; x++)
	{
		for(y = 0; y < 15; y++)
		{
			draw_tile(img_grass, x, y);
		}
	}
	
	draw_tile(img_townhall, 3, 3);
	draw_tile(img_farm, 2, 3);
	draw_tile(img_warrior, 3, 3);
	draw_tile(img_warrior, 2, 3);

	draw_tile(img_townhall, 16, 3);
	draw_tile(img_townhall, 3, 11);
	draw_tile(img_townhall, 16, 11);
}

function draw_tile(image, x, y) {
	context.drawImage(image, x*32, y*32);
}

</script>
</head>

<body>
<h1>Terraplot</h1>
<canvas id="terraplot_canvas" width="640" height="480" style="border:1px solid #c3c3c3;">
Your browser does not support the canvas element.
</canvas>

<img id="img_townhall" src="images/townhall.png" />
<img id="img_farm" src="images/farm.png" />
<img id="img_warrior" src="images/warrior.png" />
<img id="img_grass" src="images/grass.png" />

</body>
