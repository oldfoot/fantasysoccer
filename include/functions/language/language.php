<?php
/* THIS ENSURES WE ARE ABLE TO CONTROL OUR INCLUDE FILES */
define( '_VALID_SSTARS_', 1 );

function Language($lookup_code,$language,$edit_mode="n") {
	$language=$GLOBALS['language'];
	if ($edit_mode=="y") {
		return "<form method=post action=bin/language/set.php?lookup_code=".$lookup_code."><input type=text size=5></form>";
	}
	else {
		return $language[$lookup_code];
	}
}
?>