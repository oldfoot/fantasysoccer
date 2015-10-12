<?php
require_once "../../config.php";
require_once $GLOBALS['dr']."/include/functions/get_user_id.php";
require_once $GLOBALS['dr']."/include/functions/password/forgot_exists.php";
require_once $GLOBALS['dr']."/include/functions/password/add_forgot.php";

$email_address=DataEscape($_POST['email_address']);
/* WE'VE GOT A VALUE */
if ($email_address) {
	/* CHECK THAT THE EMAIL ADDRESS EXISTS IN THE SYSTEM */
	if (GetUserId($email_address)) {
		/* CHECK IF THE USER HAS REQUESTED THEIR PASSWORD IN THE PAST 24 HOURS */
		if (!ForgotExists($email_address)) {
			$code=md5($email_address.microtime());
			AddForgot($email_address,$code);
			$msg_id=6;
		}
		else {
			$msg_id=5;
		}
	}
	else {
		$msg_id=4;
	}
}
else {
	$msg_id=3;
}

$url="../../index.php?msg=".$msg_id;
Header("Location: $url");
?>
