<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/functions/forms/add_player.php";

function Add() {

	if (ISSET($_GET['subtask']) && $_GET['subtask']=="edit" && ISSET($_GET['player_id']) && IS_NUMERIC($_GET['player_id'])) {
		$player_id=$_GET['player_id'];
		require_once $GLOBALS['dr']."modules/wc/classes/player_id.php";
		$tm=new PlayerID;
		$tm->SetParameters($player_id);
		$player_name=$tm->GetInfo("player_name");
		$team_id=$tm->GetInfo("team_id");
		$position_id=$tm->GetInfo("position_id");
	}
	else {
		$player_id="";
		$player_name="";
		$team_id="";
		$position_id="";
	}
	/* FORM TO ADD TEAM */
	return CurveBox(AddPlayer($player_id,$player_name,$team_id,$position_id));
}
?>