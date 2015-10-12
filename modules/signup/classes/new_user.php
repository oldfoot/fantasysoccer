<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

class NewUser {
	
	public function __construct() {
		$this->errors = "";
	}
	
	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function SetParameters($full_name,$username,$password,$identity_number,$tel_cellular,$address,$email_address) {
		$this->full_name=$full_name;
		$this->username=$username;
		$this->password=$password;
		$this->identity_number=$identity_number;
		$this->tel_cellular=$tel_cellular;
		$this->address=$address;
		$this->email_address=$email_address;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTHS OF VARIABLES */
		if (EMPTY($this->full_name)) {$this->Errors("Full name cannot be empty!"); return False; }
		if (EMPTY($this->username)) {$this->Errors("Full name cannot be empty!"); return False; }
		if (EMPTY($this->password)) {$this->Errors("Full name cannot be empty!"); return False; }
		if (EMPTY($this->identity_number)) {$this->Errors("Full name cannot be empty!"); return False; }
		if (EMPTY($this->email_address)) {$this->Errors("Email address can't be empty!"); return False; }

		/* CHECK IF THE USERNAME EXISTS */
		if (RowExists("user_master","username",$this->username,"")) { $this->Errors("Username exists. Please choose another.!"); return False; }

		/* CHECK IF THE IDENTITY NUMBER EXISTS */
		if (RowExists("user_master","identity_number",$this->identity_number,"")) { $this->Errors("Identity number exists. Please recover your password.!"); return False; }

		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		return True;
	}
	/* SAVE TO THE DATABASE */
	public function SaveToDb() {
		if ($this->parameter_check) {
			$db=$GLOBALS['db'];
			$sql="INSERT INTO ".$GLOBALS['database_ref']."user_master
						(full_name,username,password,identity_number,tel_cellular,tel_home,address,email_address,role_id,date_created)
						VALUES (
						'".$this->full_name."',
						'".$this->username."',
						'".MD5($this->password)."',
						'".$this->identity_number."',
						'".@$this->tel_cellular."',
						'".@$this->tel_home."',
						'".@$this->address."',
						'".$this->email_address."',
						'".$this->DefaultRole()."',
						sysdate()
						)
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
	}

	public function DefaultRole() {

		/* GET THE DEFAULT ROLE */
		$db=$GLOBALS['db'];
		$sql="SELECT role_id
					FROM ".$GLOBALS['database_ref']."role_master
					WHERE default_role = 'y'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				return $row["role_id"];
			}
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