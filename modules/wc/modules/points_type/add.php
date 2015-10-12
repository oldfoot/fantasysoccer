<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/functions/forms/add_points_type.php";

function Add() {

	if (ISSET($_GET['subtask']) && $_GET['subtask']=="edit" && ISSET($_GET['points_type_id']) && IS_NUMERIC($_GET['points_type_id'])) {
		$points_type_id=$_GET['points_type_id'];
		require_once $GLOBALS['dr']."modules/wc/classes/points_type_id.php";
		$pti=new PointsTypeID;
		$pti->SetParameters($points_type_id);
		$description=$pti->GetInfo("description");
		//echo $description;
	}
	else {
		$points_type_id="";
		$description="";
	}
	/* FORM TO ADD TEAM */
	return CurveBox(AddPointsType($points_type_id,$description));
}
?>