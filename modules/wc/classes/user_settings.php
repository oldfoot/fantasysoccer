<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

class UserSettings {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}


	/* SAVE TO THE DATABASE */
	public function Modify() {
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['database_ref']."user_master
					SET team_name = '".$this->team_name."',
					email_address = '".$this->email_address."',
					tel_cellular = '".$this->tel_cellular."',
					full_name = '".$this->full_name."'
					WHERE user_id = ".$_SESSION['user_id']."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
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