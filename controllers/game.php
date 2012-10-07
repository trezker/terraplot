<?php
require_once "../controllers/controller.php";

class Game extends Controller
{
	public function new_game()
	{
		header('Content-type: application/json');

		$map = array();

		$tile = array(
							'x' => 3,
							'y' => 3,
							'building' => 'townhall'
							);
 		array_push($map, $tile);
		$tile = array(
							'x' => 3,
							'y' => 11,
							'building' => 'townhall'
							);
 		array_push($map, $tile);
		$tile = array(
							'x' => 16,
							'y' => 11,
							'building' => 'townhall'
							);
 		array_push($map, $tile);
		$tile = array(
							'x' => 16,
							'y' => 3,
							'building' => 'townhall'
							);
 		array_push($map, $tile);


		$data = array();
		$data["map"] = $map;

		echo json_encode(array('success' => true, 'data' => $data));
	}
}
