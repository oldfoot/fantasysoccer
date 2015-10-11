<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

class PlayerID {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function SetParameters($player_id) {

		/* SET VARIABLES IN THE GLOBAL SCOPE */
		$this->player_id=$player_id;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTHS OF VARIABLES */
		if (EMPTY($this->player_id)) {$this->Errors("Invalid player ID!"); return False; }
		if (!IS_NUMERIC($this->player_id)) {$this->Errors("Player ID not numeric!"); return False; }

		/* CHECK IF THE IDENTITY NUMBER EXISTS */
		if (!RowExists("player_master","player_id",$this->player_id,"")) { $this->Errors("Player does not exist!"); return False; }

		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		/* WE CALL THE INFO */
		$this->Info();

		return True;
	}

	/* THIS RETURNS INFORMATION ABOUT THE PLAYER ID*/
	private function Info() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }

		$db=$GLOBALS['db'];

		$sql="SELECT pm.player_name, pm.team_id, pm.position_id,
					tm.team_name, tm.logo_location,pom.position_name
					FROM ".$GLOBALS['mysql_db']."player_master pm,".$GLOBALS['mysql_db']."team_master tm,".$GLOBALS['mysql_db']."position_master pom
					WHERE pm.player_id = '".$this->player_id."'
					AND pm.team_id = tm.team_id
					AND pm.position_id = pom.position_id
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->player_name=$row["player_name"];
				$this->team_id=$row["team_id"];
				$this->position_id=$row["position_id"];
				$this->team_name=$row["team_name"];
				$this->logo_location=$row["logo_location"];
				$this->position_name=$row["position_name"];
			}
		}
	}

	/* GET ANY OF THE VARIABLES IN THE CLASS */
	public function GetInfo($v) {
		return $this->$v;
	}

	/* ADD TO THE DATABASE */
	public function Add() {

		/* PLAYER NAME CANNOT BE EMPTY */
		if (EMPTY($this->player_name)) { $this->Errors("Player name cannot be empty!"); return False; }
		/* PLAYER NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->player_name)) { $this->Errors("Invalid player name. Use only alpha-numeric characters!"); return False; }
		/* TEAM ID MUST EXIST */
		if (!RowExists("team_master","team_id",$this->team_id,"")) { $this->Errors("Invalid team!"); return False; }
		/* POSITION ID MUST EXIST */
		if (!RowExists("position_master","position_id",$this->position_id,"")) { $this->Errors("Invalid position!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['mysql_db']."player_master
					(player_name,team_id,position_id)
					VALUES (
					'".$this->player_name."',
					'".$this->team_id."',
					'".$this->position_id."'
					)";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->player_name." added");
			return True;
		}
		else {
			return False;
		}
	}

	/* ADD TO THE DATABASE */
	public function Edit() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) { $this->Errors("Parameter check failed."); return False; }
		/* PLAYER NAME CANNOT BE EMPTY */
		if (EMPTY($this->player_name)) { $this->Errors("Player name cannot be empty!"); return False; }
		/* PLAYER NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->player_name)) { $this->Errors("Invalid team name. Use only alpha-numeric characters!"); return False; }
		/* TEAM ID MUST EXIST */
		if (!RowExists("team_master","team_id",$this->team_id,"")) { $this->Errors("Invalid team!"); return False; }
		/* POSITION ID MUST EXIST */
		if (!RowExists("position_master","position_id",$this->position_id,"")) { $this->Errors("Invalid position!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['mysql_db']."player_master
					SET player_name = '".$this->player_name."',
					team_id = '".$this->team_id."',
					position_id = '".$this->position_id."'
					WHERE player_id = ".$this->player_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->player_name." edited");
			return True;
		}
		else {
			return False;
		}
	}

	/* DELETE FROM THE DATABASE */
	public function Delete() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }
		/* CALL THIS TO GET THE TEAM NAME BEFORE WEL DELETE IT */

		/* DELETE */
		$db=$GLOBALS['db'];
		$sql="DELETE FROM ".$GLOBALS['mysql_db']."player_master
					WHERE player_id = ".$this->player_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->player_name." deleted");
			return True;
		}
		else {
			return False;
		}
	}

	private function Errors($err) {
		$this->errors.=$err."<br>";
	}

	public function ShowErrors() {
		return $this->errors;
	}
}
?>