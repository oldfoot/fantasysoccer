<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/player_id.php";

function LoadTask() {

	$c="";

	if (ISSET($_GET['subtask'])) {
		$ti=new PlayerID;
		if ($_GET['subtask']=="add") {
			$ti->SetVariable("player_name",$_POST['player_name']);
			$ti->SetVariable("team_id",$_POST['team_id']);
			$ti->SetVariable("position_id",$_POST['position_id']);
			$result=$ti->Add();
			if (!$result) {	echo $ti->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="edit" && ISSET($_POST['player_id'])) {
			$ti->SetParameters($_POST['player_id']);
			$ti->SetVariable("player_name",$_POST['player_name']);
			$ti->SetVariable("team_id",$_POST['team_id']);
			$ti->SetVariable("position_id",$_POST['position_id']);
			$result=$ti->Edit();
			if (!$result) {	echo $ti->ShowErrors();	} else { echo "Success"; }
		}
		elseif ($_GET['subtask']=="delete") {
			$ti->SetParameters($_GET['player_id']);
			$result=$ti->Delete($_POST['player_id']);
			if (!$result) {	echo $ti->ShowErrors();	} else { echo "Success"; }
		}
	}

	require_once $GLOBALS['dr']."classes/design/tab_boxes.php";

	$tab_array=array("browse","add","player_history");
	$tb=new TabBoxes;
	$c.=$tb->DrawBoxes($tab_array,$dr."modules/wc/modules/players/");

	if (ISSET($_GET['subtask']) && $_GET['subtask'] == "edit" && ISSET($_GET['player_id'])) {
		$c.=$tb->BlockShow("add");
		$c.="<script language=Javascript>document.getElementById('tabbox_add').firstChild.data=\"Edit\";</script>\n";
	}

	return $c;
}
?>