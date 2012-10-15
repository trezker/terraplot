<?php
require_once "../controllers/controller.php";

class Front extends Controller
{
	public function Index()
	{
		$gamelist = null;
		if(isset($_SESSION['userid'])) {
			$openid_icons = false;
			$this->Load_model('Game_model');
			$gamelist = $this->Game_model->Get_user_games($_SESSION['userid']);
		}
		else {
			$this->Load_model('User_model');
			$openid_icons = $this->User_model->Get_openid_icons();
		}

		$this->Load_view('game_view', array(
											'openid_icons' => $openid_icons,
											'gamelist' => $gamelist
											));
	}

	public function Get_login_view() {
		$this->Load_model('User_model');
		$openid_icons = $this->User_model->Get_openid_icons();
		$this->Load_view('login_view', array('openid_icons' => $openid_icons));
	}
}
