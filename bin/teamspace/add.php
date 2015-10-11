<?php
header("Pragma: no-cache");

define( '_VALID_SSTARS_', 1 );

require_once "../../config.php";
require_once $dr."include/functions/db/row_exists.php";
require_once $dr."include/functions/db/get_col_value.php";
$teamspace_id=$ui->TeamspaceID();
$module_id=DataEscape($_GET['module_id']);
$location=DataEscape($_GET['location']);

if ($location == "L" || $location == "C" || $location == "R") {
	/*
		ENSURE THE MODULE ID IS VALID
	*/
	if (RowExists($mysql_table_prefix."teamspace_modules","module_id",$module_id,"AND teamspace_id = '".$teamspace_id."'")) {
		/*
			VALID USER IN THE TEAMSPACE
		*/
		if (RowExists($mysql_table_prefix."teamspace_users","user_id",$user_id,"AND teamspace_id = '".$teamspace_id."'")) {

			/*
				CHECK THAT THE USER DOESNT ALREADY HAVE THE MODULE ID (FOR PAGE REFRESHES)
			*/

			if (!RowExists($mysql_table_prefix."teamspace_user_modules","user_id",$user_id,"AND teamspace_id = '".$teamspace_id."' AND module_id = '".$module_id."'")) {

				$ordering=GetColumnValue("ordering","teamspace_user_modules","user_id",$user_id,"AND teamspace_id = '".$teamspace_id."' AND location = '".$location."' ORDER BY ordering DESC LIMIT 1");

				$sql="INSERT INTO ".$mysql_table_prefix."teamspace_user_modules
							(user_id, teamspace_id, module_id, ordering, location)
							VALUES (
							'".$user_id."',
							'".$teamspace_id."',
							'".$module_id."',
							'".$ordering."',
							'".$location."'
							)";
				$db->query($sql);
				if ($db->affected_rows() == 0) {
					$msg_id=11;
				}
				else {
					$msg_id=12;
				}
			}
			else {
				$msg_id=14;
			}

		}
		else {
			$msg_id=10;
		}
	}
	else {
		$msg_id=9;
	}
}
else {
	$msg_id=13;
}


$url="../../index.php?msg=".$msg_id;
Header("Location: $url");
?>