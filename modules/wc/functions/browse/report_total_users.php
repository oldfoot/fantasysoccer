<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function ReportTotalUsers() {

	$sr=new ShowResults;
	$sr->SetParameters(True);
	$sr->DrawFriendlyColHead(array("","Fixture Name","Start","End","Allow Prediction","Total Predictions","Edit","Delete")); /* COLS */
	$sr->Columns(array("fixture_type_id","type_name","date_start","date_end","prediction_allow","prediction_total","edit","del"));
	$sr->Query("SELECT fixture_type_id, type_name, date_start, date_end, prediction_allow, prediction_total, 'edit' AS edit,'delete' AS del
							FROM ".$GLOBALS['mysql_db']."fixture_type_master
							ORDER BY ordering");

	for ($i=0;$i<$sr->CountRows();$i++) {
		$fixture_type_id=$sr->GetRowVal($i,0); /* FASTER THAN CALLING EACH TIME IN THE NEXT 2 LINES */
		$sr->ModifyData($i,6,"<a href='index.php?module=wc&task=fixture_type&subtask=edit&fixture_type_id=".$fixture_type_id."' title='Edit'>Edit</a>");
		$sr->ModifyData($i,7,"<a href='index.php?module=wc&task=fixture_type&subtask=delete&fixture_type_id=".$fixture_type_id."' title='Delete'>Delete</a>");
	}
	$sr->RemoveColumn(0);
	$sr->ColDefault(4	,"yesnoimage"); /* SET POPUP TO YES/NO */

	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/kuser.png","Browsing Fixtures");
	return $sr->Draw(null,0);

}

?>