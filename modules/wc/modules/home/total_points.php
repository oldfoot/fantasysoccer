<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."include/functions/db/get_col_value.php");

function TotalPoints() {

	$c="<table class='plain_border'>\n";
		$c.="<tr class='header'>\n";
			$c.="<td colspan='2' align='center'>Total Points</td>\n";
		$c.="</tr>\n";
		$c.="<tr>\n";
			$c.="<td>Total accumulated to date</td>\n";
			$c.="<td align='center'>".GetColumnValue("sum(points)","user_points","user_id",$_SESSION['user_id'],"")."</td>\n";
		$c.="</tr>\n";
		
	$c.="</table>\n";

	return $c;
}

?>