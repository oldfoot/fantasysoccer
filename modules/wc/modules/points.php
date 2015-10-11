<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/points.php";

function LoadTask() {

	$c="";

	if (ISSET($_GET['subtask'])) {
		$points=new Points;
		if ($_GET['subtask']=="add") {
			$points->SetVariable("points",$_POST['points']);
			$points->SetVariable("fixture_type_id",$_POST['fixture_type_id']);
			$points->SetVariable("position_id",$_POST['position_id']);
			$points->SetVariable("points_type_id",$_POST['points_type_id']);			
			$result=$points->Add();
			if (!$result) {	echo $points->ShowErrors();	} else { echo "Success"; }
		}
		/*
		elseif ($_GET['subtask']=="edit" && ISSET($_POST['fixture_id'])) {
			$points->SetParameters($_POST['fixture_id']);
			$points->SetVariable("team_id_1",$_POST['team_id_1']);
			$points->SetVariable("team_id_2",$_POST['team_id_2']);
			$points->SetVariable("date_fixture",$_POST['date_fixture']);
			$points->SetVariable("fixture_type_id",$_POST['fixture_type_id']);
			$result=$points->Edit();
			if (!$result) {	echo $points->ShowErrors();	} else { echo "Success"; }		
		}
		*/
		elseif ($_GET['subtask']=="delete") {
			$points->SetParameters($_GET['fixture_type_id'],$_GET['position_id'],$_GET['points_type_id']);
			//$points->SetVariable("fixture_type_id",$_GET['fixture_type_id']);
			//$points->SetVariable("position_id",$_GET['position_id']);
			//$points->SetVariable("points_type_id",$_GET['points_type_id']);						
			$result=$points->Delete();
			if (!$result) {	echo $points->ShowErrors();	} else { echo "Success"; }
		}
	}

	require_once $GLOBALS['dr']."classes/design/tab_boxes.php";

	$tab_array=array("browse","add","points_history");
	$tb=new TabBoxes;
	$c.=$tb->DrawBoxes($tab_array,$dr."modules/wc/modules/points/");

	return $c;
}
?>