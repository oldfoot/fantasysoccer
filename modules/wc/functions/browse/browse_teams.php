<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function BrowseTeams() {

	$sr=new ShowResults;
	$sr->SetParameters(True);
	$sr->DrawFriendlyColHead(array("","Team Name","Edit","Delete")); /* COLS */
	$sr->Columns(array("team_id","team_name","edit","del"));
	$sr->Query("SELECT team_id, team_name,'edit' AS edit,'delete' AS del
							FROM ".$GLOBALS['mysql_db']."team_master
							ORDER BY team_name");

	for ($i=0;$i<$sr->CountRows();$i++) {
		$team_id=$sr->GetRowVal($i,0); /* FASTER THAN CALLING EACH TIME IN THE NEXT 2 LINES */
		$sr->ModifyData($i,2,"<a href='index.php?module=wc&task=teams&subtask=edit&team_id=".$team_id."' title='Edit'>Edit</a>");
		$sr->ModifyData($i,3,"<a href='index.php?module=wc&task=teams&subtask=delete&team_id=".$team_id."' title='Delete'>Delete</a>");
	}
	$sr->RemoveColumn(0);
	//$sr->ColDefault(5	,"yesnoimage"); /* SET POPUP TO YES/NO */

	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/kuser.png","Browsing teams");
	return $sr->Draw();

}

?>