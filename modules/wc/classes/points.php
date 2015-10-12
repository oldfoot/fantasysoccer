<?php
/*
	THIS CLASS IS USED TO CREATE A NEW USER
*/

require_once $GLOBALS['dr']."include/functions/db/row_exists.php";

class Points {

	/* THIS FUNCTION ALLOWS US TO SET VARIABLES DYNAMICALLY*/
	public function SetVariable($var,$value) {
		//echo $var." = ".$value."<br>";
		$this->$var=$value;
	}

	/* SET PARAMETERS */
	public function SetParameters($fixture_type_id,$position_id,$points_type_id) {

		/* SET VARIABLES IN THE GLOBAL SCOPE */
		$this->fixture_type_id=$fixture_type_id;
		$this->position_id=$position_id;
		$this->points_type_id=$points_type_id;

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECK THE LENGTH OF VARIABLES */		
		if (EMPTY($this->fixture_type_id) || !IS_NUMERIC($this->fixture_type_id)) { $this->Errors("Invalid stage!"); return False; }
		if (EMPTY($this->position_id) || !IS_NUMERIC($this->position_id)) { $this->Errors("Invalid position!"); return False; }
		if (EMPTY($this->points_type_id) || !IS_NUMERIC($this->points_type_id)) { $this->Errors("Invalid points type!"); return False; }
		
		
		/* CHECK IF THE VALUES IN THE DATABASE EXIST */
		if (!RowExists("fixture_type_master","fixture_type_id",$this->fixture_type_id,"")) { $this->Errors("Stage does not exist!"); return False; }
		if (!RowExists("points_master","position_id",$this->position_id,"")) { $this->Errors("Stage does not exist!"); return False; }
		if (!RowExists("points_master","points_type_id",$this->points_type_id,"")) { $this->Errors("Stage does not exist!"); return False; }

		/* SET CHECKING TO TRUE IF ALL OK */
		$this->parameter_check=True;

		/* WE CALL THE INFO */
		$this->Info();

		return True;
	}

	/* THIS RETURNS INFORMATION ABOUT THE FIXTURE ID*/
	private function Info() {

		/* PARAMETER CHECK */
		if (!$this->parameter_check) {$this->Errors("Parameter check failed."); return False; }

		$db=$GLOBALS['db'];

		$sql="SELECT pm.points, ftm.type_name, pom.position_name, ptm.description
					FROM ".$GLOBALS['database_ref']."points_master pm, ".$GLOBALS['database_ref']."fixture_type_master ftm, 
					".$GLOBALS['database_ref']."position_master pom, ".$GLOBALS['database_ref']."points_type_master ptm
					WHERE pm.fixture_type_id = ".$this->fixture_type_id."
					AND pm.position_id = ".$this->position_id."
					AND pm.points_type_id = ".$this->points_type_id."
					AND pm.fixture_type_id = ftm.fixture_type_id
					AND pm.position_id = pom.position_id
					AND pm.points_type_id = ptm.points_type_id						
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$this->points=$row["points"];
				$this->type_name=$row["type_name"];
				$this->position_name=$row["position_name"];
				$this->description=$row["description"];				
			}
		}
	}

	/* GET ANY OF THE VARIABLES IN THE CLASS */
	public function GetInfo($v) {
		return $this->$v;
	}

	/* ADD TO THE DATABASE */
	public function Add() {

		/* CHECK FOR REQUIRED FIELDS */
		if (!ISSET($this->points) || !IS_NUMERIC($this->points)) { $this->Errors("Invalid number of points!"); return False; }
		
		/* ADD */
		$db=$GLOBALS['db'];
		$sql="INSERT INTO ".$GLOBALS['database_ref']."points_master
					(points,fixture_type_id,position_id,points_type_id)
					VALUES (
					'".$this->points."',
					'".$this->fixture_type_id."',
					'".$this->position_id."',
					'".$this->points_type_id."'
					)";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory("Total points ".$this->points." added");
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

		if (EMPTY($this->team_id_1) || !IS_NUMERIC($this->team_id_1)) { $this->Errors("Invalid team 1!"); return False; }
		if (EMPTY($this->team_id_2) || !IS_NUMERIC($this->team_id_2)) { $this->Errors("Invalid team 2!"); return False; }
		if (EMPTY($this->date_fixture)) { $this->Errors("Fixture date cannot be empty!"); return False; }

		/* ADD */
		$db=$GLOBALS['db'];
		$sql="UPDATE ".$GLOBALS['database_ref']."fixture_master
					SET team_id_1 = '".$this->team_id_1."',
					team_id_2 = '".$this->team_id_2."',
					date_fixture = '".$this->date_fixture."',
					fixture_type_id = '".$this->fixture_type_id."'
					WHERE fixture_id = ".$this->fixture_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory("Fixture on ".$this->date_fixture." edited");
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
		$sql="DELETE FROM ".$GLOBALS['database_ref']."points_master
					WHERE fixture_type_id = ".$this->fixture_type_id."
					AND position_id = ".$this->position_id."
					AND points_type_id = ".$this->points_type_id."
					";
		//echo $sql;
		$result=$db->Query($sql);
		if ($db->AffectedRows($result) > 0) {
			LogHistory("Points ".$this->fixture_type_id."-".$this->position_id."-".$this->points_type_id." deleted");
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