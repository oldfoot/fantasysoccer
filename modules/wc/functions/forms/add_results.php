<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";
require_once $GLOBALS['dr']."modules/wc/classes/fixture_results.php";

function Addresults($fixture_id,
										$goals_team_1="",$yellow_cards_team_1="",$red_cards_team_1="",$hatricks_team_1="",
										$goals_team_2="",$yellow_cards_team_2="",$red_cards_team_2="",$hatricks_team_2="") {

	$db=$GLOBALS['db'];

	/* WE CHANGE THE SUBTASK DEPENDING ON WHETHER WE'RE EDITING OR DELETING */
	if (!EMPTY($team_id_1)) {
		$v_subtask="edit";
	}
	else {
		$v_subtask="add";
	}

	/* SAVE TO DATABASE */
	if (ISSET($_POST['save_db'])) {

		$db->StartTransaction();
		$v_errors=False;

		echo "Saving now<br>";
		$fr=new FixtureResults;
		$fr->SetVariable("fixture_id",$_POST['fixture_id']);

		$fr->SetVariable("team_id_1",$_POST['team_id_1']);
		$fr->SetVariable("goals_team_1",$_POST['goals_team_1']);
		$fr->SetVariable("yellow_cards_team_1",$_POST['yellow_cards_team_1']);
		$fr->SetVariable("red_cards_team_1",$_POST['red_cards_team_1']);
		$fr->SetVariable("hatricks_team_1",$_POST['hatricks_team_1']);

		$fr->SetVariable("team_id_2",$_POST['team_id_2']);
		$fr->SetVariable("goals_team_2",$_POST['goals_team_2']);
		$fr->SetVariable("yellow_cards_team_2",$_POST['yellow_cards_team_2']);
		$fr->SetVariable("red_cards_team_2",$_POST['red_cards_team_2']);
		$fr->SetVariable("hatricks_team_2",$_POST['hatricks_team_2']);

		$result=$fr->CheckParameters();
		if (!$result) { $v_errors=True; }

		/* UPDATE FIXTURE MASTER */
		$fr->UpdateFixtureMaster();

		/* TEAM 1 */

		/* LOOP ALL THE GOAL SCORERS AND AWARD POINTS */
		for ($i=1;$i<=$goals_team_1;$i++) {
			echo "Awarding for goal: ".$i."<br>";
			$v_player_post="team_1_goal_".$i;
			$player_id=$_POST[$v_player_post];
			$result=$fr->AwardPoints($player_id,"Goal");
			if (!$result) { $v_errors=True; }	else { echo "<h2>Successfully awarded goal points for team 1</h2><br/>";}
		}

		/* LOOP ALL THE YELLOW CARDS */
		for ($i=1;$i<=$yellow_cards_team_1;$i++) {
			echo "Awarding for yellow cards: ".$i."<br>";
			$v_player_post="team_1_yellow_card_".$i;
			$player_id=$_POST[$v_player_post];
			$result=$fr->AwardPoints($player_id,"Yellow Card");
			if (!$result) { $v_errors=True; }	else { echo "<h2>Successfully awarded yellow cards points for team 1</h2><br/>";}
		}

		/* LOOP ALL THE RED CARDS */
		for ($i=1;$i<=$red_cards_team_1;$i++) {
			echo "Awarding for red cards: ".$i."<br>";
			$v_player_post="team_1_red_card_".$i;
			$player_id=$_POST[$v_player_post];
			$result=$fr->AwardPoints($player_id,"Red Card");
			if (!$result) { $v_errors=True; }	else { echo "<h2>Successfully awarded red cards points for team 1</h2><br/>";}
		}

		/* LOOP ALL THE HATRICKS */
		for ($i=1;$i<=$hatricks_team_1;$i++) {
			echo "Awarding for hatricks: ".$i."<br>";
			$v_player_post="team_1_hatrick_".$i;
			$player_id=$_POST[$v_player_post];
			$result=$fr->AwardPoints($player_id,"Hatrick");
			if (!$result) { $v_errors=True; }	else { echo "<h2>Successfully awarded hatrick points for team 1</h2><br/>";}
		}

		if ($goals_team_2==0) {
			echo "Awarding for cleansheet<br>";
			$player_id=$_POST['team_1_goalkeeper'];
			echo "playerid: ".$player_id."<br>";
			$result=$fr->AwardPoints($player_id,"Clean Sheet");

			if (!$result) { $v_errors=True; }	else { echo "<h2>Successfully awarded goalkeeper clean sheet for team 1</h2><br/>";}
		}

		/* LOOP ALl THE GOALS AND DEDUCT FROM THE GOALKEEPER */
		for ($i=1;$i<=$goals_team_2;$i++) {
			$player_id=$_POST['team_1_goalkeeper'];
			$result=$fr->AwardPoints($player_id,"Goalkeeper per goal conceded");
		}


		/* TEAM 2 */

		/* LOOP ALL THE GOAL SCORERS AND AWARD POINTS */
		for ($i=1;$i<=$goals_team_2;$i++) {
			echo "Awarding for goal: ".$i."<br>";
			$v_player_post="team_2_goal_".$i;
			$player_id=$_POST[$v_player_post];
			$result=$fr->AwardPoints($player_id,"Goal");
			if (!$result) { $v_errors=True; }	else { echo "<h2>Successfully awarded goal points for team 2</h2><br/>";}
		}

		/* LOOP ALL THE YELLOW CARDS */
		for ($i=1;$i<=$yellow_cards_team_2;$i++) {
			echo "Awarding for yellow cards: ".$i."<br>";
			$v_player_post="team_2_yellow_card_".$i;
			$player_id=$_POST[$v_player_post];
			$result=$fr->AwardPoints($player_id,"Yellow Card");
			if (!$result) { $v_errors=True; }	else { echo "<h2>Successfully awarded yellow cards points for team 2</h2><br/>";}
		}

		/* LOOP ALL THE RED CARDS */
		for ($i=1;$i<=$red_cards_team_2;$i++) {
			echo "Awarding for red cards: ".$i."<br>";
			$v_player_post="team_2_red_card_".$i;
			$player_id=$_POST[$v_player_post];
			$result=$fr->AwardPoints($player_id,"Red Card");
			if (!$result) { $v_errors=True; }	else { echo "<h2>Successfully awarded red cards points for team 2</h2><br/>";}
		}

		/* LOOP ALL THE HATRICKS */
		for ($i=1;$i<=$hatricks_team_2;$i++) {
			echo "Awarding for hatricks: ".$i."<br>";
			$v_player_post="team_2_hatrick_".$i;
			$player_id=$_POST[$v_player_post];
			$result=$fr->AwardPoints($player_id,"Hatrick");
			if (!$result) { $v_errors=True; }	else { echo "<h2>Successfully awarded hatrick points for team 2</h2><br/>";}
		}

		if ($goals_team_1==0) {
			echo "Awarding for cleansheet<br>";
			$player_id=$_POST['team_2_goalkeeper'];
			$result=$fr->AwardPoints($player_id,"Clean Sheet");
			if (!$result) { $v_errors=True; }	else { echo "<h2>Successfully awarded goalkeeper clean sheet for team 2</h2><br/>";}
		}

		/* LOOP ALL THE GOALS AND DEDUCT FROM THE GOALKEEPER */
		for ($i=1;$i<=$goals_team_1;$i++) {
			$player_id=$_POST['team_2_goalkeeper'];
			$result=$fr->AwardPoints($player_id,"Goalkeeper per goal conceded");
		}

		//$v_errors=True; /* FOR DEBUGGING */
		if (!$v_errors) {
			echo "Committed";
			$db->Commit();
		}
		else {
			echo "Rolled Back";
			$fr->ShowErrors();
			$db->Rollback();
		}
	}
	else {
		echo "Not saving now<br>";
	}

	/* CREATE A NEW OBJECT FROM THE FIXTURE ID CLASS */
	$fi=new FixtureID;

	$fi->SetParameters($fixture_id);
	$team_id_1=$fi->GetInfo("team_id_1");
	$team_1_name=$fi->GetInfo("team_name1");
	$team_id_2=$fi->GetInfo("team_id_2");
	$team_2_name=$fi->GetInfo("team_name2");
	$fixture_type_id=$fi->GetInfo("fixture_type_id");
	//echo $fixture_id."<br>";
	//echo $team_id_1."<br>";

	/* CREATE THE FORM */
	$form=new CreateForm;
	$form->SetCredentials("index.php?module=wc&task=results&subtask=".$v_subtask."&fixture_id=".$fixture_id,"post","add_results");
	$form->Header("nuvola/32x32/apps/kcmdf.png","Results");
	$form->Hidden("fixture_id",$fixture_id);

	$form->ShowDropDown("Team 1","team_id","team_name","team_master","team_id_1",$team_id_1,"","","");
	$form->Input($team_1_name." goals","goals_team_1","","","",$goals_team_1);
	$form->Input($team_1_name." yellow cards","yellow_cards_team_1","","","",$yellow_cards_team_1);
	$form->Input($team_1_name." red cards","red_cards_team_1","","","",$red_cards_team_1);
	$form->Input($team_1_name." hatricks","hatricks_team_1","","","",$hatricks_team_1);
	//$form->DropDownCounter(0,15,"goals_team_1",$goals_team_1,$team_1_name." goals");
	$form->ShowDropDown("Team 2","team_id","team_name","team_master","team_id_2",$team_id_2,"","","");
	$form->Input($team_2_name." goals","goals_team_2","","","",$goals_team_2);
	$form->Input($team_2_name." yellow cards","yellow_cards_team_2","","","",$yellow_cards_team_2);
	$form->Input($team_2_name." red cards","red_cards_team_2","","","",$red_cards_team_2);
	$form->Input($team_2_name." hatricks","hatricks_team_2","","","",$hatricks_team_2);
	//$form->ShowDropDown("Stage","fixture_type_id","type_name","fixture_type_master","fixture_type_id",$fixture_type_id,"","","");

	if (ISSET($_POST['FormSubmit'])) {

		$form->DescriptionCell("Details for ".$team_1_name,"","header");
		$form->Hidden("save_db","yes");

		/* TEAM 1 */

		/* SHOW THE GOAL SCORERS */
		$form->DescriptionCell("Goals","","colhead");
		for ($i=1;$i<=$goals_team_1;$i++) {
			$form->ShowDropDown($team_1_name." Goal ".$i,"player_id","player_name","player_master","team_1_goal_".$i,$fixture_type_id,"","WHERE team_id = ".$team_id_1,"");
		}
		/* SHOW THE YELLOW CARDS */
		$form->DescriptionCell("Yellow Cards","","colhead");
		for ($i=1;$i<=$yellow_cards_team_1;$i++) {
			$form->ShowDropDown($team_1_name." Yellow Card ".$i,"player_id","player_name","player_master","team_1_yellow_card_".$i,$fixture_type_id,"","WHERE team_id = ".$team_id_1,"");
		}
		/* SHOW THE RED CARDS */
		$form->DescriptionCell("Red Cards","","colhead");
		for ($i=1;$i<=$red_cards_team_1;$i++) {
			$form->ShowDropDown($team_1_name." Red Card ".$i,"player_id","player_name","player_master","team_1_red_card_".$i,$fixture_type_id,"","WHERE team_id = ".$team_id_1,"");
		}
		/* SHOW THE HATRICKS */
		$form->DescriptionCell("Hatricks","","colhead");
		for ($i=1;$i<=$hatricks_team_1;$i++) {
			$form->ShowDropDown($team_1_name." Hatrick ".$i,"player_id","player_name","player_master","team_1_hatrick_".$i,$fixture_type_id,"","WHERE team_id = ".$team_id_1,"");
		}
		/* GOALKEEPER WHO KEPT A CLEAN SHEET OR CONCEDED GOALS */
		$form->DescriptionCell("Goalkeeper","","colhead");
		//if ($goals_team_2==0) {
		$form->ShowDropDown("Goalkeeper","player_id","player_name","player_master","team_1_goalkeeper","","","WHERE team_id = ".$team_id_1,"");
		//}


		/* TEAM 2 */

		$form->DescriptionCell("Details for ".$team_2_name,"","header");

		/* SHOW THE GOAL SCORERS */
		$form->DescriptionCell("Goals","","colhead");
		for ($i=1;$i<=$goals_team_2;$i++) {
			$form->ShowDropDown($team_2_name." Goal ".$i,"player_id","player_name","player_master","team_2_goal_".$i,$fixture_type_id,"","WHERE team_id = ".$team_id_2,"");
		}
		/* SHOW THE YELLOW CARDS */
		$form->DescriptionCell("Yellow Cards","","colhead");
		for ($i=1;$i<=$yellow_cards_team_2;$i++) {
			$form->ShowDropDown($team_2_name." Yellow Card ".$i,"player_id","player_name","player_master","team_2_yellow_card_".$i,$fixture_type_id,"","WHERE team_id = ".$team_id_2,"");
		}
		/* SHOW THE RED CARDS */
		$form->DescriptionCell("Red Cards","","colhead");
		for ($i=1;$i<=$red_cards_team_2;$i++) {
			$form->ShowDropDown($team_2_name." Red Card ".$i,"player_id","player_name","player_master","team_2_red_card_".$i,$fixture_type_id,"","WHERE team_id = ".$team_id_2,"");
		}
		/* SHOW THE HATRICKS */
		$form->DescriptionCell("Hatricks","","colhead");
		for ($i=1;$i<=$hatricks_team_2;$i++) {
			$form->ShowDropDown($team_2_name." Hatrick ".$i,"player_id","player_name","player_master","team_2_hatrick_".$i,$fixture_type_id,"","WHERE team_id = ".$team_id_2,"");
		}

		/* GOALKEEPER WHO KEPT A CLEAN SHEET OR CONCEDED GOALS */
		$form->DescriptionCell("Goalkeeper","","colhead");
		//if ($goals_team_1==0) {
		$form->ShowDropDown("Goalkeeper","player_id","player_name","player_master","team_2_goalkeeper","","","WHERE team_id = ".$team_id_2,"");
		//}
	}


	$form->Submit("Save","FormSubmit");
	return $form->DrawForm();
}

?>