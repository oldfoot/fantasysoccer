<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/prediction_result_id.php";

function LoadTask() {

	$c="";

	if (ISSET($_GET['subtask'])) {
		$pri=new PredictionResultID;
		if ($_GET['subtask']=="add") {
			$pri->SetVariable("fixture_type_id",$_POST['fixture_type_id']);
			$pri->SetVariable("team_id",$_POST['team_id']);
			$result=$pri->Add();
			if (!$result) {	echo $pri->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="edit" && ISSET($_POST['prediction_result_id'])) {
			$pri->SetParameters($_POST['prediction_result_id']);
			$pri->SetVariable("player_name",$_POST['player_name']);
			$pri->SetVariable("team_id",$_POST['team_id']);
			$pri->SetVariable("position_id",$_POST['position_id']);
			$result=$pri->Edit();
			if (!$result) {	echo $pri->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="delete") {
			$pri->SetParameters($_GET['prediction_result_id']);
			$result=$pri->Delete();
			if (!$result) {	echo $pri->ShowErrors();	} else { echo "Success"; }
		}
	}

	require_once $GLOBALS['dr']."classes/design/tab_boxes.php";

	$tab_array=array("browse","add","prediction_result_history");
	$tb=new TabBoxes;
	$c.=$tb->DrawBoxes($tab_array,$GLOBALS['dr']."modules/wc/modules/prediction_results/");

	if (ISSET($_GET['subtask']) && $_GET['subtask'] == "edit" && ISSET($_GET['prediction_result_id'])) {
		$c.=$tb->BlockShow("add");
		$c.="<script language=Javascript>document.getElementById('tabbox_add').firstChild.data=\"Edit\";</script>\n";
	}

	return $c;
}
?>