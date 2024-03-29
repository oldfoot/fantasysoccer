<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/fixture_id.php";

function LoadTask() {

	$c="";

	if (ISSET($_GET['subtask'])) {
		$fti=new FixtureID;
		if ($_GET['subtask']=="add") {
			$fti->SetVariable("team_id_1",$_POST['team_id_1']);
			$fti->SetVariable("team_id_2",$_POST['team_id_2']);
			$fti->SetVariable("date_fixture",$_POST['date_fixture']);
			$fti->SetVariable("fixture_type_id",$_POST['fixture_type_id']);
			$result=$fti->Add();
			if (!$result) {	echo $fti->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="edit" && ISSET($_POST['fixture_id'])) {
			$fti->SetParameters($_POST['fixture_id']);
			$fti->SetVariable("team_id_1",$_POST['team_id_1']);
			$fti->SetVariable("team_id_2",$_POST['team_id_2']);
			$fti->SetVariable("date_fixture",$_POST['date_fixture']);
			$fti->SetVariable("fixture_type_id",$_POST['fixture_type_id']);
			$result=$fti->Edit();
			if (!$result) {	echo $fti->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="delete") {
			$fti->SetParameters($_GET['fixture_id']);
			$result=$fti->Delete($_POST['fixture_id']);
			if (!$result) {	echo $fti->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="reset") {
			$fti->SetParameters($_GET['fixture_id']);
			$result=$fti->Reset($_GET['fixture_id']);
			if (!$result) {	echo $fti->ShowErrors();	} else { echo "Success"; }
		}
	}

	require_once $GLOBALS['dr']."classes/design/tab_boxes.php";

	$tab_array=array("browse","add","fixture_history");
	$tb=new TabBoxes;
	$c.=$tb->DrawBoxes($tab_array,$GLOBALS['dr']."modules/wc/modules/fixtures/");

	if (ISSET($_GET['subtask']) && $_GET['subtask'] == "edit" && ISSET($_GET['fixture_id'])) {
		$c.=$tb->BlockShow("add");
		$c.="<script language=Javascript>document.getElementById('tabbox_add').firstChild.data=\"Edit\";</script>\n";
	}

	return $c;
}
?>