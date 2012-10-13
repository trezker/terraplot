<?php
require_once "../controllers/controller.php";

class Game extends Controller
{
	public function new_game() {
		header('Content-type: application/json');
		$this->Load_controller('User');
		if(!$this->User->Logged_in()) {
			echo json_encode(array('success' => false, 'reason' => 'Not logged in'));
			return;
		}

		$this->Load_model('Game_model');
		$game_id = $this->Game_model->Create_game();
		if($game_id == false) {
			echo json_encode(array('success' => false, 'reason' => 'Could not create game'));
			return;
		}			

		if($this->Game_model->Create_players($game_id, 4) == false) {
			$this->Game_model->Delete_game($game_id);
			echo json_encode(array('success' => false, 'reason' => 'Could not create game'));
			return;
		}

		$map = array();

		$tile = array(
							'x' => 3,
							'y' => 3,
							'building' => 'townhall',
							'owner' => 0
							);
 		array_push($map, $tile);
		$tile = array(
							'x' => 3,
							'y' => 11,
							'building' => 'townhall',
							'owner' => 1
							);
 		array_push($map, $tile);
		$tile = array(
							'x' => 16,
							'y' => 11,
							'building' => 'townhall',
							'owner' => 2
							);
 		array_push($map, $tile);
		$tile = array(
							'x' => 16,
							'y' => 3,
							'building' => 'townhall',
							'owner' => 3
							);
 		array_push($map, $tile);


		$data = array();
		$data["map"] = $map;

		echo json_encode(array('success' => true, 'data' => $data));
	}
}
