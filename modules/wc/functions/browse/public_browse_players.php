<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function PublicBrowsePlayers() {

	$sr=new ShowResults;
	$sr->SetParameters(True);
	$sr->DrawFriendlyColHead(array("Player Name","Team","Position")); /* COLS */
	$sr->Columns(array("player_name","team_name","position_name"));
	$sr->Query("SELECT pm.player_name, tm.team_name, pom.position_name
							FROM ".$GLOBALS['database_ref']."player_master pm, ".$GLOBALS['database_ref']."team_master tm,
							".$GLOBALS['database_ref']."position_master pom
							WHERE pm.team_id = tm.team_id
							AND pm.position_id = pom.position_id
							ORDER BY tm.team_name,pom.position_name,pm.player_name");

	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/kuser.png","Browsing players");
	return $sr->Draw();

}

?>