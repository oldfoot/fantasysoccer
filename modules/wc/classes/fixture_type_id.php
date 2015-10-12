<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

class FixtureTypeID {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function SetParameters($fixture_type_id) {

		/* SET VARIABLES IN THE GLOBAL SCOPE */
		$this->fixture_type_id=$fixture_type_id;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTHS OF VARIABLES */
		if (EMPTY($this->fixture_type_id)) {$this->Errors("Invalid fixture ID!"); return False; }
		if (!IS_NUMERIC($this->fixture_type_id)) {$this->Errors("Fixture ID not numeric!"); return False; }

		/* CHECK IF THE IDENTITY NUMBER EXISTS */
		if (!RowExists("fixture_type_master","fixture_type_id",$this->fixture_type_id,"")) { $this->Errors("Fixture does not exist!"); return False; }

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

		$sql="SELECT type_name, date_start, date_end, prediction_allow, prediction_total, max_replacements
					FROM ".$GLOBALS['database_ref']."fixture_type_master
					WHERE fixture_type_id = '".$this->fixture_type_id."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->type_name=$row["type_name"];
				$this->date_start=$row["date_start"];
				$this->date_end=$row["date_end"];
				$this->prediction_allow=$row["prediction_allow"];
				$this->prediction_total=$row["prediction_total"];
				$this->max_replacements=$row["max_replacements"];
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
		if (EMPTY($this->type_name)) { $this->Errors("Fixture name cannot be empty!"); return False; }
		/* PLAYER NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->type_name)) { $this->Errors("Invalid fixture name. Use only alpha-numeric characters!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['database_ref']."fixture_type_master
					(type_name,date_start,date_end,prediction_allow,prediction_total)
					VALUES (
					'".$this->type_name."',
					'".$this->date_start."',
					'".$this->date_end."',
					'".$this->prediction_allow."',
					'".$this->prediction_total."'
					)";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->type_name." added");
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
		if (EMPTY($this->type_name)) { $this->Errors("Fixture name cannot be empty!"); return False; }
		/* PLAYER NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->type_name)) { $this->Errors("Invalid fixture name. Use only alpha-numeric characters!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['database_ref']."fixture_type_master
					SET type_name = '".$this->type_name."',
					date_start = '".$this->date_start."',
					date_end = '".$this->date_end."',
					prediction_allow = '".$this->prediction_allow."',
					prediction_total = '".$this->prediction_total."'
					WHERE fixture_type_id = ".$this->fixture_type_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->type_name." edited");
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
		$sql="DELETE FROM ".$GLOBALS['database_ref']."fixture_type_master
					WHERE fixture_type_id = ".$this->fixture_type_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->type_name." deleted");
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