<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

class FixtureID {

	public function __construct() {
		$this->errors = "";
	}

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function SetParameters($fixture_id) {

		/* SET VARIABLES IN THE GLOBAL SCOPE */
		$this->fixture_id=$fixture_id;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTH OF VARIABLES */
		if (EMPTY($this->fixture_id)) {$this->Errors("Invalid fixture ID!"); return False; }
		if (!IS_NUMERIC($this->fixture_id)) {$this->Errors("Fixture ID not numeric!"); return False; }

		/* CHECK IF THE IDENTITY NUMBER EXISTS */
		if (!RowExists("fixture_master","fixture_id",$this->fixture_id,"")) { $this->Errors("Fixture does not exist!"); return False; }

		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		/* WE CALL THE INFO */
		$this->Info();

		return True;
	}

	/* THIS RETURNS INFORMATION ABOUT THE FIXTURE ID*/
	private function Info() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }

		$db=$GLOBALS['db'];

		$sql="SELECT fm.team_id_1,fm.team_id_2,fm.date_fixture, fm.fixture_type_id,
					tm1.team_name AS team_name1,tm2.team_name AS team_name2
					FROM ".$GLOBALS['database_ref']."fixture_master fm, ".$GLOBALS['database_ref']."team_master tm1, ".$GLOBALS['database_ref']."team_master tm2
					WHERE fm.fixture_id = ".$this->fixture_id."
					AND fm.team_id_1 = tm1.team_id
					AND fm.team_id_2 = tm2.team_id
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->team_id_1=$row["team_id_1"];
				$this->team_id_2=$row["team_id_2"];
				$this->date_fixture=$row["date_fixture"];
				$this->team_name1=$row["team_name1"];
				$this->team_name2=$row["team_name2"];
				$this->fixture_type_id=$row["fixture_type_id"];
			}
		}
	}

	/* GET ANY OF THE VARIABLES IN THE CLASS */
	public function GetInfo($v) {
		return $this->$v;
	}

	/* ADD TO THE DATABASE */
	public function Add() {

		/* CHECK FOR REQUIRED FIELDS */
		if (EMPTY($this->team_id_1) || !IS_NUMERIC($this->team_id_1)) { $this->Errors("Invalid team 1!"); return False; }
		if (EMPTY($this->team_id_2) || !IS_NUMERIC($this->team_id_2)) { $this->Errors("Invalid team 2!"); return False; }
		if ($this->team_id_1 == $this->team_id_2) { $this->Errors("Teams cannot be the same!"); return False; }
		if (EMPTY($this->date_fixture)) { $this->Errors("Fixture date cannot be empty!"); return False; }
		if (EMPTY($this->fixture_type_id) || !IS_NUMERIC($this->fixture_type_id)) { $this->Errors("Invalid stage!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['database_ref']."fixture_master
					(team_id_1,team_id_2,date_fixture,fixture_type_id)
					VALUES (
					'".$this->team_id_1."',
					'".$this->team_id_2."',
					'".$this->date_fixture."',
					'".$this->fixture_type_id."'
					)";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory("Fixture on ".$this->date_fixture." added");
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

		if (EMPTY($this->team_id_1) || !IS_NUMERIC($this->team_id_1)) { $this->Errors("Invalid team 1!"); return False; }
		if (EMPTY($this->team_id_2) || !IS_NUMERIC($this->team_id_2)) { $this->Errors("Invalid team 2!"); return False; }
		if (EMPTY($this->date_fixture)) { $this->Errors("Fixture date cannot be empty!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['database_ref']."fixture_master
					SET team_id_1 = '".$this->team_id_1."',
					team_id_2 = '".$this->team_id_2."',
					date_fixture = '".$this->date_fixture."',
					fixture_type_id = '".$this->fixture_type_id."'
					WHERE fixture_id = ".$this->fixture_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory("Fixture on ".$this->date_fixture." edited");
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
		$sql="DELETE FROM ".$GLOBALS['database_ref']."fixture_master
					WHERE fixture_id = ".$this->fixture_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory("Fixture on ".$this->date_fixture." deleted");
			return True;
		}
		else {
			return False;
		}
	}

	/* DELETE RESULTS FROM THE DATABASE */
	public function Reset() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }
		/* CALL THIS TO GET THE TEAM NAME BEFORE WEL DELETE IT */

		/* DELETE USER POINTS */
		$db=$GLOBALS['db'];
		$sql="DELETE FROM ".$GLOBALS['database_ref']."user_points
					WHERE fixture_id = ".$this->fixture_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {

			/* DELETE RESULT */
			$sql1="UPDATE ".$GLOBALS['database_ref']."fixture_master SET
					goals_team_1 = null,
					goals_team_2 = null,
					yellow_cards_team_1 = null,
					yellow_cards_team_2 = null,
					red_cards_team_1 = null,
					red_cards_team_2 = null,
					hatricks_team_1 = null,
					hatricks_team_2 = null
					WHERE fixture_id = ".$this->fixture_id."
					";
			//echo $sql;
			$result1=$db->Query($sql1);
			if ($db->AffectedRows($result1) > 0) {
				LogHistory("Fixture on ".$this->date_fixture." reset");
				return True;
			}
			else {
				return False;
			}
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