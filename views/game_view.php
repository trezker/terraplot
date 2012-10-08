<!DOCTYPE html>
<html>
<head>
<title>Terraplot</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="/js/game.js"></script>
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
