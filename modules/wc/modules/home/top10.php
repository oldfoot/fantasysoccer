<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function Top10() {

	$c="<table class='plain_border'>\n";
		$c.="<tr class='header'>\n";
			$c.="<td align='center'>Top 10</td>\n";
		$c.="</tr>\n";
		$c.="<tr>\n";
			$c.="<td>";
			
			$sr=new ShowResults;
			$sr->SetParameters(True);
			$sr->DrawFriendlyColHead(array("Points","Team")); /* COLS */
			$sr->Columns(array("max_points","team_name"));
			$sr->Query("SELECT SUM(up.points) as max_points, ut.team_name
									FROM ".$GLOBALS['mysql_db']."user_points up, ".$GLOBALS['mysql_db']."user_master ut									
									WHERE up.user_id = ut.user_id
									AND ut.test_user = 'n'
									GROUP BY up.user_id
									ORDER BY max_points DESC
									LIMIT 10			
									");
			$sr->WrapData();
			//$sr->TableTitle("nuvola/32x32/apps/kuser.png","Latest Fixtures");
			$c.=$sr->Draw("200",0);
			
			$c.="</td\n";
		$c.="</tr>\n";
		
	$c.="</table>\n";

	return $c;
}

?>