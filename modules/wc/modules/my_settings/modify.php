<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/functions/forms/modify_my_settings.php";

function Modify() {

	if (ISSET($_GET['subtask']) && $_GET['subtask']=="edit" && ISSET($_GET['fixture_type_id']) && IS_NUMERIC($_GET['fixture_type_id'])) {
		$fixture_type_id=$_GET['fixture_type_id'];
		require_once $GLOBALS['dr']."modules/wc/classes/fixture_type_id.php";
		$tm=new FixtureTypeID;
		$tm->SetParameters($fixture_type_id);
		$type_name=$tm->GetInfo("type_name");
		$date_start=$tm->GetInfo("date_start");
		$date_end=$tm->GetInfo("date_end");
		$prediction_allow=$tm->GetInfo("prediction_allow");
		$prediction_total=$tm->GetInfo("prediction_total");
	}
	else {
		$fixture_type_id="";
		$type_name="";
		$date_start="";
		$date_end="";
		$prediction_allow="";
		$prediction_total="";
	}
	/* FORM TO ADD TEAM */
	if ($_GET['subtask']=="modify") {
		return "<a href='index.php?module=wc&task=my_settings'>Refresh</a>";
	}
	else {
		return CurveBox(ModifyMySettings());
	}
}
?>