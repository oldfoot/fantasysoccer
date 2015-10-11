<?php
header("Pragma: no-cache");
define( '_VALID_SSTARS_', 1 );

require_once "../../config.php";

/*
	REMOVE THE SESSION AND COOKIES
*/

unset($_SESSION['sid']);
unset($_SESSION['user_id']);

$url="../../index.php?msg=2";
Header("Location: $url");
?>