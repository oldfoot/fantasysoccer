<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";

function AddPointsType($points_type_id="",$description="") {

	/* WE CHANGE THE SUBTASK DEPENDING ON WHETHER WE'RE EDITING OR DELETING */
	if (!EMPTY($description)) {
		$v_subtask="edit";
	}
	else {
		$v_subtask="add";
	}

	$form=new CreateForm;
	$form->SetCredentials("index.php?module=wc&task=points_type&subtask=".$v_subtask,"post","add_points_type");
	$form->Header("nuvola/32x32/apps/kcmdf.png","Type of points");
	$form->Hidden("points_type_id",$points_type_id);

	$form->Input("Description","description","","","",$description);

	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();
}

?>