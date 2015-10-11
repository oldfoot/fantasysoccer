<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";

function AddFixtureType($fixture_type_id="",$type_name="",$date_start="",$date_end="",$prediction_allow="",$prediction_total="") {

	/* WE CHANGE THE SUBTASK DEPENDING ON WHETHER WE'RE EDITING OR DELETING */
	if (!EMPTY($type_name)) {
		$v_subtask="edit";
	}
	else {
		$v_subtask="add";
	}

	$form=new CreateForm;
	$form->SetCredentials("index.php?module=wc&task=fixture_type&subtask=".$v_subtask,"post","add_fixture_type");
	$form->Header("nuvola/32x32/apps/kcmdf.png","Fixtures");
	$form->Hidden("fixture_type_id",$fixture_type_id);

	$form->Input("Fixture name","type_name","","","",$type_name);
	$form->Date("Start Date","date_start",$date_start);
	$form->Date("Start End","date_end",$date_end);

	$form->Checkbox("Allow predictions","prediction_allow",$prediction_allow);
	$form->Input("Number of predictions allowed","prediction_total","","","",$prediction_total,2,2);

	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();
}

?>