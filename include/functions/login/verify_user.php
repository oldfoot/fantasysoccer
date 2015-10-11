<?php
/* ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

function VerifyUser($username, $password) {

	$db=$GLOBALS['db'];
	$mysql_database=$GLOBALS['mysql_database'];

	$sql="SELECT 'x'
      FROM ".$GLOBALS['mysql_db']."user_master
      WHERE username = '".$username."'
      AND password = MD5('".$password."')";
	echo $sql;
	$result = $db->query($sql);
	
	if ($db->NumRows($result) > 0) {
		return True;
	}
	else {
		return False;
	}
}
?>