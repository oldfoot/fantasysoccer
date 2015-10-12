<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";

function AddPredictionResults($prediction_result_id="",$fixture_type_id="",$team_id="") {

	/* WE CHANGE THE SUBTASK DEPENDING ON WHETHER WE'RE EDITING OR DELETING */
	if (!EMPTY($fixture_type_id)) {
		$v_subtask="edit";
	}
	else {
		$v_subtask="add";
	}

	$form=new CreateForm;
	$form->SetCredentials("index.php?module=wc&task=prediction_results&subtask=".$v_subtask,"post","add_prediction_results");
	$form->Header("nuvola/32x32/apps/kcmdf.png","Prediction Results");
	$form->Hidden("prediction_result_id",$prediction_result_id);

	$form->ShowDropDown("Team","team_id","team_name","team_master","team_id",$team_id,"","","");
	$form->ShowDropDown("Stage","fixture_type_id","type_name","fixture_type_master","fixture_type_id",$fixture_type_id,"","","");

	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();
}

?>