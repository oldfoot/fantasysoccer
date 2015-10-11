<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."include/functions/date_time/valid_time.php";

/* EXPECT DATE IN THE FORMAT 2005-12-31 23:59:39 */

function ValidDate($dt) {

	/* SPLIT THE VARIABLE */
	$tempdate = split('[- :]', $dt);
	$year = $tempdate[0];
	$month = $tempdate[1];
	$day = $tempdate[2];
	$hour = $tempdate[3];
	$minute = $tempdate[4];
	$second = $tempdate[5];

	/* VALIDATE THE DATE */
	if (!checkdate($month,$day,$year)) { return False; }

	/* VALIDATE THE TIME */
	if (!ValidTime($hour.":".$minute.":".$second)) { return False; }

	/* RETURN TRUE IF NO ERRORS FOUND */
	return True;
}
?>