<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

class ChatID {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=EscapeData($value);
	}

	/* ADD TO THE DATABASE */
	public function Add() {

		/* CHECK FOR REQUIRED FIELDS */
		if (EMPTY($this->message)) { $this->Errors("Fixture date cannot be empty!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['mysql_db']."chat
					(user_id,message,date_sent)
					VALUES (
					'".$_SESSION['user_id']."',
					'".$this->message."',
					sysdate()
					)";
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