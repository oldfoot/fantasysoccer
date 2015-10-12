<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."classes/form/show_results.php");

function GameBrowsePoints() {

	$sr=new ShowResults;
	$sr->SetParameters(True);
	$sr->DrawFriendlyColHead(array("Points","","","","Stage","Position","Desc")); /* COLS */
	$sr->Columns(array("points","fixture_type_id","position_id","points_type_id","type_name","position_name","description"));
	$sr->Query("SELECT pm.points, pm.fixture_type_id, pm.position_id, pm.points_type_id,
							ftm.type_name, pom.position_name, ptm.description, 'edit' as edit, 'del' as del
							FROM ".$GLOBALS['database_ref']."points_master pm, ".$GLOBALS['database_ref']."fixture_type_master ftm,
							".$GLOBALS['database_ref']."position_master pom, ".$GLOBALS['database_ref']."points_type_master ptm
							WHERE pm.fixture_type_id = ftm.fixture_type_id
							AND pm.position_id = pom.position_id
							AND pm.points_type_id = ptm.points_type_id
							ORDER BY ftm.ordering,pom.position_name
							");

	$sr->RemoveColumn(1);
	$sr->RemoveColumn(2);
	$sr->RemoveColumn(3);
	//$sr->ColDefault(4	,"yesnoimage"); /* SET POPUP TO YES/NO */

	$sr->WrapData();
	$sr->TableTitle("nuvola/32x32/apps/kuser.png","Browsing Point Allocation");
	return $sr->Draw(null,0);

}

?>