<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

function LogHistory($description) {
	$db=$GLOBALS['db'];

	if (EMPTY($description)) { return False; }

	$sql="INSERT INTO ".$GLOBALS['mysql_db']."history (description,user_id,task,date_captured)
				VALUES (
				'".EscapeData($description)."',
				'".$_SESSION['user_id']."',
				'".EscapeData($_GET['task'])."',
				sysdate()
				)";
	$result=$db->Query($sql);
	if ($db->AffectedRows($result) > 0) {
		return True;
	}
	else {
		return False;
	}
}

?>