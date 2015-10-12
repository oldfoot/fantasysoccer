<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function EnterpriseUserTeamspaces($user_id,$workspace_id,$teamspace_id,$pos) {
	$db=$GLOBALS['db'];
	$GLOBALS['dr']=$GLOBALS['dr'];
	$sql="SELECT mm.name, mm.dashboard_filename
				FROM ".$GLOBALS['database_ref']."teamspace_user_modules tum, ".$GLOBALS['database_ref']."module_master mm
				WHERE tum.user_id = '".$user_id."'
				AND tum.workspace_id = '".$workspace_id."'
				AND tum.teamspace_id = '".$teamspace_id."'
				AND tum.location = '".$pos."'
				AND tum.module_id = mm.module_id
				ORDER BY tum.ordering
				";
	//cho $sql."<br>";
	$result = $db->query($sql);
	echo "<table class='plain'>\n";
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				echo "<tr>\n";
				$dashboard_file=$GLOBALS['dr']."modules/".$row['name']."/dashboard/".$row['dashboard_filename'].".php";
				//echo $dashboard_file;
				if (file_exists($dashboard_file)) {
					echo "<td>";
					require_once $dashboard_file;
					echo "</td>";
				}
				else {
					//echo "<td>Dashboard Missing</td>";
				}
				echo "</tr>\n";
				echo "<tr>\n";
					echo "<td bgcolor='#f4f4f4'><br></td>";
				echo "</tr>\n";
			}
		}
	echo "</table>\n";
	return $s;
}
?>