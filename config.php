<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

ob_start();

// TURN OFF ERRORS IN PRODUCTION
if ($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "192.168.2.12" || preg_match("/tst_/",$_SERVER['SCRIPT_NAME'])) {
	//ini_set("display_errors","Off");	
	error_reporting(E_ALL);
	//error_reporting(0);
}
else {
	error_reporting(0);
}

require "classes/core_offline.php";	
$offline = new offline;

if (file_exists("siteoffline")) {
	$offline->SetVar("message_extra","We are doing a bit of maintenance, check back shortly.");
	echo $offline->Show();
	die();
}

require "classes/core_session.php";	

require_once "site_config.php";

$session = new session();

session_set_save_handler(array($session,"open"),
                         array($session,"close"),
                         array($session,"read"),
                         array($session,"write"),
                         array($session,"destroy"),
                         array($session,"gc")); 

session_start();

//echo $_SESSION['userid'];
//die();

require "classes/core_mysqli.php";	
//require "classes/core_mysql.php";	

$db = new MySQL;
$db->Connect($database_hostname,$database_user,$database_password,$database_name,$database_port);


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
//LogSite();

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
	if ($GLOBALS['database_type']=="mysql") {
		if ($v==True || $v=="t" || $v=="1") {
			return "t";
		}
		else {
			return "f";
		}
	}
}


?>