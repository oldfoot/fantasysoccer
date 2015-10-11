<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

error_reporting(E_ERROR);

ob_start();
header("Pragma: no-cache");

require_once "site_config.php";

require "classes/session/session.php";	

$session = new session();

session_set_save_handler(array($session,"open"),
                         array($session,"close"),
                         array($session,"read"),
                         array($session,"write"),
                         array($session,"destroy"),
                         array($session,"gc")); 

session_start();

/*
	DATABASE CONNECTION
*/


require_once $dr."classes/db/mysql.php";
$db = new MySQLFunctions;//New object
$db->set_cred($mysql_hostname.":".$mysql_port,$mysql_database,$mysql_user,$mysql_password);//Set credentials ready to connect,
$db->db_connect();//Connect to the database using a non persistant connection

/*
	DATABASE SESSIONS
*/



/*
	SESSION ID
*/


if (ISSET($_SESSION['sid'])) {
	$sid=$_SESSION['sid'];
	$user_id=$_SESSION['user_id'];
	require_once $dr."classes/user/user_info.php";
	$ui=new UserInfo($user_id);
}

/*
	CHECK FOR THE EXISTENCE OF THE DATABASE
*/


/*
	SITE LANGUAGE
*/

require_once($dr."language/en_new.php");
require_once($dr."include/functions/language/language.php");

/*
	DESIGN FUNCTIONS
*/

require_once $dr."include/functions/design/curve_boxes.php";
require_once $dr."include/functions/design/buttons.php";
require_once $dr."include/functions/acl/check_access.php";
require_once $dr."include/functions/design/module_menu.php";
require_once $dr."include/functions/string/escape_data.php";
require_once $dr."include/functions/string/alpha_numeric.php";
require_once $dr."include/functions/db/get_col_value.php";
require_once $dr."include/functions/logging/log.php";

/* LOGGING */
LogSite();

/*
	USER CLASS FOR USER INFO
*/



/*
	ESCAPE OUR POSTED DATA
*/

function DataEscape($v) {
	if (get_magic_quotes_gpc() == True) {
		return TRIM($v);
	}
	else {
		return AddSlashes(TRIM($v));
	}
}
/*
	DATABASE COMPLIANCE
*/

function BoolDB($v) {
	if ($GLOBALS['database']=="mysql") {
		if ($v==True || $v=="t" || $v=="1") {
			return "t";
		}
		else {
			return "f";
		}
	}
}


?>