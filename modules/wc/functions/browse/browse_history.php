<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function BrowseHistory($task) {

	$sr=new ShowResults;
	$sr->SetParameters(True);
	$sr->DrawFriendlyColHead(array("Description","User","Date")); /* COLS */
	$sr->Columns(array("description","full_name","date_captured"));
	$sr->Query("SELECT h.description,um.full_name, h.date_captured
							FROM ".$GLOBALS['mysql_db']."history h, ".$GLOBALS['mysql_db']."user_master um
							WHERE h.task = '".$task."'
							AND	h.user_id = um.user_id
							ORDER BY h.date_captured DESC");

	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/khexedit.png","Team History / Log");
	return $sr->Draw();

}

?>