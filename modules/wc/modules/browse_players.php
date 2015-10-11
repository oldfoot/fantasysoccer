<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/functions/browse/public_browse_players.php";

function LoadTask() {

	return CurveBox(PublicBrowsePlayers());

}
?>