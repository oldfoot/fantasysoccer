<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

class PositionID {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function SetParameters($position_id) {

		/* SET VARIABLES IN THE GLOBAL SCOPE */
		$this->position_id=$position_id;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTHS OF VARIABLES */
		if (EMPTY($this->position_id)) {$this->Errors("Invalid position ID!"); return False; }
		if (!IS_NUMERIC($this->position_id)) {$this->Errors("Position ID not numeric!"); return False; }

		/* CHECK IF THE IDENTITY NUMBER EXISTS */
		if (!RowExists("position_master","position_id",$this->position_id,"")) { $this->Errors("Position does not exist!"); return False; }

		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		/* WE CALL THE INFO */
		$this->Info();

		return True;
	}

	/* THIS RETURNS INFORMATION ABOUT THE POSITION ID*/
	private function Info() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }

		$db=$GLOBALS['db'];

		$sql="SELECT position_name
					FROM ".$GLOBALS['mysql_db']."position_master
					WHERE position_id = '".$this->position_id."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
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

		/* POSITION NAME CANNOT BE EMPTY */
		if (EMPTY($this->position_name)) { $this->Errors("Position name cannot be empty!"); return False; }
		/* POSITION NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->position_name)) { $this->Errors("Invalid position name. Use only alpha-numeric characters!"); return False; }
		/* POSITION NAMES CAN'T BE DUPLICATED */
		if (RowExists("position_master","position_name",$this->position_name,"")) { $this->Errors("Position exists!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['mysql_db']."position_master
					(position_name)
					VALUES (
					'".$this->position_name."'
					)";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->position_name." added");
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
		/* ENSURE THE POSITION NAME IS NOT EMPTY */
		if (EMPTY($this->position_name)) { $this->Errors("Position name can't be empty."); return False; }
		/* POSITION NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->position_name)) { $this->Errors("Invalid position name. Use only alpha-numeric characters!"); return False; }
		/* POSITION NAMES CAN'T BE DUPLICATED */
		if (RowExists("position_master","position_name",$this->position_name,"")) { $this->Errors("Position exists!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['mysql_db']."position_master
					SET position_name = '".$this->position_name."'
					WHERE position_id = ".$this->position_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->position_name." edited");
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
		/* CALL THIS TO GET THE POSITION NAME BEFORE WEL DELETE IT */

		/* DELETE */
		$db=$GLOBALS['db'];
		$sql="DELETE FROM ".$GLOBALS['mysql_db']."position_master
					WHERE position_id = ".$this->position_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->position_name." deleted");
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