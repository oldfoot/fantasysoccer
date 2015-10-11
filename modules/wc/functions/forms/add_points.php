<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";

function AddPoints($points="",$fixture_type_id="",$position_id="",$points_type_id="") {

	/* WE CHANGE THE SUBTASK DEPENDING ON WHETHER WE'RE EDITING OR DELETING */
	if (!EMPTY($team_id_1)) {
		$v_subtask="edit";
	}
	else {
		$v_subtask="add";
	}

	$form=new CreateForm;
	$form->SetCredentials("index.php?module=wc&task=points&subtask=".$v_subtask,"post","add_points");
	$form->Header("nuvola/32x32/apps/kcmdf.png","points");	
	
	$form->Input("Points Awarded","points","","","",$points);
	$form->ShowDropDown("Stage","fixture_type_id","type_name","fixture_type_master","fixture_type_id",$fixture_type_id,"","","");
	$form->ShowDropDown("Position","position_id","position_name","position_master","position_id",$position_id,"","","");
	$form->ShowDropDown("Type","points_type_id","description","points_type_master","points_type_id",$points_type_id,"","","");
	
	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();
}

?>