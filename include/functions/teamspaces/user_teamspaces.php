<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function UserTeamSpaces($workspace_id,$uid,$pos="horizontal") {
	$db=$GLOBALS['db'];
	$sql="SELECT tm.teamspace_id, tm.name, tm.icon
				FROM ".$GLOBALS['database_ref']."teamspace_master tm, ".$GLOBALS['database_ref']."teamspace_users tu
				WHERE tm.workspace_id = '".$workspace_id."'
				AND tm.teamspace_id = tu.teamspace_id
				AND tu.user_id = '".$uid."'
				ORDER BY tm.name
				";
	//echo $sql."<br>";
	$result = $db->query($sql);
	$s="<table class='plain' width='150'>\n";
		$s.="<tr>\n";
			$s.="<td class='bold' colspan='10'>My Teamspaces</td>\n";
		$s.="</tr>\n";
			if ($db->NumRows($result) > 0) {
				while($row = $db->FetchArray($result)) {
					$s.="<tr>\n";
						$s.="<td align='center'><img src='images/".$row['icon']."' border='0'></td>\n";
						$s.="<td><a href='bin/teamspace/activate.php?teamspace_id=".$row['teamspace_id']."'>".STR_REPLACE("_", " ",$row['name'])."</a></td>\n";
					$s.="</tr>\n";
				}
			}
	$s.="</table>\n";
	return $s;
}
?>