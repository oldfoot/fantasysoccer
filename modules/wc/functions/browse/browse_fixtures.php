<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function BrowseFixtures() {

	$sr=new ShowResults;
	$sr->SetParameters(True);
	$sr->DrawFriendlyColHead(array("","Date","Team A","Team B","Stage","Results","Reset Results","Edit","Delete")); /* COLS */
	$sr->Columns(array("fixture_id","date_fixture","team_name_1","team_name_2","type_name","results","reset_results","edit","del"));
	$sr->Query("SELECT fm.fixture_id,fm.date_fixture,
							tm1.team_name as team_name_1,tm2.team_name as team_name_2,
							ftm.type_name,
							'results' as results, 'reset_results' as reset_results, 'edit' AS edit,'delete' AS del
							FROM ".$GLOBALS['mysql_db']."fixture_master fm, ".$GLOBALS['mysql_db']."team_master tm1,
							".$GLOBALS['mysql_db']."team_master tm2, ".$GLOBALS['mysql_db']."fixture_type_master ftm
							WHERE fm.team_id_1 = tm1.team_id
							AND fm.team_id_2 = tm2.team_id
							AND fm.fixture_type_id = ftm.fixture_type_id
							ORDER BY ftm.ordering
							");

	for ($i=0;$i<$sr->CountRows();$i++) {
		$fixture_id=$sr->GetRowVal($i,0); /* FASTER THAN CALLING EACH TIME IN THE NEXT 2 LINES */
		$sr->ModifyData($i,5,"<a href='index.php?module=wc&task=results&fixture_id=".$fixture_id."' title='Results'>Results</a>");
		$sr->ModifyData($i,6,"<a href='index.php?module=wc&task=fixtures&subtask=reset&fixture_id=".$fixture_id."' title='Reset Results'>Reset Results</a>");
		$sr->ModifyData($i,7,"<a href='index.php?module=wc&task=fixtures&subtask=edit&fixture_id=".$fixture_id."' title='Edit'>Edit</a>");
		$sr->ModifyData($i,8,"<a href='index.php?module=wc&task=fixtures&subtask=delete&fixture_id=".$fixture_id."' title='Delete'>Delete</a>");
	}
	$sr->RemoveColumn(0);
	//$sr->ColDefault(4	,"yesnoimage"); /* SET POPUP TO YES/NO */

	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/kuser.png","Browsing Fixtures");
	return $sr->Draw(null,0);

}

?>