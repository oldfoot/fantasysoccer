<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

//require_once $GLOBALS['dr']."classes/form/form_validate.php";
require_once $GLOBALS['dr']."classes/form/create_form.php";

function SignupForm() {
	$db=$GLOBALS['db'];
	//$mysql_db=$GLOBALS['mysql_db'];
	$wb=$GLOBALS['wb'];
	$c="";

	/*
	$fv=new FieldValidation;
	$fv->OpenTag();
	$fv->ValidateFields("first_name,surname,login,password,password_repeat,timezone_id,workspace_name");
	$fv->CloseTag();
	*/

	/* CHECK IF THE FORM HAS BEEN SUBMITTED */
	if (ISSET($_POST['submit'])) {
	}

	$form=new CreateForm;
	$form->SetCredentials("index.php?module=signup","post","wc_signup");
	$form->Header("nuvola/32x32/actions/pencil.png","Signup");

	$form->Input("Full Name","full_name","","","",@$full_name);
	$form->Input("Username","username","","","",@$username);
	$form->Password("Password","password","","","",@$password);
	$form->Input("Identity Number","identity_number","","","",@$identity_number);
	$form->Input("Mobile Number","tel_cellular","","","",@$tel_cellular);
	$form->Textarea("Address","address",5,30,@$address);
	$form->Input("Email","email_address",5,30,@$email_address);
	$form->DescriptionCell("<a href='index.php'>Return to the Home Page</a>","");
	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();

}
?>