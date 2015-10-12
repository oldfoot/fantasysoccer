<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

class TeamID {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function SetParameters($team_id) {

		/* SET VARIABLES IN THE GLOBAL SCOPE */
		$this->team_id=$team_id;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTHS OF VARIABLES */
		if (EMPTY($this->team_id)) {$this->Errors("Invalid team ID!"); return False; }
		if (!IS_NUMERIC($this->team_id)) {$this->Errors("Team ID not numeric!"); return False; }

		/* CHECK IF THE IDENTITY NUMBER EXISTS */
		if (!RowExists("team_master","team_id",$this->team_id,"")) { $this->Errors("Team does not exist!"); return False; }

		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		/* WE CALL THE INFO */
		$this->Info();

		return True;
	}

	/* THIS RETURNS INFORMATION ABOUT THE TEAM ID*/
	private function Info() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }

		$db=$GLOBALS['db'];

		$sql="SELECT team_name
					FROM ".$GLOBALS['database_ref']."team_master
					WHERE team_id = '".$this->team_id."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->team_name=$row["team_name"];
			}
		}
	}

	/* GET ANY OF THE VARIABLES IN THE CLASS */
	public function GetInfo($v) {
		return $this->$v;
	}

	/* ADD TO THE DATABASE */
	public function Add() {

		/* TEAM NAME CANNOT BE EMPTY */
		if (EMPTY($this->team_name)) { $this->Errors("Team name cannot be empty!"); return False; }
		/* TEAM NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->team_name)) { $this->Errors("Invalid team name. Use only alpha-numeric characters!"); return False; }
		/* TEAM NAMES CAN'T BE DUPLICATED */
		if (RowExists("team_master","team_name",$this->team_name,"")) { $this->Errors("Team exists!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['database_ref']."team_master
					(team_name)
					VALUES (
					'".$this->team_name."'
					)";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->team_name." added");
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
		/* ENSURE THE TEAM NAME IS NOT EMPTY */
		if (EMPTY($this->team_name)) { $this->Errors("Team name can't be empty."); return False; }
		/* TEAM NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->team_name)) { $this->Errors("Invalid team name. Use only alpha-numeric characters!"); return False; }
		/* TEAM NAMES CAN'T BE DUPLICATED */
		if (RowExists("team_master","team_name",$this->team_name,"")) { $this->Errors("Team exists!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['database_ref']."team_master
					SET team_name = '".$this->team_name."'
					WHERE team_id = ".$this->team_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->team_name." edited");
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
		$sql="DELETE FROM ".$GLOBALS['database_ref']."team_master
					WHERE team_id = ".$this->team_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->team_name." deleted");
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