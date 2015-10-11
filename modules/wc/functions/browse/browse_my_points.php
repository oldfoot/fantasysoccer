<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");
require_once($GLOBALS['dr']."modules/wc/classes/fixture_id.php");

function BrowseMyPoints() {

	/* DATABASE VARIABLE */
	$db=$GLOBALS['db'];

	$c="<table class='plain_border' border='1' bordercolor='#336699'>\n";
		$c.="<tr class='header'>\n";
			$c.="<td colspan='3'>Your points</td>\n";
		$c.="</tr>\n";
		$sql="SELECT up.points, up.description, up.points_type, up.fixture_id, up.fixture_type_id
					FROM ".$GLOBALS['mysql_db']."user_points up
					WHERE user_id = ".$_SESSION['user_id']."
					ORDER BY up.fixture_id DESC, up.points DESC
					";
		//echo $sql."<br>";
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			$fixture_id=null;
			while($row = $db->FetchArray($result)) {
				if ($v_fixture_id != $row['fixture_id']) {
					$fi=new FixtureID;
					$fi->SetParameters($row['fixture_id']);
					$c.="<tr class='alternateover'>\n";
						$c.="<td colspan='3'>".$fi->GetInfo("team_name1")." vs ".$fi->GetInfo("team_name2")." on ".$fi->GetInfo("date_fixture")."</td>\n";
					$c.="</tr>\n";
				}
				$c.="<tr>\n";
					$c.="<td>".$row['points']."</td>\n";
					$c.="<td>".$row['description']."</td>\n";
					$c.="<td>".$row['points_type']."</td>\n";
				$c.="</tr>\n";

				$v_fixture_id=$row['fixture_id'];
			}
		}
	$c.="</table>\n";

	return $c;

}

?>