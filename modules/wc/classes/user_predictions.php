<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

require_once $GLOBALS['dr']."modules/wc/classes/fixture_type_id.php";

class UserPredictions {
	
	public function __construct() {
		$this->errors = "";
	}
	
	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}
	/* SET PARAMETERS */
	public function SetParameters($team_id,$fixture_type_id) {

		/* SET VARIABLES IN THE GLOBAL SCOPE */
		$this->team_id=$team_id;
		$this->fixture_type_id=$fixture_type_id;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTHS OF VARIABLES */
		if (EMPTY($this->team_id) || !IS_NUMERIC($this->team_id)) {$this->Errors("Invalid team!"); return False; }

		/* CHECK IF THE TEAM EXISTS */
		if (!RowExists("team_master","team_id",$this->team_id,"")) { $this->Errors("Team does not exist!"); return False; }

		/* CHECK IF THE FIXTURE EXISTS */
		if (!RowExists("fixture_type_master","fixture_type_id",$this->fixture_type_id,"")) { $this->Errors("Invalid stage!"); return False; }

		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		/* WE CALL THE INFO */
		//$this->Info();

		return True;
	}
	/* THIS RETURNS INFORMATION ABOUT THE USER'S TEAM */

	private function Info() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }

		$db=$GLOBALS['db'];

		$sql="SELECT position_location
					FROM ".$GLOBALS['database_ref']."user_team
					WHERE user_id = ".$_SESSION['user_id']."
					AND team_id = '".$this->team_id."'
					AND fixture_type_id = '".$this->fixture_type_id."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->position_location=$row["position_location"];
			}
		}
	}
	public function GetTeamPredictions($p_fixture_type_id) {

		$teams="";

		/* CHECK THE LENGTHS OF VARIABLES */
		//if (EMPTY($this->p_fixture_type_id) || !IS_NUMERIC($this->p_fixture_type_id)) {$this->Errors("Invalid team!"); return False; }
		//echo $p_fixture_type_id."<br>";

		$db=$GLOBALS['db'];

		$sql="SELECT tm.team_id,tm.team_name,tm.logo_location
					FROM ".$GLOBALS['database_ref']."user_predictions up, ".$GLOBALS['database_ref']."team_master tm
					WHERE up.user_id = ".$_SESSION['user_id']."
					AND up.fixture_type_id = '".$p_fixture_type_id."'
					AND up.team_id = tm.team_id
					ORDER BY tm.team_name
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			$count=1;
			while($row = $db->FetchArray($result)) {
				$teams.=$count++." <img src='".$row['logo_location']."'> ".$row['team_name']." | <a href='index.php?module=wc&task=my_predictions&subtask=delete&team_id=".$row['team_id']."&fixture_type_id=".$p_fixture_type_id."' title='Click to delete'>Delete</a><br>";
			}
		}
		return $teams;
	}
	/* GET ANY OF THE VARIABLES IN THE CLASS */
	public function GetInfo($v) {
		return $this->$v;
	}
	/* ADD TO THE DATABASE */
	public function Add() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) { $this->Errors("Parameter check failed."); return False; }

		/* CHECK IF THE TEAM IN THE STAGE EXISTS */
		if (RowExists("user_predictions","user_id",$_SESSION['user_id'],"AND team_id = ".$this->team_id." AND fixture_type_id = ".$this->fixture_type_id)) { $this->Errors("You already have that team!"); return False; }

		/* CHECK MAX PREDICTIONS */
		$fti=new FixtureTypeId;
		$fti->SetParameters($this->fixture_type_id);

		if ($this->TotalPredictions() >= $fti->GetInfo("prediction_total")) { $this->Errors("Max predictions reached!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['database_ref']."user_predictions
					(user_id,team_id,fixture_type_id)
					VALUES (
					".$_SESSION['user_id'].",
					'".$this->team_id."',
					'".$this->fixture_type_id."'
					)";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			//LogHistory($this->team_id." added to prediction stage: ".$this->fixture_type_id);
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
		/* ENSURE THE TEAM NAME IS NOT EMPTY */
		if (EMPTY($this->team_name)) { $this->Errors("Team name can't be empty."); return False; }
		/* TEAM NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->team_name)) { $this->Errors("Invalid team name. Use only alpha-numeric characters!"); return False; }
		/* TEAM NAMES CAN'T BE DUPLICATED */
		if (RowExists("team_master","team_name",$this->team_name,"")) { $this->Errors("Team exists!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['database_ref']."team_master
					SET team_name = '".$this->team_name."'
					WHERE team_id = ".$this->team_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->team_name." edited");
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
		$sql="DELETE FROM ".$GLOBALS['database_ref']."user_predictions
					WHERE user_id = ".$_SESSION['user_id']."
					AND team_id = ".$this->team_id."
					AND fixture_type_id = ".$this->fixture_type_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->team_id." deleted from prediction stage: ".$this->fixture_type_id);
			return True;
		}
		else {
			return False;
		}
	}

	private function TotalPredictions() {

		/* COUNT HOW MANY PREDICTIONS THE USER HAS IN THE CURRENT STAGE */
		$db=$GLOBALS['db'];
		$sql="SELECT count(*) as total
					FROM ".$GLOBALS['database_ref']."user_predictions up
					WHERE user_id = ".$_SESSION['user_id']."
					AND fixture_type_id = ".$this->fixture_type_id."
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				return $row["total"];
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