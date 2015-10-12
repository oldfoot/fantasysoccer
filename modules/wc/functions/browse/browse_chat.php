<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");
require_once $GLOBALS['dr']."include/functions/date_time/timestamptz_to_friendly.php";

function BrowseChat() {

	$db=$GLOBALS['db'];

	$sql="SELECT c.message, um.team_name, c.date_sent
				FROM ".$GLOBALS['database_ref']."chat c, ".$GLOBALS['database_ref']."user_master um
				WHERE c.user_id = um.user_id
				ORDER BY chat_id DESC LIMIT 20
				";
	//echo $sql."<br>";
	$result = $db->Query($sql);
	$s="<table class='plain' width='120'>\n";
		/*
		$s.="<tr>\n";
			$s.="<td class='bold'>Chat</td>\n";
		$s.="</tr>\n";
		*/

		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				$s.="<tr>\n";
					$s.="<td class='boldwhite'>".$row['message']."</td>\n";
				$s.="</tr>\n";
				$s.="<tr>\n";
					$s.="<td><i><font size=1>".TimestampTZToFriendly($row['date_sent'])." <br>-- ".$row['team_name']."</font></i></td>\n";
				$s.="</tr>\n";
			}
		}
	$s.="</table>\n";

	$s.="<script language=Javascript>\n";
		$s.="document.chat.message.focus();\n";
	$s.="</script>\n";
	return $s;


	$sr=new ShowResults;
	$sr->SetParameters(True);
	//$sr->DrawFriendlyColHead(array("","Fixture Name","Start","End","Allow Prediction","Total Predictions","Edit","Delete")); /* COLS */
	$sr->Columns(array("message","team_name","date_sent"));
	$sr->Query("SELECT c.message, um.team_name, c.date_sent
							FROM ".$GLOBALS['database_ref']."chat c, ".$GLOBALS['database_ref']."user_master um
							WHERE c.user_id = um.user_id
							ORDER BY date_sent DESC LIMIT 20");
	for ($i=0;$i<$sr->CountRows();$i++) {
		$fixture_type_id=$sr->GetRowVal($i,0); /* FASTER THAN CALLING EACH TIME IN THE NEXT 2 LINES */
		$sr->ModifyData($i,6,"<a href='index.php?module=wc&task=fixture_type&subtask=edit&fixture_type_id=".$fixture_type_id."' title='Edit'>Edit</a>");
		$sr->ModifyData($i,7,"<a href='index.php?module=wc&task=fixture_type&subtask=delete&fixture_type_id=".$fixture_type_id."' title='Delete'>Delete</a>");
	}
	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/kuser.png","Chat");
	return $sr->Draw(null,0);

}

?>