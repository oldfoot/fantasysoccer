<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/points.php";

function LoadTask() {

	$c="";

	require_once $GLOBALS['dr']."classes/design/tab_boxes.php";

	$tab_array=array("browse");
	$tb=new TabBoxes;
	$c.=$tb->DrawBoxes($tab_array,$dr."modules/wc/modules/game_points/");

	return $c;
}
?>