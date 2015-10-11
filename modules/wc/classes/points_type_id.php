<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

class PointsTypeID {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function SetParameters($points_type_id) {

		/* SET VARIABLES IN THE GLOBAL SCOPE */
		$this->points_type_id=$points_type_id;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTHS OF VARIABLES */
		if (EMPTY($this->points_type_id)) {$this->Errors("Invalid description ID!"); return False; }
		if (!IS_NUMERIC($this->points_type_id)) {$this->Errors("Description ID not numeric!"); return False; }

		/* CHECK IF THE POINTS TYPE EXISTS */
		if (!RowExists("points_type_master","points_type_id",$this->points_type_id,"")) { $this->Errors("Description does not exist!"); return False; }

		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		/* WE CALL THE INFO */
		$this->Info();

		return True;
	}

	/* THIS RETURNS INFORMATION ABOUT THE POINTS_TYPE ID*/
	private function Info() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }

		$db=$GLOBALS['db'];

		$sql="SELECT description
					FROM ".$GLOBALS['mysql_db']."points_type_master
					WHERE points_type_id = '".$this->points_type_id."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->description=$row["description"];
			}
		}
	}

	/* GET ANY OF THE VARIABLES IN THE CLASS */
	public function GetInfo($v) {
		return $this->$v;
	}

	/* ADD TO THE DATABASE */
	public function Add() {

		/* POINTS TYPE NAME CANNOT BE EMPTY */
		if (EMPTY($this->description)) { $this->Errors("Description name cannot be empty!"); return False; }
		/* POINTS TYPE NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->description)) { $this->Errors("Invalid description name. Use only alpha-numeric characters!"); return False; }
		/* POINTS TYPE NAMES CAN'T BE DUPLICATED */
		if (RowExists("points_type_master","description",$this->description,"")) { $this->Errors("Description exists!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['mysql_db']."points_type_master
					(description)
					VALUES (
					'".$this->description."'
					)";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->description." added");
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
		/* ENSURE THE POINTS TYPE NAME IS NOT EMPTY */
		if (EMPTY($this->description)) { $this->Errors("Description name can't be empty."); return False; }
		/* POINTS TYPE NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->description)) { $this->Errors("Invalid description name. Use only alpha-numeric characters!"); return False; }
		/* POINTS TYPE NAMES CAN'T BE DUPLICATED */
		if (RowExists("points_type_master","description",$this->description,"")) { $this->Errors("Description exists!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['mysql_db']."points_type_master
					SET description = '".$this->description."'
					WHERE points_type_id = ".$this->points_type_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->description." edited");
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
		/* CALL THIS TO GET THE POINTS TYPE NAME BEFORE WEL DELETE IT */

		/* DELETE */
		$db=$GLOBALS['db'];
		$sql="DELETE FROM ".$GLOBALS['mysql_db']."points_type_master
					WHERE points_type_id = ".$this->points_type_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->description." deleted");
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