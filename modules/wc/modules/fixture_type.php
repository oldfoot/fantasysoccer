<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/fixture_type_id.php";

function LoadTask() {

	$c="";

	if (ISSET($_GET['subtask'])) {
		$fti=new FixtureTypeID;
		if ($_GET['subtask']=="add") {
			$fti->SetVariable("type_name",$_POST['type_name']);
			$fti->SetVariable("date_start",$_POST['date_start']);
			$fti->SetVariable("date_end",$_POST['date_end']);
			$fti->SetVariable("prediction_allow",$_POST['prediction_allow']);
			$fti->SetVariable("prediction_total",$_POST['prediction_total']);
			$result=$fti->Add();
			if (!$result) {	echo $fti->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="edit" && ISSET($_POST['fixture_type_id'])) {
			$fti->SetParameters($_POST['fixture_type_id']);
			$fti->SetVariable("type_name",$_POST['type_name']);
			$fti->SetVariable("date_start",$_POST['date_start']);
			$fti->SetVariable("date_end",$_POST['date_end']);
			$fti->SetVariable("prediction_allow",$_POST['prediction_allow']);
			$fti->SetVariable("prediction_total",$_POST['prediction_total']);
			$result=$fti->Edit();
			if (!$result) {	echo $fti->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="delete") {
			$fti->SetParameters($_GET['fixture_type_id']);
			$result=$fti->Delete($_POST['fixture_type_id']);
			if (!$result) {	echo $fti->ShowErrors();	} else { echo "Success"; }
		}
	}

	require_once $GLOBALS['dr']."classes/design/tab_boxes.php";

	$tab_array=array("browse","add","fixture_type_history");
	$tb=new TabBoxes;
	$c.=$tb->DrawBoxes($tab_array,$GLOBALS['dr']."modules/wc/modules/fixture_type/");

	if (ISSET($_GET['subtask']) && $_GET['subtask'] == "edit" && ISSET($_GET['fixture_type_id'])) {
		$c.=$tb->BlockShow("add");
		$c.="<script language=Javascript>document.getElementById('tabbox_add').firstChild.data=\"Edit\";</script>\n";
	}

	return $c;
}
?>