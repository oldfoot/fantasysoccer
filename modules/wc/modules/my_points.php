<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."classes/form/create_form.php";

require_once $GLOBALS['dr']."modules/wc/functions/browse/browse_my_points.php";

function LoadTask() {

	$c="";

	$c.=BrowseMyPoints();

	return $c;
}
?>