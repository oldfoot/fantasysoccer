<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

/* REQUIRED INCLUDES */
require_once $GLOBALS['dr']."classes/form/create_form.php";
require_once $GLOBALS['dr']."include/functions/acl/check_access.php";
require_once $GLOBALS['dr']."include/functions/acl/check_create_acl_task_exists.php";

function BrowseModuleTaskACL($module) {

	$db=$GLOBALS['db'];

	/* SETUP THE INITIAL MODULE DIRECTORY */
	$dir=$GLOBALS['dr']."modules/".$module."/modules/";

	/* CHECK THAT THE MODULE EXISTS */
	if (!file_exists($dir)) { return "No such directory"; }

	/* LOOP THE PHP FILES IN EACH MODULE */
	$dir_arr[]="";
	if ($handle = opendir($dir)) {
    while (false !== ($file = readdir($handle))) {
	    if ($file != "." && $file != ".." && substr($file,-4)==".php") {
  			$dir_arr[]=substr($file,0,-4);
      }
    }
    closedir($handle);
	}
	/* SORT THE ARRAY INTO ALPHABETICAL ORDER */
	sort($dir_arr,SORT_REGULAR);

	/**** THIS IS THE SUBMIT FORM PART WHICH WE PUT IN HERE BECAUSE THIS PAGE IS LOADED FROM MANY LOCATIONS ****/
	if (ISSET($_POST['submit_form'])) {
		for ($i=1;$i<count($dir_arr);$i++) {
			/* GRAB ALL THE ROLES SINCE WE DO NOT SIMPLY UPDATE WHATEVER CAME FROM THE FORM */
			$sql="SELECT wrm.role_id,wrm.role_name
						FROM ".$GLOBALS['mysql_db']."role_master wrm
						ORDER BY wrm.role_name
						";
			//echo $sql."<br>";
			$result = $db->Query($sql);
			if ($db->NumRows($result) > 0) {
				while($row = $db->FetchArray($result)) {
					$post_var=$dir_arr[$i]."_".$row['role_id'];
					if (ISSET($_POST[$post_var]) && $_POST[$post_var]=="y") { $access="t"; } else { $access="f"; }
					/* SINCE NEW TASKS AND ROLES CAN BE ADDED WE MAKE SURE THE RECORD EXISTS */
					CheckCreateACLTaskExists($row['role_id'],$module,$dir_arr[$i]);
					$sql="UPDATE ".$GLOBALS['mysql_db']."role_priv
								SET access = '".$access."'
								WHERE role_id = ".$row['role_id']."
								AND module = '".$module."'
								AND task = '".$dir_arr[$i]."'
								";
					//echo $sql."<br>";
					$success=$db->Query($sql);
				}
			}
		}
	}
	/**** END FORM SUBMITTING ****/

	/* DISPLAY EACH */
	$c="<table class='plain_white' border='0'>\n";
	$c.="<form method='post' name='acl' action='index.php?module=".$module."&task=acl'>\n";
		for ($i=1;$i<count($dir_arr);$i++) {
			$c.="<tr class='alternatecell2'>\n";
	  		$c.="<td colspan='3'>".STRTOUPPER($dir_arr[$i])."</td>\n"	;
	  	$c.="</tr>\n";
	  	/* DISPLAY ALL THE ROLES*/
	  	$sql="SELECT wrm.role_id,wrm.role_name
						FROM ".$GLOBALS['mysql_db']."role_master wrm
						ORDER BY wrm.role_name
						";
			//echo $sql."<br>";
			$result = $db->Query($sql);
			if ($db->NumRows($result) > 0) {
				while($row = $db->FetchArray($result)) {
					if (CheckAccess($row['role_id'],$module,$dir_arr[$i])) { $selected="checked"; } else { $selected=""; }
					$c.="<tr>\n";
			  		$c.="<td><li></td>\n"	;
			  		$c.="<td>".$row['role_name']."</td>\n";
			  		$c.="<td><input type='checkbox' value='y' name='".$dir_arr[$i]."_".$row['role_id']."' $selected>\n";
			  	$c.="</tr>\n";
			  }
		  }
	  	/* END */
	  }
  	$c.="<tr class='alternatecell2'>\n";
  		$c.="<td colspan='3'><input type='submit' name='submit_form' value='Save' class='buttonstyle'></td>\n"	;
  	$c.="</tr>\n";
  $c.="</form>\n";
	$c.="</table>\n";

	return $c;
}
?>