<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";

function AddRole($role_id="",$role_name="") {

	/* WE CHANGE THE SUBTASK DEPENDING ON WHETHER WE'RE EDITING OR DELETING */
	if (!EMPTY($role_name)) {
		$v_subtask="edit";
	}
	else {
		$v_subtask="add";
	}

	$form=new CreateForm;
	$form->SetCredentials("index.php?module=wc&task=roles&subtask=".$v_subtask,"post","add_role");
	$form->Header("nuvola/32x32/apps/kcmdf.png","Roles");
	$form->Hidden("role_id",$role_id);

	$form->Input("Role name","role_name","","","",$role_name);

	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();
}

?>