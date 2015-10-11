<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/points_type_id.php";

function LoadTask() {

	$c="";

	if (ISSET($_GET['subtask'])) {
		$pti=new PointsTypeID;
		if ($_GET['subtask']=="add") {
			$pti->SetVariable("description",$_POST['description']);
			$result=$pti->Add();
			if (!$result) {	echo $pti->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="edit" && ISSET($_POST['points_type_id'])) {
			$pti->SetParameters($_POST['points_type_id']);
			$pti->SetVariable("description",$_POST['description']);
			$result=$pti->Edit();
			if (!$result) {	echo $pti->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="delete") {
			$pti->SetParameters($_GET['points_type_id']);
			$result=$pti->Delete($_POST['points_type_id']);
			if (!$result) {	echo $pti->ShowErrors();	} else { echo "Success"; }
		}
	}

	require_once $GLOBALS['dr']."classes/design/tab_boxes.php";

	$tab_array=array("browse","add","points_type_history");
	$tb=new TabBoxes;
	$c.=$tb->DrawBoxes($tab_array,$dr."modules/wc/modules/points_type/");

	if (ISSET($_GET['subtask']) && $_GET['subtask'] == "edit" && ISSET($_GET['points_type_id'])) {
		$c.=$tb->BlockShow("add");
		$c.="<script language=Javascript>document.getElementById('tabbox_add').firstChild.data=\"Edit\";</script>\n";
	}

	return $c;
}
?>