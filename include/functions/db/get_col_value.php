<?php
/* ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

function GetColumnValue($col,$tb,$whr,$val,$extra="") {

	$db=$GLOBALS['db'];
	$app_db=$GLOBALS['app_db'];

	$sql="SELECT $col
				FROM ".$GLOBALS['mysql_db']."$tb
				WHERE $whr = '".$val."'
				$extra
				";
	//echo $sql;
	$result = $db->query($sql);
	if ($db->NumRows($result) > 0) {
		while($row = $db->FetchArray($result)) {
			return $row[$col];
		}
	}
}
?>