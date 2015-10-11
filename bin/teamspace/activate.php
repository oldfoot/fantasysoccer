<?php
header("Pragma: no-cache");

define( '_VALID_SSTARS_', 1 );

require_once "../../config.php";
require_once $dr."include/functions/db/row_exists.php";
$teamspace_id=DataEscape($_GET['teamspace_id']);
$workspace_id=$ui->WorkspaceID();
/*
	VALID TEAMSPACE
*/
if (RowExists($mysql_table_prefix."teamspace_master","teamspace_id",$teamspace_id,"AND workspace_id = '".$workspace_id."'")) {
	/*
		VALID USER IN THE TEAMSPACE
	*/
	if (RowExists($mysql_table_prefix."teamspace_users","user_id",$user_id,"AND teamspace_id = '".$teamspace_id."'")) {
		$sql="UPDATE ".$mysql_table_prefix."user_master
					SET teamspace_id = '".$teamspace_id."'
					WHERE user_id = '".$user_id."'
					";
		$db->query($sql);
		if ($db->affected_rows() == 0) {
			$msg_id=3;
		}
		else {
			$msg_id=4;
		}
	}
	else {
		$msg_id=5;
	}
}
else {
	$msg_id=6;
}

$url="../../index.php?msg=".$msg_id;
Header("Location: $url");
?>