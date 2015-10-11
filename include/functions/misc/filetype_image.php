<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

function FiletypeImage($v) {
	if (file_exists($GLOBALS['dr']."images/filetypes/".$v.".gif")) {
		return "<img src='images/filetypes/".$v.".gif'>\n";
	}
	else {
		return "<img src='images/filetypes/other.gif'>\n";
	}
}
?>