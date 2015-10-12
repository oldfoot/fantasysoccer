<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

require_once $GLOBALS['dr']."modules/wc/classes/player_id.php";

class FixtureResults {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function CheckParameters() {
		
		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTHS OF VARIABLES */		
		if (!IS_NUMERIC($this->fixture_id)) {$this->Errors("Invalid fixture ID!"); return False; }
		if (!IS_NUMERIC($this->yellow_cards_team_1)) {$this->Errors("Team 1 invalid yellow cards!"); return False; }
		if (!IS_NUMERIC($this->red_cards_team_1)) {$this->Errors("Team 1 invalid red cards!"); return False; }
		if (!IS_NUMERIC($this->hatricks_team_1)) {$this->Errors("Team 1 invalid hatricks!"); return False; }
		if (!IS_NUMERIC($this->goals_team_2)) {$this->Errors("Team 2 invalid goals!"); return False; }
		if (!IS_NUMERIC($this->yellow_cards_team_2)) {$this->Errors("Team 2 invalid yellow cards!"); return False; }
		if (!IS_NUMERIC($this->red_cards_team_2)) {$this->Errors("Team 2 invalid red cards!"); return False; }
		if (!IS_NUMERIC($this->hatricks_team_2)) {$this->Errors("Team 2 invalid hatricks!"); return False; }

		/* CHECK IF THE IDENTITY NUMBER EXISTS */
		if (!RowExists("fixture_master","fixture_id",$this->fixture_id,"")) { $this->Errors("Fixture does not exist!"); return False; }
		
		/* CREATE A NEW FIXTURE MASTER OBJECT */
		$fi=new FixtureID;
		$fi->SetParameters($this->fixture_id);
		$this->fixture_type_id=$fi->GetInfo("fixture_type_id");
		
		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		return True;
	}	

	/* THIS RETURNS INFORMATION ABOUT THE USER'S TEAM */
	public function UpdateFixtureMaster() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }
		
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['database_ref']."fixture_master SET
					goals_team_1 = ".$this->goals_team_1.",
					goals_team_2 = ".$this->goals_team_2.",
					yellow_cards_team_1 = ".$this->yellow_cards_team_1.",
					yellow_cards_team_2 = ".$this->yellow_cards_team_2.",
					red_cards_team_1 = ".$this->red_cards_team_1.",
					red_cards_team_2 = ".$this->red_cards_team_2.",
					hatricks_team_1 = ".$this->hatricks_team_1.",
					hatricks_team_2 = ".$this->hatricks_team_2."
					WHERE fixture_id = ".$this->fixture_id."
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
	
	/* AWARD THE GOAL SCORERS */
	public function AwardPoints($player_id,$desc) {
		
		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }
		
		/* START A NEW INSTANCE OF THE PLAYER ID CLASS */
		$pi=new PlayerID;
		$pi->SetParameters($player_id);
		$position_id=$pi->GetInfo("position_id");
		$player_name=$pi->GetInfo("player_name");		
		
		/* DETERMINE THE NUMBER OF POINTS TO BE AWARDED */
		$points=$this->GetPoints($desc,$position_id);
				
		/* DATABASE VARIABLE */
		$db=$GLOBALS['db'];
		
		/* LOOP ALL THE USERS WHO HAVE THIS PLAYER IN THIS STAGE */
		$sql="SELECT user_id
					FROM ".$GLOBALS['database_ref']."user_team
					WHERE player_id = ".$player_id."
					AND fixture_type_id = '".$this->fixture_type_id."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$sql="INSERT INTO ".$GLOBALS['database_ref']."user_points (user_id,points,description,points_type,fixture_id,fixture_type_id)
							VALUES (
							'".$row['user_id']."',
							'".$points."',
							'".$player_name."',
							'".$desc."',
							".$this->fixture_id.",
							".$this->fixture_type_id."							
							)
							";
				//echo $sql."<br>";
				$db->Query($sql);
			}
		}
		return True;
	}
	
	/* AWARD THE GOALKEEPER CLEAN SHEET */
	//public function AwardPointsGoalkeeperCleanSheet($player_id,$desc) {
		
	//}
	
	/* GET POINTS FOR A TYPE OF ACTIVITY AND POSITION */
	private function GetPoints($description,$position_id) {
	  
	  $db=$GLOBALS['db'];
	  $sql="SELECT pm.points
					FROM wc_points_type_master ptm, wc_points_master pm
					WHERE ptm.description = '".$description."'
					AND ptm.points_type_id = pm.points_type_id
					AND pm.fixture_type_id = ".$this->fixture_type_id."
					AND pm.position_id = ".$position_id."
					";
	 	//echo $sql."<br>";
	  $result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				return $row['points'];
			}
		}
		else {
			return "0";
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