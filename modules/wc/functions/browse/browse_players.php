<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function BrowsePlayers() {

	$sr=new ShowResults;
	$sr->SetParameters(True);
	$sr->DrawFriendlyColHead(array("","Player Name","Team","Position","Edit","Delete")); /* COLS */
	$sr->Columns(array("player_id","player_name","team_name","position_name","edit","del"));
	$sr->Query("SELECT pm.player_id, pm.player_name, tm.team_name, pom.position_name, 'edit' AS edit,'delete' AS del
							FROM ".$GLOBALS['mysql_db']."player_master pm, ".$GLOBALS['mysql_db']."team_master tm,
							".$GLOBALS['mysql_db']."position_master pom
							WHERE pm.team_id = tm.team_id
							AND pm.position_id = pom.position_id
							ORDER BY tm.team_name,pom.position_name,pm.player_name");

	for ($i=0;$i<$sr->CountRows();$i++) {
		$player_id=$sr->GetRowVal($i,0); /* FASTER THAN CALLING EACH TIME IN THE NEXT 2 LINES */
		$sr->ModifyData($i,4,"<a href='index.php?module=wc&task=players&subtask=edit&player_id=".$player_id."' title='Edit'>Edit</a>");
		$sr->ModifyData($i,5,"<a href='index.php?module=wc&task=players&subtask=delete&player_id=".$player_id."' title='Delete'>Delete</a>");
	}
	$sr->RemoveColumn(0);
	//$sr->ColDefault(5	,"yesnoimage"); /* SET POPUP TO YES/NO */

	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/kuser.png","Browsing players");
	return $sr->Draw();

}

?>