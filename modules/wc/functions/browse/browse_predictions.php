<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function BrowsePredictions() {

	$sr=new ShowResults;
	$sr->SetParameters(True);
	$sr->DrawFriendlyColHead(array("","Team","Stage","Edit","Delete")); /* COLS */
	$sr->Columns(array("prediction_result_id","team_name","type_name","edit","del"));
	$sr->Query("SELECT pr.prediction_result_id, tm.team_name, ftm.type_name, 'edit' AS edit,'delete' AS del
							FROM ".$GLOBALS['mysql_db']."prediction_results pr, ".$GLOBALS['mysql_db']."team_master tm,
							".$GLOBALS['mysql_db']."fixture_type_master ftm
							WHERE pr.team_id = tm.team_id
							AND pr.fixture_type_id = ftm.fixture_type_id
							AND ftm.prediction_allow = 'y'
							ORDER BY ftm.type_name");

	for ($i=0;$i<$sr->CountRows();$i++) {
		$prediction_result_id=$sr->GetRowVal($i,0); /* FASTER THAN CALLING EACH TIME IN THE NEXT 2 LINES */
		$sr->ModifyData($i,3,"<a href='index.php?module=wc&task=prediction_results&subtask=edit&prediction_result_id=".$prediction_result_id."' title='Edit'>Edit</a>");
		$sr->ModifyData($i,4,"<a href='index.php?module=wc&task=prediction_results&subtask=delete&prediction_result_id=".$prediction_result_id."' title='Delete'>Delete</a>");
	}
	$sr->RemoveColumn(0);
	//$sr->ColDefault(5	,"yesnoimage"); /* SET POPUP TO YES/NO */

	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/kuser.png","Prediction Results Entered");
	return $sr->Draw();

}

?>