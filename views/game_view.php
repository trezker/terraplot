<!DOCTYPE html>
<html>
<head>
<title>Terraplot</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" media="screen" href="/css/style.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="/js/game.js"></script>
<script type="text/javascript" src="/js/dialog.js"></script>
</head>

<body>
<div style="float: left;">
<h1>Terraplot</h1>
<div class="action" onclick="draw()">Redraw map</div>
<?php
if(isset($gamelist) && $gamelist != false) {
	echo '<h3>Your games</h3>';
	foreach($gamelist as $game) {
		$template = '<span class="action" onclick="load_game({Game_ID});">{Game_ID}</span><br />';
		echo expand_template($template, $game);
	}
}
if(isset($openid_icons) && $openid_icons != false) {
	echo '
		<div class="user_menu">
			<span>Log in with OpenID</span>
			<span>
				<div>
					<span class="openid_icons">
		';
	foreach($openid_icons as $icon) {
		echo '<span class="action openid_icon" data-tooltip="'.$icon['name'].'"><img src="'.$icon['icon'].'" height="16" width="16" onclick="login(\''.$icon['URI'].'\');" /></span>';
	}
	echo '
					</span>
				</div>
				<span><input type="text" name="openid" id="openid" /></span>
				<span class="login_action action" onclick="login();">Log in</span>
				<div id="openidfeedback">&nbsp;</div>
			</span>
		</div>
		';
} ?>
</div>

<div style="float: left; margin-left: 10px;">
	<canvas id="terraplot_canvas" width="640" height="480" style="border: 0px;">
		Your browser does not support the canvas element.
	</canvas>
</div>

<div style="visibility: hidden">
<img id="img_townhall" src="data/images/townhall.png" />
<img id="img_farm" src="data/images/farm.png" />
<img id="img_warrior" src="data/images/warrior.png" />
<img id="img_grass" src="data/images/grass.png" />
</div>
</body>
