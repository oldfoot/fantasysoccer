<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($dr."include/functions/misc/yes_no_image.php");

function UserList($type,$id="") {
	$db=$GLOBALS['db'];
	if ($type == "teamspace") {
		$tb=$GLOBALS['mysql_db']."teamspace_users u";
		$sq="WHERE u.teamspace_id = '".$id."'";
	}
	else {
		$tb=$GLOBALS['mysql_db']."workspace_users u";
		$sq="WHERE u.workspace_id = '".$id."'";
	}

	$sql="SELECT um.user_id, um.full_name, um.login, um.logged_in
				FROM $tb, ".$GLOBALS['mysql_db']."user_master um
				$sq
				AND u.user_id = um.user_id
				ORDER BY um.full_name
				";
	//echo $sql."<br>";
	$result = $db->query($sql);
	$s="<table class='plain'>\n";
		$s.="<tr>\n";
			$s.="<td class='bold' colspan='10'>User Directory</td>\n";
		$s.="</tr>\n";
		$s.="<tr class='colhead'>\n";
			$s.="<td bgcolor='#ffffff'></td>\n";
			$s.="<td>Full Name</td>\n";
			$s.="<td>Email</td>\n";
			$s.="<td>Logged In</td>\n";
		$s.="</tr>\n";
		if ($db->num_rows($result) > 0) {
			while($row = $db->fetch_array($result)) {
				$s.="<tr>\n";
					$s.="<td><img src='bin/binary/staff_photo.php?user_id=".$row['user_id']."' width='48' height='48'></td>\n";
					$s.="<td>".$row['full_name']."</td>\n";
					$s.="<td>".$row['login']."</td>\n";
					$s.="<td align='center'>".YesNoImage($row['logged_in'])."</td>\n";
				$s.="</tr>\n";
			}
		}
	$s.="</table>\n";
	return $s;
}

?>