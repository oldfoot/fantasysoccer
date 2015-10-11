<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

function ShowWorkSpaceModules($user_id) {
	$db=$GLOBALS['db'];
	$sql="SELECT mm.module_id, mm.name
				FROM ".$GLOBALS['mysql_db']."workspace_user_modules wum, ".$GLOBALS['mysql_db']."module_master mm
				WHERE wum.user_id = '".$user_id."'
				AND wum.module_id = mm.module_id
				";
	$result = $db->query($sql);
	$s="<table class='plain' bgcolor='#F7F8FB' cellpadding='0' cellspacing='0' align='center' valign='top'>\n";
		$s.="<tr>\n";
			$s.="<td colspan='3' bgcolor='#E4E9F4' class='colhead' align='center'>Your Workspace</td>\n";
		$s.="</tr>\n";
		$s.="<tr>\n";
			$s.="<td><img src='images/curves/teamspace_top_left.gif'></td>\n";
			$s.="<td background='images/curves/teamspace_top.gif'></td>\n";
			$s.="<td><img src='images/curves/teamspace_top_right.gif'></td>\n";
		$s.="</tr>\n";
		$s.="<tr>\n";
			$s.="<td background='images/curves/teamspace_left.gif'></td>\n";
			$s.="<td>\n";
			$s.="<table class='teamspace' cellpadding='0' cellspacing='5'>\n";
				$s.="<tr>\n";
				if ($db->NumRows($result) > 0) {
					$count=0;
					while($row = $db->FetchArray($result)) {

						$desc=STR_REPLACE("_", " ",$row['name']);
						$desc=InitCapAllWords($desc);
						if ($count > 0) {
							$s.="<td width='1' bgcolor='#BEC0CF'><img src='images/spacer.gif' width='1' height='1'></td>\n";
						}
						$s.="<td height='90' width='90' align='center' onMouseOver=\"document.getElementById('teamspace_".$row['module_id']."').className='showBlk'\" onMouseOut=\"document.getElementById('teamspace_".$row['module_id']."').className='hideBlk'\"><a href='index.php?module=".$row['name']."'>".$desc."<br><img src='modules/".$row['name']."/images/home/logo48x48.png' border='0'></a><div height='20' id='teamspace_".$row['module_id']."' class='hideBlk'><img src='images/home/teamspace_arrow_up.gif'></div></td>\n";
						$count++;
					}
					$s.="</tr>\n";
				}
			$s.="</table>\n";
			$s.="</td>\n";
			$s.="<td background='images/curves/teamspace_right.gif'></td>\n";
		$s.="</tr>\n";
		$s.="<tr>\n";
			$s.="<td><img src='images/curves/teamspace_bottom_left.gif'></td>\n";
			$s.="<td background='images/curves/teamspace_bottom.gif'></td>\n";
			$s.="<td><img src='images/curves/teamspace_bottom_right.gif'></td>\n";
		$s.="</tr>\n";
	$s.="</table>\n";
	return $s;
}

function InitCapAllWords($v) {
	$first_split=explode(" ",$v);
	for($i=0;$i<count($first_split);$i++) {
		$c.=" ".STRTOUPPER(SUBSTR($first_split[$i], 0, 1)).SUBSTR($first_split[$i], 1);
	}
	return $c;
}
?>