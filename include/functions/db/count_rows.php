<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function CountRows($tb, $rw, $fld, $extra="",$ignore_where=False) {

	$db=$GLOBALS['db'];

	if (!$ignore_where) { $where="WHERE $rw = '$fld'"; }

	$sql="SELECT count($fld) as count
				FROM ".$GLOBALS['database_ref']."$tb
				$extra";

	//echo $sql;
	$result = $db->query($sql);
	if ($db->NumRows($result) > 0) {
		while($row = $db->FetchArray($result)) {
			return $row['count'];
	 	}
	}
	else {
		return 0;
	}
}
?>