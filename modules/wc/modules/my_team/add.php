<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/functions/forms/add_my_players.php";

function Add() {

	if (ISSET($_GET['subtask']) && $_GET['subtask']=="edit" && ISSET($_GET['team_id']) && IS_NUMERIC($_GET['team_id'])) {
		$team_id=$_GET['team_id'];
		require_once $GLOBALS['dr']."modules/wc/classes/team_id.php";
		$tm=new TeamID;
		$tm->SetParameters($team_id);
		$team_name=$tm->GetInfo("team_name");
		//echo $team_name;
	}
	else {
		$team_id="";
		$team_name="";
	}
	/* FORM TO ADD TEAM */
	return CurveBox(AddMyPlayers());
}
?>