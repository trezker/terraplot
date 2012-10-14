<?php

require_once '../models/database.php';

class Game_model {
	public function Create_game() {
		$db = Load_database();

		$query = '
			insert into Game(Created) values(?)';
		$rs = $db->Execute($query, array(time()));
		if(!$rs) {
			return false;
		}
		return $db->Insert_id();
	}

	public function Delete_game($id) {
		$db = Load_database();

		$query = '
			delete from Game where ID = ?';
		$rs = $db->Execute($query, array($id));
		if(!$rs) {
			return false;
		}
		return true;
	}

	public function Create_players($game_id, $n) {
		$db = Load_database();

		$db->StartTrans();

		$query = '
			insert into Player (Game_ID, Turn) values(?, ?)';
		$args = array($game_id, 0);
		for($i = 1; $i < $n; $i++) {
			$query .= ',(?, ?)';
			$args[] = $game_id;
			$args[] = $i;
		}
		$rs = $db->Execute($query, $args);
		if(!$rs) {
			$db->CompleteTrans();
			return false;
		}
		
		$query = '
			select count(*) as N from Player where Game_ID = ?';
		$args = array($game_id);
		$rs = $db->Execute($query, $args);
		
		if(!$rs || $rs->fields['N'] != $n) {
			$db->FailTrans();
		}

		$failed = $db->HasFailedTrans();
		$db->CompleteTrans();
		return !$failed;
	}
	
	function Get_players($game_id) {
		$db = Load_database();

		$query = '
			select P.ID, P.Turn, U.Username from Player P
			left join User U on U.ID = P.User_ID
			where Game_ID = ?
			order by P.Turn asc';
		$args = array($game_id);
		$rs = $db->Execute($query, $args);
		if(!$rs) {
			return false;
		}
		return $rs->GetArray();
	}
	
	function Join_player($game_id, $user_id, $turn) {
		$db = Load_database();

		$query = '
			update Player set User_ID = ? where Game_ID = ? and Turn = ? and User_ID is NULL';
		$args = array($user_id, $game_id, $turn, $user_id);
		$rs = $db->Execute($query, $args);
		if(!$rs) {
			return false;
		}
		return true;
	}
	
	function Get_tile($game_id, $x, $y) {
		$db = Load_database();

		$query = '
			insert into Tile(Game_ID, X, Y) values(?, ?, ?)';
		$args = array($game_id, $x, $y);
		$rs = $db->Execute($query, $args);

		$query = '
			select T.ID, T.Building_ID, T.Player_ID from Tile T
			where Game_ID = ? and X = ? and Y = ?
			';
		$args = array($game_id, $x, $y);
		$rs = $db->Execute($query, $args);
		
		return $rs->fields;
	}
	
	function Update_tile($tile_id, $building_id, $player_id) {
		$db = Load_database();

		$query = '
			update Tile set Building_ID = ?, Player_ID = ? where ID = ?';
		$args = array($building_id, $player_id, $tile_id);
		$rs = $db->Execute($query, $args);
		if(!$rs || 	$db->Affected_Rows() == 0) {
			return false;
		}
		
		return true;
	}
}
