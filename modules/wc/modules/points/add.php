<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/functions/forms/add_points.php";

function Add() {
	$position_id="";
	$points_type_id="";
	
	if (ISSET($_GET['subtask']) && $_GET['subtask']=="edit" && ISSET($_GET['fixture_id']) && IS_NUMERIC($_GET['fixture_id'])) {
		
		require_once $GLOBALS['dr']."modules/wc/classes/points.php";
		$points=new Points;
		$points->SetParameters($fixture_id);
		$team_id_1=$tm->GetInfo("team_id_1");
		$team_id_2=$tm->GetInfo("team_id_2");
		$date_fixture=$tm->GetInfo("date_fixture");
		$fixture_type_id=$tm->GetInfo("fixture_type_id");
	}
	else {
		$points="";
		$fixture_id="";
		$team_id_1="";
		$team_id_2="";
		$date_fixture="";
		$fixture_type_id="";
	}
	/* FORM TO ADD TEAM */
	return CurveBox(AddPoints($points,$fixture_type_id,$position_id,$points_type_id));
}
?>