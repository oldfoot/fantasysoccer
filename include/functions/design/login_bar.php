<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );
require_once $dr."include/functions/db/get_col_value.php";

function LoginBar() {
	$ui=$GLOBALS['ui'];
	$workspace_id=$ui->WorkspaceID();
	$teamspace_id=$ui->TeamspaceID();
	$s="<table class='plain' width='100%'>\n";
		$s.="<tr>\n";
			$s.="<td><a href='index.php'>Home</a> | ";
			if (!EMPTY($workspace_id)) {
				$s.="You are logged into: <a href='bin/workspace/unset.php'>".GetColumnValue("name",$mysql_table_prefix."workspace_master","workspace_id",$workspace_id)."</a>";
			}
			if (!EMPTY($teamspace_id)) {
				$s.="<img src='images/nuvola/16x16/actions/forward.png' height='16' width='16'><a href='bin/teamspace/unset.php'>".GetColumnValue("name",$mysql_table_prefix."teamspace_master","teamspace_id",$teamspace_id)."</a>";
			}
			$s.="</td>\n";
			$s.="<td align='right'>Welcome, ".$ui->FullName()." <a href='bin/login/logout.php'>Logout</a></td>\n";
		$s.="</tr>\n";
	$s.="</table>\n";
	return $s;
}
?>