<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function ShowLoginForm() {
	$s="<table class='plain_white'>\n";
		$s.="<tr>\n";
			$s.="<td colspan='2' align='center' class='boldwhite'>Please login using your email address and password</td>\n";
		$s.="</tr>\n";
		$s.="<tr>\n";
			$s.="<form method=post name='s_login' action='bin/login/login.php'>\n";
			$s.="<td class='boldwhite'>Login ID:</td>\n";
			$s.="<td><input type='text' name='username' maxlength='50' size='20' tabindex='1' class='input'></td>\n";
		$s.="</tr>\n";
		$s.="<tr>\n";
			$s.="<td class='boldwhite'>Password:</td>\n";
			$s.="<td><input type='password' name='password' maxlength='50' size='20' tabindex='2'></td>\n";
		$s.="</tr>\n";
		$s.="<tr>\n";
			$s.="<td>Remember me:</td>\n";
			$s.="<td><input type='checkbox' name='remember_me' value='yes'></td>\n";
		$s.="</tr>\n";
		$s.="<tr>\n";
			$s.="<td colspan='2' align='center'>\n";
				$s.="<input type='submit' value='Login' tabindex='3'>\n";
				$s.="</td>\n";
				$s.="</form>\n";
		$s.="</tr>\n";
		$s.="<tr>\n";
			$s.="<td>Not a member?</td>\n";
			$s.="<td><a href='index.php?module=signup'>Signup Now</a></td>\n";
		$s.="</tr>\n";
		$s.="<tr>\n";
			$s.="<td>Problems? Suggestions?</td>\n";
			$s.="<td><a href='mailto:terence_legrange@yahoo.com'>Email Us!</a></td>\n";
		$s.="</tr>\n";		
	$s.="</table>\n";
	$s.="<script language='JavaScript'>\n";
	$s.="document.s_login.username.focus();\n";
	$s.="</script>\n";

	return $s;
}
?>