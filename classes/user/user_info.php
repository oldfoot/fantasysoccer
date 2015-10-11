<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

class UserInfo {

	function UserInfo($id) {

		$db=$GLOBALS['db'];

		$sql="SELECT full_name,username,password,identity_number,tel_cellular,tel_home,address,session_id,language,
					editing_language,date_last_login,email_address,role_id,date_created,count_login,fixture_type_id_last_login,
					team_name
					FROM ".$GLOBALS['mysql_db']."user_master um
					WHERE user_id = '".$id."'
					";
		//echo $sql."<br>";
		$result = $db->query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->full_name=$row["full_name"];
				$this->username=$row["username"];
				$this->password=$row["password"];
				$this->identity_number=$row["identity_number"];
				$this->tel_cellular=$row["tel_cellular"];
				$this->tel_home=$row["tel_home"];
				$this->address=$row["address"];
				$this->session_id=$row["session_id"];
				$this->language=$row["language"];
				$this->editing_language=$row["editing_language"];
				$this->date_last_login=$row["date_last_login"];
				$this->email_address=$row["email_address"];
				$this->role_id=$row["role_id"];
				$this->date_created=$row["date_created"];
				$this->count_login=$row["count_login"];
				$this->fixture_type_id_last_login=$row["fixture_type_id_last_login"];
				$this->team_name=$row["team_name"];
			}
		}
	}

	/* GET A COLUMN NAME FROM THE ARRAY */
	function GetColVal($col_name) {
		return $this->$col_name;
	}
}
?>