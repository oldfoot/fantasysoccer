<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function ShowDropDown($f1,$f2,$tb,$sn,$sl,$cl,$mtpl="",$size="",$extra="",$sql_extra="") {
	$db=$GLOBALS['db'];
 	$sql="SELECT DISTINCT LTRIM($f1) as $f1, LTRIM($f2) as $f2
 	      FROM ".$GLOBALS['database_ref']."$tb
 	      $sql_extra
 	      ORDER BY $f2";

	//echo $sql;
	$result = $db->query($sql);
	if ($db->NumRows($result) > 0) {
		$GLOBALS['dr']op_down = "<select name='".$sn."' id='".$sn."' class='$cl' ".$mtpl." ".$extra.">\n";
		$GLOBALS['dr']op_down .= "<option value=''>--==Select One==--</option>\n";
		while($row = $db->FetchArray($result)) {
			if ($sl == $row[$f1]) {
				$sel="selected";
			}
			else {
				$sel="";
			}
			$GLOBALS['dr']op_down .= "<option value='".$row[$f1]."' ".$sel.">".$row[$f2]."</option>\n";
		}
		$GLOBALS['dr']op_down .= "</select>";
		return $GLOBALS['dr']op_down;
	}
	else {
		return "No records found.";
		//return False;
	}
}
?>