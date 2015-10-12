<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/functions/forms/add_fixtures.php";

function Add() {

	if (ISSET($_GET['subtask']) && $_GET['subtask']=="edit" && ISSET($_GET['fixture_id']) && IS_NUMERIC($_GET['fixture_id'])) {
		$fixture_id=$_GET['fixture_id'];
		require_once $GLOBALS['dr']."modules/wc/classes/fixture_id.php";
		$tm=new FixtureID;
		$tm->SetParameters($fixture_id);
		$team_id_1=$tm->GetInfo("team_id_1");
		$team_id_2=$tm->GetInfo("team_id_2");
		$date_fixture=$tm->GetInfo("date_fixture");
		$fixture_type_id=$tm->GetInfo("fixture_type_id");
	}
	else {
		$fixture_id="";
		$team_id_1="";
		$team_id_2="";
		$date_fixture="";
		$fixture_type_id="";
	}
	/* FORM TO ADD TEAM */
	return CurveBox(AddFixtures($fixture_id,$team_id_1,$team_id_2,$date_fixture,$fixture_type_id));
}
?>