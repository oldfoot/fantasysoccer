<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function DrawInput($name,$class,$value,$size,$maxlength,$readonly="",$extra="") {
	return "<input type='text' name='$name' id='$name' value='$value' size='$size' $readonly maxlength='$maxlength' class='$class' $extra>";
}

function DrawHidden($name,$value) {
	return "<input type='hidden' name='$name' value='$value'>";
}

function DrawPassword($name,$value,$size,$maxlength) {
	return "<input type='password' name='$name' value='$value' size='$size' maxlength='$maxlength'>";
}

function DrawTextarea($name,$class,$value,$rows,$cols) {
	return "<textarea name='$name' rows='$rows', cols='$cols' class='$class'>$value</textarea>";
}

function DrawCheckbox($name,$class,$value,$checked,$misc="") {
	if ($checked == "y") { $selected = "checked"; } else { $selected = ""; }
	return "<input type='checkbox' name='$name' value='$value' $selected class='$class' $misc>";
}

function DrawSubmit($type,$value,$class,$name,$disabled="") {
	return "<input type='$type' value='$value' class='$class' name='$name' $disabled>";
}

function DrawRadioButton($value,$class,$name,$checked) {
	if ($checked == "y") { $selected = "checked"; } else { $selected = ""; }
	return "<input type='radio' $selected value='$value' class='$class' name='$name'>";
}

function DrawFileUpload($name,$class) {
	return "<input type='file' class='$class' name='$name'>";
}
?>