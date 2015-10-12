<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";

function AddTeam($team_id="",$team_name="") {

	/* WE CHANGE THE SUBTASK DEPENDING ON WHETHER WE'RE EDITING OR DELETING */
	if (!EMPTY($team_name)) {
		$v_subtask="edit";
	}
	else {
		$v_subtask="add";
	}

	$form=new CreateForm;
	$form->SetCredentials("index.php?module=wc&task=teams&subtask=".$v_subtask,"post","add_team");
	$form->Header("nuvola/32x32/apps/kcmdf.png","Teams");
	$form->Hidden("team_id",$team_id);

	$form->Input("Team name","team_name","","","",$team_name);

	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();
}

?>