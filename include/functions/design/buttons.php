<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function DrawButtons($url, $desc, $bname, $disabled, $confirm="n", $prompt="") {
	$it=$GLOBALS['it'];
	if ($GLOBALS["button_type"] == 1) {
		if ($confirm == "y") {
			$button_val="if (confirm('Are You Sure?')) {return true} else {return false};";
		}
		return "<input $disabled onClick=\"".$button_val."javascript:location='$url'\" value=' $desc ' type='button' class='buttonstyle' title='$desc'>\n";
	}
	else {
		if ($confirm == "y") {
			$button_val="onClick=\"if (confirm('Are You Sure?')) {return true} else {return false}\"";
		}
		if ($disabled == "disabled") { $url=""; } else { $url="<a href='$url' $button_val>"; }
		if (!EMPTY($prompt)) { $prompt_show="onClick=\"alert('".$prompt."')\""; } else { $prompt_show=""; }
		return $url."<img src='images/buttons/$bname.gif' border='0' title='$desc' $prompt_show></a>\n";
	}
}
?>