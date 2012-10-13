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
}
