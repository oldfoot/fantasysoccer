<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function PublicBrowseTeams() {

	$sr=new ShowResults;
	$sr->SetParameters(True);
	$sr->DrawFriendlyColHead(array("Team Name")); /* COLS */
	$sr->Columns(array("team_name"));
	$sr->Query("SELECT team_name
							FROM ".$GLOBALS['database_ref']."team_master
							ORDER BY team_name");
	//$sr->RemoveColumn(0);

	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/kuser.png","Browsing teams");
	return $sr->Draw();

}

?>