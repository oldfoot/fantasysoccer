<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once ($dr."modules/signup/classes/new_user.php");
require_once ($dr."modules/signup/functions/forms/signup_form.php");

function LoadModule() {

	$c="";

	/* PROCESSING */
	if (ISSET($_POST['FormSubmit'])) {
		echo "Saving";
		$nu=new NewUser;
		$result=$nu->SetParameters($_POST['full_name'],$_POST['username'],$_POST['password'],$_POST['identity_number'],
															$_POST['tel_cellular'],$_POST['address'],$_POST['email_address']);
		if (!$result) {
			$c.="Errors<br>";
			$c.=$nu->ShowErrors();
		}
		else {
			$resultsave=$nu->SaveToDb();
			if (!$resultsave) {
				$c.="Signup failed";
			}
			else {
				$c.="Success";
			}
		}
	}

	$c.="<table>\n";
		$c.="<tr>\n";
			$c.="<td>";
			$c.=CurveBox(SignupForm());
			$c.="</td>\n";
		$c.="</tr>\n";
	$c.="</table>\n";

	return $c;
}
?>