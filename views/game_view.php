<!DOCTYPE html>
<html>
<head>
<title>Terraplot</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="/js/game.js"></script>
<script type="text/javascript" src="/js/dialog.js"></script>
</head>

<body>
<h1>Terraplot</h1>
<?php if(isset($openid_icons) && $openid_icons != false) { ?>
<div class="user_menu">
	<span>Log in with OpenID</span>
	<span>
		<div>
			<span class="openid_icons">
				<?php
					foreach($openid_icons as $icon) {
						echo '<span class="action openid_icon" data-tooltip="'.$icon['name'].'"><img src="'.$icon['icon'].'" height="16" width="16" onclick="login(\''.$icon['URI'].'\');" /></span>';
					}
				?>
			</span>
		</div>
		<span><input type="text" name="openid" id="openid" /></span>
		<span class="login_action action" onclick="login();">Log in</span>
		<div id="openidfeedback">&nbsp;</div>
	</span>
</div>
<?php } ?>

<canvas id="terraplot_canvas" width="640" height="480" style="border: 0px;">
Your browser does not support the canvas element.
</canvas>

<img id="img_townhall" src="data/images/townhall.png" />
<img id="img_farm" src="data/images/farm.png" />
<img id="img_warrior" src="data/images/warrior.png" />
<img id="img_grass" src="data/images/grass.png" />

<span onclick="draw()">Redraw</span>

</body>
