<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";

function ModifyMySettings() {

	$ui=$GLOBALS['ui'];

	$form=new CreateForm;
	$form->SetCredentials("index.php?module=wc&task=my_settings&subtask=modify","post","modify_my_settings");
	$form->Header("nuvola/32x32/apps/kcmdf.png","My Settings");

	$team_name=$ui->GetColVal("team_name");
	if (!EMPTY($team_name)) { $disabled="readonly"; } else { $disabled=""; }						
	$form->Input("Team name","team_name","","","",$ui->GetColVal("team_name"),"","",$disabled);
	$form->Input("Email","email_address","","","",$ui->GetColVal("email_address"));
	$form->Input("Identity Number","identity_number","","","",$ui->GetColVal("identity_number"),"","","Disabled");
	$form->Input("Tel Cellular","tel_cellular","","","",$ui->GetColVal("tel_cellular"));
	$form->Input("Full Name","full_name","","","",$ui->GetColVal("full_name"));


	$form->DescriptionCell("Signup Date",$ui->GetColVal("date_created"));
	$form->DescriptionCell("Last Login",$ui->GetColVal("date_last_login"));
	$form->DescriptionCell("Total Logins",$ui->GetColVal("count_login"));


	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();
}

?>