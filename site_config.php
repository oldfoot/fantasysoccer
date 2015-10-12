<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

if ($_SERVER['SERVER_NAME'] == "localhost") {
		
	/*Website URL*/
	$wb="http://".$_SERVER['SERVER_NAME']."/fantasysoccer/";
	/*Website Directory*/
	$dr="c:/xampp/htdocs/fantasysoccer/";

	/*Database Type*/
	$database_type="mysql";
	/*Authentication Type*/
	$authentication_type="mysql";
	/*Database Server*/
	$database_hostname="localhost";
	/*Database Port*/
	$database_port="3306";
	/*Database User*/
	$database_user="root";
	/*Database Password*/
	$database_password="root";
	/*Database Name*/
	$database_name="fantasysoccer";
	/*Database Prefix*/
	$database_prefix="wc_";
	
	$database_ref=$database_name.".".$database_prefix;
	
	$environment = "dev";	
	
	$title = "Fantasy Soccer";
	
	/*Mail Type either PHP's mail function or SMTP*/
	$mail_type="smtp";
	/*SMTP Server*/
	$smtp_server="smtp.gmail.com";
	$smtp_port=465;
	$smtp_require_auth=true;
	$smtp_user="";
	$smtp_password="";
}
else {
	
	/*Website URL*/
	$wb="http://bonzerz.com/fantasysoccer";
	/*Website Directory*/
	$dr="";

	/*Database Type*/
	$database_type="mysql";
	/*Authentication Type*/
	$authentication_type="mysql";
	/*Database Server*/
	$database_hostname="";
	/*Database Port*/
	$database_port="3306";
	/*Database User*/
	$database_user="prod_fantasy_soccer_db_user";
	/*Database Password*/
	$database_password="prod_fantasy_soccer_db_pass";
	/*Database Name*/
	$database_name="prod_fantasy_soccer_db";
	/*Database Prefix*/
	$database_prefix="wc_";
		
	$environment = "production";
	
	$title = "Fantasy Soccer";
	
	/*Mail Type either PHP's mail function or SMTP*/
	$mail_type="smtp";
	/*SMTP Server*/
	$smtp_server="smtp.gmail.com";
	$smtp_port=25;
	$smtp_require_auth=false;
	$smtp_user="";
	$smtp_password="";
}
/*Who should emails be sent from?*/
$email_recover_password_from="noreply@fantasysoccer.com";

/*Register email from*/
$register_email_from="noreply@fantasysoccer.com";

/* OTHER CONFIG */
$register_email_subject = "[FantasySoccer] Registration";
$register_email_body    = "Welcome %username%,
You have been registered for somesite.com, so please activate your account by clicking here:
".$wb."activate.php?content=login&code=%code% 
%extra%
If you did not register, please ignore this email.

Regards, 
somesite.com";
							
$forgot_email_subject = "[FantasySoccer] Password Recovery";
$forgot_email_body    = "Hi,

Someone, perhaps you, requested your password to be recovered.
Click on this link ".$wb."index.php?content=reset&code=%code%

If you did not request this, please ignore this email. 

Regards,
FantasySoccer.com";	

$invite_email_subject = "[FantasySoccer] Invitation ";
$invite_email_body    = "Hi,

%friendname%, someone you may know, suggested you join FantasySoccer.com where you can check how good your lottery numbers are.
Click on this link ".$wb."index.php to register and start choosing better numbers

If you do not know this person, please ignore this email.

Regards,
FantasySoccer.com";	
?>
