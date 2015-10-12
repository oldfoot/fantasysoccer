<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/user_settings.php";

function LoadTask() {

	$c="";

	if (ISSET($_GET['subtask'])) {
		$fti=new UserSettings;
		if ($_GET['subtask']=="modify") {
			$fti->SetVariable("team_name",$_POST['team_name']);
			$fti->SetVariable("email_address",$_POST['email_address']);
			$fti->SetVariable("identity_number",$_POST['identity_number']);
			$fti->SetVariable("tel_cellular",$_POST['tel_cellular']);
			$fti->SetVariable("full_name",$_POST['full_name']);
			$result=$fti->Modify();
			if (!$result) {	echo $fti->ShowErrors();	} else { echo "Success"; }
		}		
	}

	require_once $GLOBALS['dr']."classes/design/tab_boxes.php";

	$tab_array=array("modify","my_settings_history");
	$tb=new TabBoxes;
	$c.=$tb->DrawBoxes($tab_array,$GLOBALS['dr']."modules/wc/modules/my_settings/");

	return $c;
}
?>