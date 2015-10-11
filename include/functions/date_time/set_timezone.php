<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

function SetTimezone($t) {
	$db=$GLOBALS['db'];
	$sql="SET timezone = '".$t."'";
	$result = $db->Query($sql);
}

?>