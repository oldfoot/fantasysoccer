<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."classes/form/create_form.php";

require_once $GLOBALS['dr']."modules/wc/classes/user_predictions.php";

function LoadTask() {

	$c="";
	
	/* GET ALL THE STAGES AND LOOP THEM */
	$db=$GLOBALS['db'];
	$sql="SELECT fixture_type_id, type_name, prediction_total
				FROM ".$GLOBALS['mysql_db']."fixture_type_master
				WHERE prediction_allow = 'y'
				ORDER BY ordering
				";
	$result = $db->Query($sql);
	if ($db->NumRows($result) > 0) {
		$type_name="whatever";
		$up=new UserPredictions;
		while($row = $db->FetchArray($result)) {
			/* CREATE A FORM FOR EACH */
			$form=new CreateForm;
			$form->SetCredentials("index.php?module=wc&task=my_predictions&subtask=save","post","add_my_prediction_".$row['fixture_type_id']);
			$v_extra_cell="Your selection:<br>";
			$v_extra_cell.=$up->GetTeamPredictions($row['fixture_type_id']);
			$form->DescriptionCell("Your predictions",$v_extra_cell);
			//$form->Hidden("fixture_type_id",$row['fixture_type_id']);
			$form->CloseForm();
			$c.=$form->DrawForm();

			if ($type_name != $row['type_name']) {
				$c.="<hr>";
			}
			$type_name=$row['type_name'];
		}
	}

	return $c;
}
?>