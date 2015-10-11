<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."include/functions/db/count_rows.php";
require_once $GLOBALS['dr']."modules/wc/classes/user_team.php";


function LoadTask() {
	if ($GLOBALS['ws']->GetInfo("setup_failed")) { return "Game not setup correctly"; }
	/* COPY THE USER'S TEAM IF HE LAST LOGGED INTO A PREVIOUS STAGE/FIXTURE */
	$v_total_in_team=CountRows("user_team","user_id","*","WHERE user_id = '".$_SESSION['user_id']."' AND fixture_type_id = '".$GLOBALS['ws']->GetInfo("fixture_type_id")."'",True);
	//echo "Total in team: ".$v_total_in_team;
	if ($v_total_in_team == 0 || ($GLOBALS['ui']->GetColVal("fixture_type_id_last_login") != $GLOBALS['ws']->GetInfo("fixture_type_id"))) {
		/* SET A NEW OBJECT */
		//echo "Adding team now";
		$ut=new UserTeam;
		$ut->SetVariable("fixture_type_id",$GLOBALS['ws']->GetInfo("fixture_type_id"));
		$ut->CopyTeamFromLastFixture();
		$ut->UpdateUserMasterFixtureID();
	}
	else {
		 //echo "Same login fixture id as now fixture id, non empty team";
	}

	$c="";
	$fixture_type_id=$GLOBALS['ws']->GetInfo("fixture_type_id");

	if (ISSET($_GET['subtask'])) {
		/* SET A NEW OBJECT */
		$ut=new UserTeam;
		/* DELETING THE PLAYER IN THE POSITION */
		if ($_GET['subtask']=="del_player") {
			$ut->SetParameters($_GET['player_id'],$fixture_type_id);
			$result=$ut->Delete();
			if (!$result) {
				$c.="Failed to delete player";
				$c.=$ut->ShowErrors();
			}
			else {
				$c.="Success, player deleted";
			}
		}
		else if ($_GET['subtask']=="reset") {
			$ut->SetVariable("fixture_type_id",$fixture_type_id);
			$result=$ut->RevertTeamToLastFixture();
			if (!$result) {
				$c.="Failed to reset team";
				$c.=$ut->ShowErrors();
			}
			else {
				$c.="Success, team reset";
			}
		}
		else {
			$player_id=$_POST["player_id"];
			$position=$_POST["position"];

			$ut->SetParameters($player_id,$fixture_type_id);
			$ut->SetVariable("position_location",$position);

			$result=$ut->Add();
			if (!$result) {
				//$c.="Failed";
				$c.=$ut->ShowErrors();
			}
			else {
				$c.="Success";
			}
		}
	}

	require_once $GLOBALS['dr']."classes/design/tab_boxes.php";

	$tab_array=array("browse","add");
	$tb=new TabBoxes;

	$c.=$tb->DrawBoxes($tab_array,$dr."modules/wc/modules/my_team/");

	if (ISSET($_GET['jshow'])) {
		$c.=$tb->BlockShow(EscapeData($_GET['jshow']));
	}


	return $c;
}
?>