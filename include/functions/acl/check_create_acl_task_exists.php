<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function CheckCreateACLTaskExists($role_id,$module,$task,$access="f") {

	if (EMPTY($role_id)) { return False; }
	if (EMPTY($module)) { return False; }
	if (EMPTY($task)) { return False; }

	$db=$GLOBALS['db'];

	$sql="SELECT 'x'
				FROM ".$GLOBALS['database_ref']."role_priv rp
				WHERE rp.role_id = ".$role_id."
				AND rp.module = '".$module."'
				AND rp.task = '".$task."'
				";
	//echo $sql."<br>";
	$result = $db->Query($sql);
	if ($db->NumRows($result) > 0) {
		return True;
	}
	else {
		$sql="INSERT INTO ".$GLOBALS['database_ref']."role_priv
					(role_id,module,task,access)
					VALUES (
					".$role_id.",
					'".$module."',
					'".$task."',
					'".BoolDB($access)."'
					)";
		//echo $sql."<br>";
		$success=$db->Query($sql);
		if ($db->AffectedRows($success) > 0) {
			return True;
		}
		else {
			return False;
		}

	}
}
?>