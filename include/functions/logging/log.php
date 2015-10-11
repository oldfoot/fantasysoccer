<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

function LogSite() {
	/* ADD */
	$db=$GLOBALS['db'];
	$sql="INSERT INTO ".$GLOBALS['mysql_db']."logging
				(url,date_hit,session_id,user_id)
				VALUES (
				'".$_SERVER['QUERY_STRING']."',
				sysdate(),
				'".$_SESSION['sid']."',
				'".$_SESSION['user_id']."'
				)";
	//echo $sql;
	$result=$db->Query($sql);
	if ($db->AffectedRows($result) > 0) {
		return True;
	}
	else {
		return False;
	}
}