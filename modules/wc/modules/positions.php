<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/position_id.php";

function LoadTask() {

	$c="";

	if (ISSET($_GET['subtask'])) {
		$pi=new PositionID;
		if ($_GET['subtask']=="add") {
			$pi->SetVariable("position_name",$_POST['position_name']);
			$result=$pi->Add();
			if (!$result) {	echo $pi->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="edit" && ISSET($_POST['position_id'])) {
			$pi->SetParameters($_POST['position_id']);
			$pi->SetVariable("position_name",$_POST['position_name']);
			$result=$pi->Edit();
			if (!$result) {	echo $pi->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="delete") {
			$pi->SetParameters($_GET['position_id']);
			$result=$pi->Delete($_POST['position_id']);
			if (!$result) {	echo $pi->ShowErrors();	} else { echo "Success"; }
		}
	}

	require_once $GLOBALS['dr']."classes/design/tab_boxes.php";

	$tab_array=array("browse","add","position_history");
	$tb=new TabBoxes;
	$c.=$tb->DrawBoxes($tab_array,$dr."modules/wc/modules/positions/");

	if (ISSET($_GET['subtask']) && $_GET['subtask'] == "edit" && ISSET($_GET['position_id'])) {
		$c.=$tb->BlockShow("add");
		$c.="<script language=Javascript>document.getElementById('tabbox_add').firstChild.data=\"Edit\";</script>\n";
	}

	return $c;
}
?>