<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function BrowsePositions() {

	$sr=new ShowResults;
	$sr->SetParameters(True);
	$sr->DrawFriendlyColHead(array("","Position Name","Edit","Delete")); /* COLS */
	$sr->Columns(array("position_id","position_name","edit","del"));
	$sr->Query("SELECT position_id, position_name,'edit' AS edit,'delete' AS del
							FROM ".$GLOBALS['database_ref']."position_master
							ORDER BY position_name");

	for ($i=0;$i<$sr->CountRows();$i++) {
		$position_id=$sr->GetRowVal($i,0); /* FASTER THAN CALLING EACH TIME IN THE NEXT 2 LINES */
		$sr->ModifyData($i,2,"<a href='index.php?module=wc&task=positions&subtask=edit&position_id=".$position_id."' title='Edit'>Edit</a>");
		$sr->ModifyData($i,3,"<a href='index.php?module=wc&task=positions&subtask=delete&position_id=".$position_id."' title='Delete'>Delete</a>");
	}
	$sr->RemoveColumn(0);
	//$sr->ColDefault(5	,"yesnoimage"); /* SET POPUP TO YES/NO */

	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/kuser.png","Browsing positions");
	return $sr->Draw();

}

?>