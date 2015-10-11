<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/role_id.php";

function LoadTask() {

	$c="";

	if (ISSET($_GET['subtask'])) {
		$ti=new RoleID;
		if ($_GET['subtask']=="add") {
			$ti->SetVariable("role_name",$_POST['role_name']);
			$result=$ti->Add();
			if (!$result) {	echo $ti->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="edit" && ISSET($_POST['role_id'])) {
			$ti->SetParameters($_POST['role_id']);
			$ti->SetVariable("role_name",$_POST['role_name']);
			$result=$ti->Edit();
			if (!$result) {	echo $ti->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="delete") {
			$ti->SetParameters($_GET['role_id']);
			$result=$ti->Delete($_POST['role_id']);
			if (!$result) {	echo $ti->ShowErrors();	} else { echo "Success"; }
		}
	}

	require_once $GLOBALS['dr']."classes/design/tab_boxes.php";

	$tab_array=array("browse","add","role_history");
	$tb=new TabBoxes;
	$c.=$tb->DrawBoxes($tab_array,$dr."modules/wc/modules/roles/");

	if (ISSET($_GET['subtask']) && $_GET['subtask'] == "edit" && ISSET($_GET['role_id'])) {
		$c.=$tb->BlockShow("add");
		$c.="<script language=Javascript>document.getElementById('tabbox_add').firstChild.data=\"Edit\";</script>\n";
	}

	return $c;
}
?>