<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."modules/wc/classes/user_team.php";
require_once $GLOBALS['dr']."modules/wc/classes/player_id.php";

function Browse() {
	$c="";
	$formation=$GLOBALS['ws']->GetInfo("team_setup");

	$c.="<table class='soccer_field' align='center' border='0'>\n";
		$c.="<tr height='25%'>\n";
			$c.="<td align='center'>".GetPositionDetails("GK","blue")."</td>\n";
		$c.="</tr>\n";
		$c.="<tr height='25%'>\n";
			$c.="<td>\n";
			$c.="<table width='100%'>\n";
				$c.="<tr>\n";
					$c.="<td align='right' width='25%'>".GetPositionDetails("D1","green")."</td>\n";
					$c.="<td align='center' width='25%'>".GetPositionDetails("D2","green")."</td>\n";
					$c.="<td align='center' width='25%'>".GetPositionDetails("D3","green")."</td>\n";
					$c.="<td align='left' width='25%'>".GetPositionDetails("D4","green")."</td>\n";
				$c.="</tr>\n";
			$c.="</table>\n";
			$c.="</td>\n";
		$c.="</tr>\n";

		$c.="<tr height='25%'>\n";
			$c.="<td>\n";
			$c.="<table width='100%'>\n";
				$c.="<tr>\n";
					$c.="<td align='right' width='25%'>".GetPositionDetails("M1","red")."</td>\n";
					$c.="<td align='center' width='25%'>".GetPositionDetails("M2","red")."</td>\n";
					$c.="<td align='center' width='25%'>".GetPositionDetails("M3","red")."</td>\n";
					$c.="<td align='left' width='25%'>".GetPositionDetails("M4","red")."</td>\n";
				$c.="</tr>\n";
			$c.="</table>\n";
			$c.="</td>\n";
		$c.="</tr>\n";

		$c.="<tr height='25%'>\n";
			$c.="<td>\n";
			$c.="<table width='100%'>\n";
				$c.="<tr>\n";
					$c.="<td align='center' width='50%'>".GetPositionDetails("S1","white")."</td>\n";
					$c.="<td align='center' width='50%'>".GetPositionDetails("S2","white")."</td>\n";
				$c.="</tr>\n";
			$c.="</table>\n";
			$c.="</td>\n";
		$c.="</tr>\n";
	$c.="</table>\n";

	return $c;

}

function GetPositionDetails($p_pos,$p_col) {
	$ut=new UserTeam;
	$ut->SetVariable("fixture_type_id",$GLOBALS['ws']->GetInfo("fixture_type_id"));
	//$ut->SetVariable("position_location",$p_pos);
	$player_id=$ut->GetPlayerInPosition($p_pos);

	$pi=new PlayerID;
	$pi->SetParameters($player_id);
	$v_player_name=$pi->GetInfo("player_name");
	$v_team_logo_location=$pi->GetInfo("logo_location");
	if (IS_NUMERIC($player_id)) {
		return "<font size='1'><img src='".$v_team_logo_location."' width='40'><br>".$v_player_name."</font>";
		//return "<img src='modules/wc/images/pawn_glass_".$p_col.".png'><br>".$v_player_name;
	}
	else {
		return "<img src='images/nuvola/32x32/actions/editdelete.png'>";
	}
}

?>