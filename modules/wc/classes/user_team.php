<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

require_once $GLOBALS['dr']."modules/wc/classes/fixture_type_id.php";

require_once $GLOBALS['dr']."modules/wc/classes/player_id.php";

class UserTeam {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function SetParameters($player_id,$fixture_type_id) {

		/* SET VARIABLES IN THE GLOBAL SCOPE */
		$this->player_id=$player_id;
		$this->fixture_type_id=$fixture_type_id;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTHS OF VARIABLES */
		if (EMPTY($this->player_id)) {$this->Errors("Invalid team ID!"); return False; }
		if (!IS_NUMERIC($this->player_id)) {$this->Errors("Team ID not numeric!"); return False; }

		/* CHECK IF THE IDENTITY NUMBER EXISTS */
		if (!RowExists("player_master","player_id",$this->player_id,"")) { $this->Errors("Team does not exist!"); return False; }

		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		/* WE CALL THE INFO */
		$this->Info();

		return True;
	}

	/* THIS RETURNS INFORMATION ABOUT THE USER'S TEAM */
	private function Info() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }

		$db=$GLOBALS['db'];

		$sql="SELECT position_location
					FROM ".$GLOBALS['mysql_db']."user_team
					WHERE user_id = ".$_SESSION['user_id']."
					AND player_id = '".$this->player_id."'
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

	public function GetPlayerInPosition($p_pos) {
		/* FIXTURE ID CANNOT BE EMPTY */
		if (EMPTY($this->fixture_type_id) || !IS_NUMERIC($this->fixture_type_id)) { $this->Errors("Fixture cannot be empty!"); return False; }
		$db=$GLOBALS['db'];

		$sql="SELECT player_id
					FROM ".$GLOBALS['mysql_db']."user_team
					WHERE user_id = ".$_SESSION['user_id']."
					AND fixture_type_id = '".$this->fixture_type_id."'
					AND position_location = '".$p_pos."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				return $row["player_id"];
			}
		}
	}

	/* GET ANY OF THE VARIABLES IN THE CLASS */
	public function GetInfo($v) {
		return $this->$v;
	}

	/* ADD TO THE DATABASE */
	public function Add() {

		/* PLAYER ID CANNOT BE EMPTY */
		if (EMPTY($this->player_id) || !IS_NUMERIC($this->player_id)) { $this->Errors("Invalid player!"); return False; }
		/* FIXTURE ID CANNOT BE EMPTY */
		if (EMPTY($this->fixture_type_id) || !IS_NUMERIC($this->fixture_type_id)) { $this->Errors("Fixture cannot be empty!"); return False; }

		/* TEAM NAMES CAN'T BE DUPLICATED */
		if (RowExists("user_team","user_id",$_SESSION['user_id'],"AND player_id = '".$this->player_id."' AND fixture_type_id = '".$this->fixture_type_id."'")) { $this->Errors("That player exists in your team!"); return False; }

		/* COUNT THE MAX ALLOWED MOVES IN THE STAGE */
		//echo "Moves: ".$this->HasMovesLeft()."<br>";
		if (!$this->HasMovesLeft()) { $this->Errors("Your moves are up!"); return False; }

		/* COUNT HOW MANY PLAYERS FROM THIS COUNTRY THE USER HAS BASED ON THE SETUP TABLES */
		if ($this->PlayersFromCountry($this->player_id,$this->fixture_type_id) >= $GLOBALS['ws']->GetInfo("max_players_per_country")) { $this->Errors("Exceeded number of players from that country!"); return False; }

		/* COUNT HOW MANY IN THE CURRENT POSITION */
		if ($this->MaxPlayersInPosition($this->player_id,$this->fixture_type_id)) { $this->Errors("Total players in position reached. Delete one to continue!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['mysql_db']."user_team
					(user_id,player_id,fixture_type_id,position_location)
					VALUES (
					".$_SESSION['user_id'].",
					'".$this->player_id."',
					'".$this->fixture_type_id."',
					'".$this->position_location."'
					)";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			//LogHistory($this->team_name." added");
			$sql="INSERT INTO ".$GLOBALS['mysql_db']."user_team_change_log
						(user_id,player_id,fixture_type_id,status)
						VALUES (
						".$_SESSION['user_id'].",
						'".$this->player_id."',
						'".$this->fixture_type_id."',
						'add'
						)";
			//echo $sql;
			$result1=$db->Query($sql);
			if ($db->AffectedRows($result1) > 0) {
				return True;
			}
			else {
				return False;
			}
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
		$sql="UPDATE ".$GLOBALS['mysql_db']."team_master
					SET team_name = '".$this->team_name."'
					WHERE player_id = ".$this->player_id."
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
		$sql="DELETE FROM ".$GLOBALS['mysql_db']."user_team
					WHERE user_id = ".$_SESSION['user_id']."
					AND player_id = ".$this->player_id."
					AND fixture_type_id = ".$this->fixture_type_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			/* RECORD THE DROP */
			$sql="INSERT INTO ".$GLOBALS['mysql_db']."user_team_change_log
						(user_id,player_id,fixture_type_id,status)
						VALUES (
						".$_SESSION['user_id'].",
						'".$this->player_id."',
						'".$this->fixture_type_id."',
						'del'
						)";
			//echo $sql;
			$result1=$db->Query($sql);
			if ($db->AffectedRows($result1) > 0) {
				return True;
			}
			else {
				return False;
			}
		}
		else {
			return False;
		}
	}

	public function HasMovesLeft() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }

		/* GET IT FROM THE FIXTURE TYPE CLASS */
		$fti=new FixtureTypeID;
		$fti->SetParameters($this->fixture_type_id);

		$v_total_moves_allowed=$fti->GetInfo("max_replacements");
		if (is_null($v_total_moves_allowed)) { return True;	}

		$v_moves_done=$this->MovesDone();
		//echo "Allowed: ".$v_total_moves_allowed."<br>";
		//echo "Done: ".$v_moves_done."<br>";

		/* STORE THIS IN A VARIABLE FOR DISPLAY PURPOSES */
		$this->moves_left=($v_total_moves_allowed-$v_moves_done);

		if ($v_moves_done == $v_total_moves_allowed) {
			return False;
		}
		else {
			return True;
		}
	}

	private function MovesDone() {

		/* COUNT HOW MANY MOVES THE USER HAS DONE IN THE CURRENT STAGE */
		$db=$GLOBALS['db'];
		$sql="SELECT count(*) as total
					FROM ".$GLOBALS['mysql_db']."user_team_change_log
					WHERE user_id = ".$_SESSION['user_id']."
					AND fixture_type_id = '".$this->fixture_type_id."'
					AND status = 'add'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				return $row["total"];
			}
		}
	}

	private function PlayersFromCountry($player_id,$fixture_type_id) {

		$pi=new PlayerID;
		$pi->SetParameters($player_id);

		$team_id=$pi->GetInfo("team_id");

		/* COUNT HOW MANY PLAYERS FROM THE COUNTRY THE USER HAS IN THE CURRENT STAGE */
		$db=$GLOBALS['db'];
		$sql="SELECT count(*) as total
					FROM ".$GLOBALS['mysql_db']."user_team ut, ".$GLOBALS['mysql_db']."player_master pm
					WHERE ut.user_id = ".$_SESSION['user_id']."
					AND ut.fixture_type_id = ".$fixture_type_id."
					AND ut.player_id = pm.player_id
					AND pm.team_id = ".$team_id."
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				return $row["total"];
			}
		}
	}

	private function MaxPlayersInPosition($player_id,$fixture_type_id) {

		$pi=new PlayerID;
		$pi->SetParameters($player_id);

		$position_name=$pi->GetInfo("position_name");

		/* COUNT HOW MANY PLAYERS FROM THE COUNTRY THE USER HAS IN THE CURRENT STAGE */
		$db=$GLOBALS['db'];
		$sql="SELECT count(*) as total
					FROM ".$GLOBALS['mysql_db']."user_team ut, ".$GLOBALS['mysql_db']."player_master pm,
					".$GLOBALS['mysql_db']."position_master pom
					WHERE ut.user_id = '".$_SESSION['user_id']."'
					AND ut.fixture_type_id = ".$fixture_type_id."
					AND ut.player_id = pm.player_id
					AND pm.position_id = pom.position_id
					AND pom.position_name = '".$position_name."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				if ($position_name=="Goalkeeper") {
					echo "yes";
					if ($row["total"]==1) { return True; } else { return false; }
				}
				elseif ($position_name=="Defender") {
					if ($row["total"]==4) { return True; } else { return false; }
				}
				elseif ($position_name=="Midfield") {
					if ($row["total"]==4) { return True; } else { return false; }
				}
				elseif ($position_name=="Striker") {
					if ($row["total"]==2) { return True; } else { return false; }
				}
			}
		}
	}

	public function CopyTeamFromLastFixture() {

		$db=$GLOBALS['db'];
		$sql="SELECT user_id,player_id,position_location
					FROM ".$GLOBALS['mysql_db']."user_team
					WHERE user_id = ".$_SESSION['user_id']."
					AND fixture_type_id = '".($this->fixture_type_id-1)."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$sql="INSERT INTO ".$GLOBALS['mysql_db']."user_team (user_id,player_id,fixture_type_id,position_location)
							VALUES (
							'".$row['user_id']."',
							'".$row['player_id']."',
							'".$this->fixture_type_id."',
							'".$row['position_location']."'
							)
							";
				$db->Query($sql);
			}
		}
	}

	public function RevertTeamToLastFixture() {
		$db=$GLOBALS['db'];

		/* FIXTURE ID CANNOT BE EMPTY */
		if (EMPTY($this->fixture_type_id) || !IS_NUMERIC($this->fixture_type_id)) { $this->Errors("Fixture cannot be empty!"); return False; }

		/* DELETE ALL THE CURRENT SELECTIONS */
		$sql="DELETE FROM ".$GLOBALS['mysql_db']."user_team
					WHERE user_id = ".$_SESSION['user_id']."
					AND fixture_type_id = '".$this->fixture_type_id."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);

		/* DELETE THE LOG */
		$sql="DELETE FROM ".$GLOBALS['mysql_db']."user_team_change_log
					WHERE user_id = ".$_SESSION['user_id']."
					AND fixture_type_id = '".$this->fixture_type_id."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);

		/* RESTORE THE PREVIOUS ONES */
		$sql="SELECT user_id,player_id,position_location
					FROM ".$GLOBALS['mysql_db']."user_team
					WHERE user_id = ".$_SESSION['user_id']."
					AND fixture_type_id = '".($this->fixture_type_id-1)."'
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$sql="INSERT INTO ".$GLOBALS['mysql_db']."user_team (user_id,player_id,fixture_type_id,position_location)
							VALUES (
							'".$row['user_id']."',
							'".$row['player_id']."',
							'".$this->fixture_type_id."',
							'".$row['position_location']."'
							)
							";
				$db->Query($sql);
			}
		}
		return True;
	}

	public function UpdateUserMasterFixtureID() {
	  $db=$GLOBALS['db'];
	  $sql="UPDATE ".$GLOBALS['mysql_db']."user_master
	  		SET fixture_type_id_last_login = ".$this->fixture_type_id."
	  		WHERE user_id = ".$_SESSION['user_id']."
	  		";
	  //echo $sql;
	  $db->Query($sql);
	}

	private function Errors($err) {
		$this->errors.=$err."<br>";
	}

	public function ShowErrors() {
		return $this->errors;
	}
}
?>