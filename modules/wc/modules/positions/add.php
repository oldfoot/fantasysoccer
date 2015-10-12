<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/functions/forms/add_position.php";

function Add() {

	if (ISSET($_GET['subtask']) && $_GET['subtask']=="edit" && ISSET($_GET['position_id']) && IS_NUMERIC($_GET['position_id'])) {
		$position_id=$_GET['position_id'];
		require_once $GLOBALS['dr']."modules/wc/classes/position_id.php";
		$pi=new PositionID;
		$pi->SetParameters($position_id);
		$position_name=$pi->GetInfo("position_name");
		//echo $position_name;
	}
	else {
		$position_id="";
		$position_name="";
	}
	/* FORM TO ADD TEAM */
	return CurveBox(AddPosition($position_id,$position_name));
}
?>