<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/user_settings.php";
require_once $GLOBALS['dr']."modules/wc/functions/forms/user_settings.php";

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
			$result=$fti->Reset($_POST['fixture_id']);
			if (!$result) {	echo $fti->ShowErrors();	} else { echo "Success"; }
		}
	}

	$c.=MySettings();

	return $c;
}
?>