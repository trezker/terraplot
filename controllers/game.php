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
		
		if($this->Game_model->Join_player($game_id, $_SESSION['userid'], 0) == false) {
			echo json_encode(array('success' => false, 'reason' => 'Could not create game'));
			return;
		}
		
		$players = $this->Game_model->Get_players($game_id);
		
		$tile = $this->Game_model->Get_tile($game_id, 3, 3);
		$this->Game_model->Update_tile($tile['ID'], 1, $players[0]['ID']);
		$tile = $this->Game_model->Get_tile($game_id, 3, 11);
		$this->Game_model->Update_tile($tile['ID'], 1, $players[0]['ID']);
		$tile = $this->Game_model->Get_tile($game_id, 16, 11);
		$this->Game_model->Update_tile($tile['ID'], 1, $players[0]['ID']);
		$tile = $this->Game_model->Get_tile($game_id, 16, 3);
		$this->Game_model->Update_tile($tile['ID'], 1, $players[0]['ID']);

		$map = $this->Game_model->Get_tiles($game_id);

		$data = array();
		$data["map"] = $map;

		echo json_encode(array('success' => true, 'data' => $data));
	}

	public function load_game() {
		header('Content-type: application/json');
		$this->Load_controller('User');
		if(!$this->User->Logged_in()) {
			echo json_encode(array('success' => false, 'reason' => 'Not logged in'));
			return;
		}
		
		$game_id = $_POST['game_id'];

		$this->Load_model('Game_model');
		$map = $this->Game_model->Get_tiles($game_id);

		$data = array();
		$data["map"] = $map;

		echo json_encode(array('success' => true, 'data' => $data));
	}
}
