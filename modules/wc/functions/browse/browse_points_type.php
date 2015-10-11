<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function BrowsePointsType() {

	$sr=new ShowResults;
	$sr->SetParameters(True);
	$sr->DrawFriendlyColHead(array("","Points Type","Edit","Delete")); /* COLS */
	$sr->Columns(array("points_type_id","description","edit","del"));
	$sr->Query("SELECT points_type_id, description,'edit' AS edit,'delete' AS del
							FROM ".$GLOBALS['mysql_db']."points_type_master
							ORDER BY description");

	for ($i=0;$i<$sr->CountRows();$i++) {
		$points_type_id=$sr->GetRowVal($i,0); /* FASTER THAN CALLING EACH TIME IN THE NEXT 2 LINES */
		$sr->ModifyData($i,2,"<a href='index.php?module=wc&task=points_type&subtask=edit&points_type_id=".$points_type_id."' title='Edit'>Edit</a>");
		$sr->ModifyData($i,3,"<a href='index.php?module=wc&task=points_type&subtask=delete&points_type_id=".$points_type_id."' title='Delete'>Delete</a>");
	}
	$sr->RemoveColumn(0);
	//$sr->ColDefault(5	,"yesnoimage"); /* SET POPUP TO YES/NO */

	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/kuser.png","Browsing point types");
	return $sr->Draw();

}

?>