<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

function CurveBox($content) {
	$s="<table bgcolor='#003366' cellpadding='0' cellspacing='0' align='center' valign='top'>\n";
		$s.="<tr>\n";
			$s.="<td><img src='images/curves/top_left.gif'></td>\n";
			$s.="<td background='images/curves/top.gif'></td>\n";
			$s.="<td><img src='images/curves/top_right.gif'></td>\n";
		$s.="</tr>\n";
		$s.="<tr>\n";
			$s.="<td background='images/curves/left.gif'></td>\n";
			$s.="<td>\n";
			$s.=$content;
			$s.="</td>\n";
			$s.="<td background='images/curves/right.gif'></td>\n";
		$s.="</tr>\n";
		$s.="<tr>\n";
			$s.="<td><img src='images/curves/bottom_left.gif'></td>\n";
			$s.="<td background='images/curves/bottom.gif'></td>\n";
			$s.="<td><img src='images/curves/bottom_right.gif'></td>\n";
		$s.="</tr>\n";
	$s.="</table>\n";
	return $s;
}
?>