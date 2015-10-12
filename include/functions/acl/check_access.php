<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function CheckAccess($role_id,$module,$task) {

	$db=$GLOBALS['db'];

	$sql="SELECT 'x'
				FROM ".$GLOBALS['database_ref']."role_priv rp
				WHERE rp.role_id = ".$role_id."
				AND rp.module = '".$module."'
				AND rp.task = '".$task."'
				AND rp.access = '".BoolDB(True)."'
				";
	//echo $sql."<br>";
	$result = $db->Query($sql);
	if ($db->NumRows($result) > 0) {
		return True;
	}
	else {
		return False;
	}
}
?>