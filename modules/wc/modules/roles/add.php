<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/functions/forms/add_role.php";

function Add() {

	if (ISSET($_GET['subtask']) && $_GET['subtask']=="edit" && ISSET($_GET['role_id']) && IS_NUMERIC($_GET['role_id'])) {
		$role_id=$_GET['role_id'];
		require_once $GLOBALS['dr']."modules/wc/classes/role_id.php";
		$tm=new RoleID;
		$tm->SetParameters($role_id);
		$role_name=$tm->GetInfo("role_name");
	}
	else {
		$role_id="";
		$role_name="";
	}
	/* FORM TO ADD ROLE */
	return CurveBox(AddRole($role_id,$role_name));
}
?>