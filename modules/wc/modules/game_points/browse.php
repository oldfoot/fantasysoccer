<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/functions/browse/game_browse_points.php";

function Browse() {
	return CurveBox(GameBrowsePoints());
}

?>