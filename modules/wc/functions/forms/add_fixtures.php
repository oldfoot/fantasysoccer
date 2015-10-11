<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";

function AddFixtures($fixture_id="",$team_id_1="",$team_id_2="",$date_fixture="",$fixture_type_id="") {

	/* WE CHANGE THE SUBTASK DEPENDING ON WHETHER WE'RE EDITING OR DELETING */
	if (!EMPTY($team_id_1)) {
		$v_subtask="edit";
	}
	else {
		$v_subtask="add";
	}

	$form=new CreateForm;
	$form->SetCredentials("index.php?module=wc&task=fixtures&subtask=".$v_subtask,"post","add_fixtures");
	$form->Header("nuvola/32x32/apps/kcmdf.png","Fixtures");
	$form->Hidden("fixture_id",$fixture_id);

	$form->ShowDropDown("Team 1","team_id","team_name","team_master","team_id_1",$team_id_1,"","","");
	$form->ShowDropDown("Team 2","team_id","team_name","team_master","team_id_2",$team_id_2,"","","");
	$form->ShowDropDown("Stage","fixture_type_id","type_name","fixture_type_master","fixture_type_id",$fixture_type_id,"","","");
	$form->Date("Start Date","date_fixture",$date_fixture);


	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();
}

?>