<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";
require_once $GLOBALS['dr']."modules/wc/classes/user_team.php";
require_once $GLOBALS['dr']."modules/wc/classes/player_id.php";

function AddMyPlayers() {

	$c="";

	$arr_sys_pos=array("Goalkeeper","Defender","Defender","Defender","Defender","Midfield","Midfield","Midfield","Midfield","Striker","Striker");
	$arr_usr_pos=array("GK","D1","D2","D3","D4","M1","M2","M3","M4","S1","S2");

	for ($i=0;$i<count($arr_sys_pos);$i++) {

		$form=new CreateForm;
		$form->SetCredentials("index.php?module=wc&task=my_team&&jshow=add&subtask=","post","add_my_player_".$i,"","500");
		//$form->Header("nuvola/32x32/apps/kcmdf.png","My Players");

		/* GET THE PLAYER IN EACH POSITION */
		$ut=new UserTeam;
		$ut->SetVariable("fixture_type_id",$GLOBALS['ws']->GetInfo("fixture_type_id"));
		$player_id=$ut->GetPlayerInPosition($arr_usr_pos[$i]);

		/* PLAYER CLASS */
		$pi=new PlayerID;
		$pi->SetParameters($player_id);
		$v_player_name=$pi->GetInfo("player_name");
		$logo_location=$pi->GetInfo("logo_location");

		//echo $player_id."<br>";
		/* ALLOW USERS TO SELECT PLAYER FROM DROPDOWN */
		//echo $player_id."<br>";
		if ($player_id<1) {
			$form->ShowDropDown($arr_sys_pos[$i],"player_id","player_name","position_master","player_id",$player_id,"
						SELECT pm.player_id, pm.player_name, pom.position_name
						FROM ".$GLOBALS['database_ref']."player_master pm, ".$GLOBALS['database_ref']."position_master pom
						WHERE pm.position_id = pom.position_id
						AND pom.position_name = '".$arr_sys_pos[$i]."'
						","","","onChange=\"document.add_my_player_".$i.".submit();\"","<a href='index.php?module=wc&task=my_team&subtask=del_player&player_id=".$player_id."&jshow=add'>Delete</a>","","200");
		}
		else {
			$form->DescriptionCell($arr_sys_pos[$i],"<img src='".$logo_location."'>".$v_player_name." - <a href='index.php?module=wc&task=my_team&subtask=del_player&player_id=".$player_id."&jshow=add'>Delete</a>","","300","200","left","left");
		}
		/*
		AND pm.player_id NOT IN (
						SELECT player_id
						FROM ".$GLOBALS['database_ref']."user_team
						WHERE user_id = ".$_SESSION['user_id']."
						AND fixture_type_id = '".$GLOBALS['ws']->GetInfo("fixture_type_id")."'
					)
		*/
		//$form->Submit("Save","FormSubmit");
		$form->Hidden("position",$arr_usr_pos[$i]);
		$form->CloseForm();
		$c.=$form->DrawForm();
	}

	$c.="<input type='button' value='Reset my choices for this round' class='buttonstyle' onClick=\"javascript:location='index.php?module=wc&task=my_team&subtask=reset&jshow=add'\">\n";

	return $c;
}

?>