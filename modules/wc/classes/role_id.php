<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

class RoleID {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function SetParameters($role_id) {

		/* SET VARIABLES IN THE GLOBAL SCOPE */
		$this->role_id=$role_id;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTHS OF VARIABLES */
		if (EMPTY($this->role_id)) {$this->Errors("Invalid role ID!"); return False; }
		if (!IS_NUMERIC($this->role_id)) {$this->Errors("Role ID not numeric!"); return False; }

		/* CHECK IF THE IDENTITY NUMBER EXISTS */
		if (!RowExists("role_master","role_id",$this->role_id,"")) { $this->Errors("Role does not exist!"); return False; }

		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		/* WE CALL THE INFO */
		$this->Info();

		return True;
	}

	/* THIS RETURNS INFORMATION ABOUT THE ROLE ID*/
	private function Info() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }

		$db=$GLOBALS['db'];

		$sql="SELECT role_name
					FROM ".$GLOBALS['database_ref']."role_master
					WHERE role_id = '".$this->role_id."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->role_name=$row["role_name"];
			}
		}
	}

	/* GET ANY OF THE VARIABLES IN THE CLASS */
	public function GetInfo($v) {
		return $this->$v;
	}

	/* ADD TO THE DATABASE */
	public function Add() {

		/* ROLE NAME CANNOT BE EMPTY */
		if (EMPTY($this->role_name)) { $this->Errors("Role name cannot be empty!"); return False; }
		/* ROLE NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->role_name)) { $this->Errors("Invalid role name. Use only alpha-numeric characters!"); return False; }
		/* ROLE NAMES CAN'T BE DUPLICATED */
		if (RowExists("role_master","role_name",$this->role_name,"")) { $this->Errors("Role exists!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['database_ref']."role_master
					(role_name)
					VALUES (
					'".$this->role_name."'
					)";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->role_name." added");
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
		/* ENSURE THE ROLE NAME IS NOT EMPTY */
		if (EMPTY($this->role_name)) { $this->Errors("Role name can't be empty."); return False; }
		/* ROLE NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->role_name)) { $this->Errors("Invalid role name. Use only alpha-numeric characters!"); return False; }
		/* ROLE NAMES CAN'T BE DUPLICATED */
		if (RowExists("role_master","role_name",$this->role_name,"")) { $this->Errors("Role exists!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['database_ref']."role_master
					SET role_name = '".$this->role_name."'
					WHERE role_id = ".$this->role_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->role_name." edited");
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
		/* CALL THIS TO GET THE ROLE NAME BEFORE WEL DELETE IT */

		/* DELETE */
		$db=$GLOBALS['db'];
		$sql="DELETE FROM ".$GLOBALS['database_ref']."role_master
					WHERE role_id = ".$this->role_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->role_name." deleted");
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