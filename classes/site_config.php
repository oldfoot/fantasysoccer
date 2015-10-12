<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

if ($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "192.168.2.4") {
	
	ini_set("include_path", "c:/xampp/htdocs/quiz/pear/");
	/*Website URL*/
	$wb="http://".$_SERVER['SERVER_NAME']."/quiz/";
	/*Website Directory*/
	$GLOBALS['dr']="c:/xampp/htdocs/quiz/";

	/*Database Type*/
	$database_type="mysql";
	/*Authentication Type*/
	$authentication_type="mysql";
	/*Database Server*/
	$database_hostname="localhost";
	/*Database Port*/
	$database_port="3306";
	/*Database User*/
	$database_user="bonzerzprdquiz";
	/*Database Password*/
	$database_password="bonzerzprdquiz";
	/*Database Name*/
	$database_name="bonzerzprdquiz";
	/*Database Prefix*/
	$database_prefix="bonzerzprdquiz.";
	
	$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	$paypal_notify_url = "http://www.runningsheet.com/paypal/ipn";
	$paypal_business = "terenc_1350559434_per@yahoo.com";
	$environment = "dev";	
	
	/*Mail Type either PHP's mail function or SMTP*/
	$mail_type="smtp";
	/*SMTP Server*/
	$smtp_server="smtp.gmail.com";
	$smtp_port=465;
	$smtp_require_auth=true;
	$smtp_user="terence.legrange@gmail.com";
	$smtp_password="";
}
elseif (preg_match("/terencelegrange.com/",$_SERVER['SERVER_NAME'] == "localhost")) {
	ini_set("include_path", "/var/chroot/home/content/28/10991028/html/pear");
	/*Website URL*/
	$wb="http://terencelegrange.com/trivia";
	/*Website Directory*/
	$GLOBALS['dr']="/var/chroot/home/content/28/10991028/html/terencelegrange/trivia/";

	/*Database Type*/
	$database_type="mysql";
	/*Authentication Type*/
	$authentication_type="mysql";
	/*Database Server*/
	$database_hostname="bonzerzprdquiz.db.10991028.hostedresource.com";
	/*Database Port*/
	$database_port="3306";
	/*Database User*/
	$database_user="bonzerzprdquiz";
	/*Database Password*/
	$database_password="a8VXVoEdd9XO!";
	/*Database Name*/
	$database_name="bonzerzprdquiz";
	/*Database Prefix*/
	$database_prefix="bonzerzprdquiz.";
	
	$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
	$paypal_notify_url = "http://www.betterlotterynumbers.com/paypal/ipn";
	$paypal_business = " terence_legrange@yahoo.com";
	
	$environment = "production";
	
	/*Mail Type either PHP's mail function or SMTP*/
	$mail_type="smtp";
	/*SMTP Server*/
	$smtp_server="smtp.gmail.com";
	$smtp_port=25;
	$smtp_require_auth=false;
	$smtp_user="terence.legrange@gmail.com";
	$smtp_password="";
}
else {
	
	ini_set("include_path", "/var/chroot/home/content/28/10991028/html/pear");
	/*Website URL*/
	$wb="http://bonzerz.com/quiz";
	/*Website Directory*/
	$GLOBALS['dr']="/var/chroot/home/content/28/10991028/html/bonzerz/quiz/";

	/*Database Type*/
	$database_type="mysql";
	/*Authentication Type*/
	$authentication_type="mysql";
	/*Database Server*/
	$database_hostname="bonzerzprdquiz.db.10991028.hostedresource.com";
	/*Database Port*/
	$database_port="3306";
	/*Database User*/
	$database_user="bonzerzprdquiz";
	/*Database Password*/
	$database_password="a8VXVoEdd9XO!";
	/*Database Name*/
	$database_name="bonzerzprdquiz";
	/*Database Prefix*/
	$database_prefix="bonzerzprdquiz.";
	
	$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
	$paypal_notify_url = "http://www.betterlotterynumbers.com/paypal/ipn";
	$paypal_business = " terence_legrange@yahoo.com";
	
	$environment = "production";
	
	/*Mail Type either PHP's mail function or SMTP*/
	$mail_type="smtp";
	/*SMTP Server*/
	$smtp_server="smtp.gmail.com";
	$smtp_port=25;
	$smtp_require_auth=false;
	$smtp_user="terence.legrange@gmail.com";
	$smtp_password="";
}
/*Who should emails be sent from?*/
$email_recover_password_from="general@BetterLotteryNumbers.com";

/*Register email from*/
$register_email_from="general@BetterLotteryNumbers.com";

/* OTHER CONFIG */
$register_email_subject = "[BetterLotteryNumbers] Registration";
$register_email_body    = "Welcome %username%,
You have been registered for BetterLotteryNumbers.com, so please activate your account by clicking here:
".$wb."activate.php?content=login&code=%code% 
%extra%
If you did not register, please ignore this email.

Regards, 
BetterLotteryNumbers.com";
							
$forgot_email_subject = "[BetterLotteryNumbers] Password Recovery";
$forgot_email_body    = "Hi,

Someone, perhaps you, requested your password to be recovered.
Click on this link ".$wb."index.php?content=reset&code=%code%

If you did not request this, please ignore this email. 

Regards,
BetterLotteryNumbers.com";	

$invite_email_subject = "[BetterLotteryNumbers] Invitation ";
$invite_email_body    = "Hi,

%friendname%, someone you may know, suggested you join BetterLotteryNumbers.com where you can check how good your lottery numbers are.
Click on this link ".$wb."index.php to register and start choosing better numbers

If you do not know this person, please ignore this email.

Regards,
BetterLotteryNumbers.com";	
?>
