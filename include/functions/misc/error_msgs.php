<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function ErrorMessages($id) {
	$db=$GLOBALS['db'];

	$sql="SELECT description, popup
	      FROM ".$GLOBALS['database_prefix']."error_messages
	      WHERE error_id = '$id'";
	//echo $sql;
	$result = $db->query($sql);
	if ($db->NumRows($result) > 0) {
		while ($row = $db->FetchArray($result)){
			$taskbar_msg=$row["description"];
			if ($row["popup"] == "y") {
				echo "<script language='JavaScript'>";
				echo "{";
				echo "alert('".$taskbar_msg."')";
				echo "}";
				echo "</script>";
			}
		}
	}

	echo "<SCRIPT language='JavaScript'><!--\n";
	echo "window.status = '".$taskbar_msg."';\n";
	echo "//--></SCRIPT>\n";
}
?>