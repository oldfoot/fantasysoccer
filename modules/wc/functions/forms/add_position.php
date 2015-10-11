<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";

function AddPosition($position_id="",$position_name="") {

	/* WE CHANGE THE SUBTASK DEPENDING ON WHETHER WE'RE EDITING OR DELETING */
	if (!EMPTY($position_name)) {
		$v_subtask="edit";
	}
	else {
		$v_subtask="add";
	}

	$form=new CreateForm;
	$form->SetCredentials("index.php?module=wc&task=positions&subtask=".$v_subtask,"post","add_position");
	$form->Header("nuvola/32x32/apps/kcmdf.png","Positions");
	$form->Hidden("position_id",$position_id);

	$form->Input("Position name","position_name","","","",$position_name,"5");

	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();
}

?>