<?php
define( '_VALID_SSTARS_', 1 );

require_once "../../config.php";
//session_register('sid');
//session_register('user_id');
require_once $dr."include/functions/login/verify_user.php";
require_once $dr."include/functions/db/get_col_value.php";

$username=DataEscape($_POST['username']);
$password=DataEscape($_POST['password']);

if (VerifyUser($username,$password) == True) {
	$user_id=GetColumnValue("user_id","user_master","username",$username);
	$_SESSION['sid']=md5($user_id.microtime());
	$_SESSION['user_id']=$user_id;
	$sql="UPDATE ".$GLOBALS['mysql_db']."user_master
				SET session_id = '".$_SESSION['sid']."',
				date_last_login = sysdate(),
				count_login = count_login +1
				WHERE username = '".$username."'";
	//echo $sql;
	$db->query($sql);
	$msg_id=1;
}
else {
	$msg_id=2;	
}
//echo $_SESSION['user_id'];
//echo "userid: ".$user_id;
$url="../../index.php?module=wc&task=home&msg=".$msg_id;
Header("Location: $url");
?>