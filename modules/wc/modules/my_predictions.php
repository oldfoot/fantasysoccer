<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."classes/form/create_form.php";

require_once $GLOBALS['dr']."modules/wc/classes/user_predictions.php";

function LoadTask() {

	$c="";

	
	if (ISSET($_GET['subtask'])) {
		
		if ($_GET['subtask']=="save") {
			$db=$GLOBALS['db'];
			$sql="SELECT fixture_type_id, type_name, prediction_total
						FROM ".$GLOBALS['database_ref']."fixture_type_master
						WHERE prediction_allow = 'y'
						ORDER BY ordering
						";
			$result=$db->Query($sql);
			if ($db->NumRows($result) > 0) {
				$type_name="whatever";
				while($row = $db->FetchArray($result)) {
					if (ISSET($_POST["team_id_".$row['fixture_type_id']])) {
						$v_post="team_id_".$row['fixture_type_id'];
						//echo "Team ID for ".$row['type_name']." is: ".$_POST[$v_post]."<br>";
						$up=new UserPredictions;
						$up->SetParameters($_POST[$v_post],$row['fixture_type_id']);
						$result_add=$up->Add();
						if (!$result_add) {
							$c.="Error!";
							$c.=$up->ShowErrors();
						}
					}
				}
			}
		}
		elseif ($_GET['subtask']=="delete") {
			$up=new UserPredictions;
			$up->SetParameters($_GET['team_id'],$_GET['fixture_type_id']);
			$result=$up->Delete();
			if (!$result) {
				$c.="Error!";
				$c.=$up->ShowErrors();
			}
		}
	}
	

	/*
	$c.="<table class='plain' width='100%'>\n";
		$c.="<tr>\n";
			$c.="<td align='right' class='colhead'><input type='button' value='ResetonClic</td>\n";
		$c.="</tr>\n";
	$c.="</table>\n";
	*/

	/* GET ALL THE STAGES AND LOOP THEM */
	$db=$GLOBALS['db'];
	$sql="SELECT fixture_type_id, type_name, prediction_total
				FROM ".$GLOBALS['database_ref']."fixture_type_master
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
			$form->ShowDropDown($row['type_name'],"team_id","team_name","team_master","team_id_".$row['fixture_type_id'],"","
					SELECT tm.team_id, tm.team_name
					FROM ".$GLOBALS['database_ref']."team_master tm
					WHERE tm.team_id NOT IN (
						SELECT team_id
						FROM ".$GLOBALS['database_ref']."user_predictions
						WHERE user_id = ".$_SESSION['user_id']."
						AND fixture_type_id = '".$row['fixture_type_id']."'
					)
					ORDER BY tm.team_name
			","","multiple","onChange=\"document.add_my_prediction_".$row['fixture_type_id'].".submit();\"","","150","250",$v_extra_cell);
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