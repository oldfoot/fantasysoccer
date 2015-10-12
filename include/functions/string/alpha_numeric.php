<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function IsAlphaNumeric($v) {
	return preg_match("([a-zA-Z0-9])",$v);
}
?>