<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function DateToSeconds($dt) {
	//echo $dt;
	$tempdate = explode(' ', $dt);
	
	$part1 = explode("-",$tempdate[0]);
	$part2 = explode(":",$tempdate[1]);
	
	$year = $part1[0];
	$month = $part1[1];
	$daynum = $part1[2];
	$hour = $part2[0];
	$minute = $part2[1];
	$second = $part2[2];

	return mktime($hour,$minute,$second,$month,$daynum,$year);
}
?>