<?php
/*
	THIS IS THE SYSTEM SETUP
*/

class WCSetup{

	function __construct() {
		/* CALL THE SETUP */
		$this->Setup();
		/* GET THE FIXTURES FOR THE CURRENT DATE */
		$this->FixtureTypeMaster();
	}

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* THIS RUNS THE QUERY */
	private function Setup() {

		$db=$GLOBALS['db'];

		$sql="SELECT site_title, date_close_predictions, team_setup, max_players_per_country
					FROM ".$GLOBALS['mysql_db']."setup
					WHERE id = 1
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->site_title=$row["site_title"];
				$this->date_close_predictions=$row["date_close_predictions"];
				$this->team_setup=$row["team_setup"];
				$this->max_players_per_country=$row["max_players_per_country"];
			}
		}
		else {
			$this->setup_failed=True;
		}
	}

	/* THIS RUNS THE QUERY */
	private function FixtureTypeMaster() {

		$db=$GLOBALS['db'];

		$sql="SELECT fixture_type_id, type_name
					FROM ".$GLOBALS['mysql_db']."fixture_type_master
					WHERE date_start <= sysdate()
					AND date_end >= sysdate()
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->fixture_type_id=$row["fixture_type_id"];
				$this->type_name=$row["type_name"];
			}
		}
		else {
			$this->setup_failed=True;
		}
	}

	/* GET ANY OF THE VARIABLES IN THE CLASS */
	public function GetInfo($v) {
		return $this->$v;
	}

	/* DRAW A NICE BOX WITH THE INFO */
	public function DrawSetupBox() {
		$c="";
		$c.="<table class='plain'>\n";
			$c.="<tr>\n";
				$c.="<td>Current stage: ".$this->type_name."</td>\n";
			$c.="</tr>\n";
		$c.="</table>\n";

		return $c;
	}

	private function Errors($err) {
		$this->errors.=$err."<br>";
	}

	public function ShowErrors() {
		return $this->errors;
	}
}
?>