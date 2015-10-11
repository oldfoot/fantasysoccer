<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function Announcements() {

	$c="<table class='plain_border'>\n";
		$c.="<tr class='header'>\n";
			$c.="<td align='center'>Announcementss</td>\n";
		$c.="</tr>\n";
		$c.="<tr>\n";
			$c.="<td>";

			$sr=new ShowResults;
			$sr->SetParameters(True);
			$sr->DrawFriendlyColHead(array("Message")); /* COLS */
			$sr->Columns(array("message"));
			$sr->Query("SELECT message
									FROM ".$GLOBALS['mysql_db']."announcements
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