<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."include/functions/db/count_rows.php";

require_once $GLOBALS['dr']."modules/wc/classes/wc_setup.php";
require_once $GLOBALS['dr']."modules/wc/functions/log/log_history.php";

function LoadModule() {
	/* SETUP */
	global $ws;
	$ws=new WCSetup();
	global $ui;

	$c="<table height='100%'>\n";
		$c.="<tr>\n";
			$c.="<td colspan='3'>\n";
				$c.="<table class='plain_white'>\n";
				$c.="<tr>\n";
					$c.="<td width=70%>Current stage: ".$ws->GetInfo("type_name")."</td>\n";
					$c.="<td width=20%>Total players: ".CountRows("user_master", "", "user_id", "", True)."</td>\n";
					$c.="<td width=10%>Online: ".CountRows("user_master", "", "user_id", "WHERE date_last_login > date_add(curdate(),interval -1 hour)",True)."</td>\n";
				$c.="</tr>\n";
			$c.="</table>\n";
			$c.="</td>\n";
		$c.="</tr>\n";
		$c.="<tr>\n";
			/* THIS IS WHERE THE MAIN CONTENT GOES */
			$c.="<td width='90%' valign='top'>\n";
			if (ISSET($_GET['task'])) {
				$task_file=$dr."modules/wc/modules/".$_GET['task'].".php";
				if (file_exists($task_file)) {
					require_once($task_file);
					$c.=LoadTask();
				}
			}
			$c.="</td>\n";
			/* THE MENU */
			$c.="<td valign='top' width='1' bgcolor='#339999'><img src='images/spacer.gif' width='1' height='1'></td>\n";
			$c.="<td valign='top' width='200'>".ModuleMenu("World Cup","wc",array("home","my_team","my_settings","my_results","my_predictions","browse_predictions","my_points","game_points","browse_teams","browse_players","teams","players","positions","points","points_type","roles","fixture_type","fixtures","prediction_results","acl"),"")."</td>";
		$c.="</tr>\n";
	$c.="</table>\n";

	return $c;
}
?>