<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function LatestResults() {

	$c="<table class='plain_border'>\n";
		$c.="<tr class='header'>\n";
			$c.="<td align='center'>Last 10 results</td>\n";
		$c.="</tr>\n";
		$c.="<tr>\n";
			$c.="<td>";
			
			$sr=new ShowResults;
			$sr->SetParameters(True);
			$sr->DrawFriendlyColHead(array("Stage","Team A","","","","Team B")); /* COLS */
			$sr->Columns(array("type_name","team_name_1","goals_team_1","dash","goals_team_2","team_name_2"));
			$sr->Query("SELECT ftm.type_name,
									tm1.team_name as team_name_1,fm.goals_team_1,'-' as dash,fm.goals_team_2,tm2.team_name as team_name_2																		
									FROM ".$GLOBALS['database_ref']."fixture_master fm, ".$GLOBALS['database_ref']."team_master tm1,
									".$GLOBALS['database_ref']."team_master tm2, ".$GLOBALS['database_ref']."fixture_type_master ftm
									WHERE fm.goals_team_1 IS NOT NULL
									AND fm.goals_team_2 IS NOT NULL
									AND fm.team_id_1 = tm1.team_id
									AND fm.team_id_2 = tm2.team_id
									AND fm.fixture_type_id = ftm.fixture_type_id
									ORDER BY fm.date_fixture DESC
									LIMIT 10
									");
			$sr->WrapData();
			//$sr->TableTitle("nuvola/32x32/apps/kuser.png","Latest Fixtures");
			$c.=$sr->Draw("300",0);
			
			$c.="</td\n";
		$c.="</tr>\n";
		
	$c.="</table>\n";

	return $c;
}

?>