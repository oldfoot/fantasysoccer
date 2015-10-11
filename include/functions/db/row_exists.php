<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

function RowExists($tb, $rw, $fld, $extra="") {
	$db=$GLOBALS['db'];
	$sql="SELECT 'x'
				FROM ".$GLOBALS['mysql_db']."$tb
				WHERE $rw = '$fld'
				$extra";
	//echo $sql;
	$result = $db->query($sql);
	if ($db->NumRows($result) > 0) {
		return True;
	}
	else {
		return False;
	}
}
?>