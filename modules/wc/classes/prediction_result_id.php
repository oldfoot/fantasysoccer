<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";
require_once $GLOBALS['dr']."modules/wc/classes/team_id.php";

class PredictionResultID {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function SetParameters($prediction_result_id) {

		/* SET VARIABLES IN THE GLOBAL SCOPE */
		$this->prediction_result_id=$prediction_result_id;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTHS OF VARIABLES */
		if (EMPTY($this->prediction_result_id) || !IS_NUMERIC($this->prediction_result_id)) { $this->Errors("Invalid record!"); return False; }

		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		/* WE CALL THE INFO */
		$this->Info();

		return True;
	}

	/* THIS RETURNS INFORMATION ABOUT THE PLAYER ID*/
	private function Info() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }

		$db=$GLOBALS['db'];

		$sql="SELECT pr.fixture_type_id, pr.team_id
					FROM ".$GLOBALS['mysql_db']."prediction_results pr
					WHERE pr.prediction_result_id = '".$this->prediction_result_id."'					
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {				
				$this->fixture_type_id=$row["fixture_type_id"];				
				$this->team_id=$row["team_id"];		
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
		if (EMPTY($this->fixture_type_id)) { $this->Errors("Fixture required!"); return False; }
		/* PLAYER NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->team_id)) { $this->Errors("Invalid team!"); return False; }
		/* TEAM ID MUST EXIST */
		if (!RowExists("team_master","team_id",$this->team_id,"")) { $this->Errors("Invalid team!"); return False; }
		/* POSITION ID MUST EXIST */
		if (!RowExists("fixture_type_master","fixture_type_id",$this->fixture_type_id,"")) { $this->Errors("Invalid position!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['mysql_db']."prediction_results
					(fixture_type_id,team_id)
					VALUES (
					'".$this->fixture_type_id."',
					'".$this->team_id."'
					)";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory("Prediction result for fixture ".$this->fixture_type_id." for team ".$this->team_id." added");
			$this->GrantPoints($this->fixture_type_id,$this->team_id);
			return True;
		}
		else {
			return False;
		}
	}
	
	private function GrantPoints($fixture_type_id,$team_id) {
		$db=$GLOBALS['db'];

		$sql="SELECT user_id
			  FROM ".$GLOBALS['mysql_db']."user_predictions
			  WHERE team_id = '".$team_id."' 
			  AND fixture_type_id = '".$fixture_type_id."'
			  ";
		echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				//$fti=New FixtureTypeID();
				//$fti->SetParameters($fixture_type_id);
				$ti=New TeamID;
				$ti->SetParameters($team_id);
				$team_name=$ti->GetInfo("team_name");
				
				$sql="INSERT INTO ".$GLOBALS['mysql_db']."user_points
					  (user_id,points,description,points_type,fixture_id,fixture_type_id)
					  VALUES (
					  '".$row['user_id']."',					  
					  2,
					  'Correct prediction for ".$team_name."',
					  Null,
					  Null,
					  Null
					  )";
				//echo $sql."<br>";
				$db->Query($sql);					  
			}
		}
	}

	/* ADD TO THE DATABASE */
	public function Edit() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) { $this->Errors("Parameter check failed."); return False; }
		/* PLAYER NAME CANNOT BE EMPTY */
		if (EMPTY($this->player_name)) { $this->Errors("Player name cannot be empty!"); return False; }
		/* PLAYER NAMES MUST BE CHARACTERS OR LETTERS */
		if (!IsAlphaNumeric($this->player_name)) { $this->Errors("Invalid team name. Use only alpha-numeric characters!"); return False; }
		/* TEAM ID MUST EXIST */
		if (!RowExists("team_master","team_id",$this->team_id,"")) { $this->Errors("Invalid team!"); return False; }
		/* POSITION ID MUST EXIST */
		if (!RowExists("position_master","position_id",$this->position_id,"")) { $this->Errors("Invalid position!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['mysql_db']."player_master
					SET player_name = '".$this->player_name."',
					team_id = '".$this->team_id."',
					position_id = '".$this->position_id."'
					WHERE prediction_result_id = ".$this->prediction_result_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->player_name." edited");
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
		$sql="DELETE FROM ".$GLOBALS['mysql_db']."prediction_results
					WHERE prediction_result_id = ".$this->prediction_result_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory($this->prediction_result_id." deleted");
			// THE ONLY WAY FOR NOW
			$ti=New TeamID;
			$ti->SetParameters($this->team_id);
			$team_name=$ti->GetInfo("team_name");
			$description="Correct prediction for ".$team_name;
			
			$sql="DELETE FROM ".$GLOBALS['mysql_db']."user_points
				  WHERE description = '".$description."'
				  ";
			//echo $sql;
			$result=$db->Query($sql);
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