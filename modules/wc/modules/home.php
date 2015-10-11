<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once($GLOBALS['dr']."modules/wc/modules/home/announcements.php");
require_once($GLOBALS['dr']."modules/wc/modules/home/top10.php");
require_once($GLOBALS['dr']."modules/wc/modules/home/total_points.php");
require_once($GLOBALS['dr']."modules/wc/modules/home/latest_results.php");

function LoadTask() {

	$c="<table width='100%'>\n";
		$c.="<tr>\n";
			$c.="<td width='50%' align='center' valign='top'>\n";
			$c.="<table width='100%'>\n";
				$c.="<tr>\n";
					$c.="<td align='center'>".Announcements()."</td>\n";
				$c.="</tr>\n";
				$c.="<tr>\n";
					$c.="<td align='center'>".Top10()."</td>\n";
				$c.="</tr>\n";
			$c.="</table>\n";
			$c.="</td>\n";
			$c.="<td width='50%' align='center' valign='top'>\n";
			$c.="<table width='100%'>\n";
				$c.="<tr>\n";
					$c.="<td align='center'>".TotalPoints()."</td>\n";
				$c.="</tr>\n";
				$c.="<tr>\n";
					$c.="<td align='center'>".LatestResults()."</td>\n";
				$c.="</tr>\n";
			$c.="</table>\n";
			$c.="</td>\n";
		$c.="</tr>\n";
	$c.="</table>\n";

	return $c;
}
?>