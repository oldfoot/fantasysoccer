<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";

function AddPlayer($player_id="",$player_name="",$team_id="",$position_id="") {

	/* WE CHANGE THE SUBTASK DEPENDING ON WHETHER WE'RE EDITING OR DELETING */
	if (!EMPTY($player_name)) {
		$v_subtask="edit";
	}
	else {
		$v_subtask="add";
	}

	$form=new CreateForm;
	$form->SetCredentials("index.php?module=wc&task=players&subtask=".$v_subtask,"post","add_player");
	$form->Header("nuvola/32x32/apps/kcmdf.png","Players");
	$form->Hidden("player_id",$player_id);

	$form->Input("Player name","player_name","","","",$player_name);

	$form->ShowDropDown("Team","team_id","team_name","team_master","team_id",$team_id,"","","");
	$form->ShowDropDown("Position","position_id","position_name","position_master","position_id",$position_id,"","","");

	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();
}

?>