<?php
header("Pragma: no-cache");

define( '_VALID_SSTARS_', 1 );

require_once "../../config.php";
$sql="UPDATE ".$mysql_table_prefix."user_master
			SET teamspace_id = '0'
			WHERE user_id = '".$user_id."'
			";
$db->query($sql);
if ($db->affected_rows() == 0) {
	$msg_id=8;
}
else {
	$msg_id=7;
}

$url="../../index.php?msg=".$msg_id;
Header("Location: $url");
?>