<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."include/functions/date_time/jcalendar.php";

class CreateForm {
	function SetCredentials($action,$method,$name,$extra="",$table_width="100%") {
		$this->form_name=$name;
		$this->form="<form action='".$action."' method='".$method."' name='".$name."' ".$extra.">\n";
		$this->form.="<table class='plain_white', width='".$table_width."'>\n";
	}

	function Header($logo,$desc) {
		$this->form.="<tr class='header'>\n";
			$this->form.="<td colspan='2' valign='top'><img src='".$GLOBALS['wb']."images/".$logo."'>".$desc."</td>\n";
		$this->form.="</tr>\n";
	}

	function Input($desc,$name,$popup="",$form_name="",$field_text="",$field_value="",$size="25",$maxlength="", $extra="") {
		if ($popup=="user") { $show_popup="<img src='images/nuovext/16x16/actions/new_window.png' OnClick=\"window.open('bin/new_window/select_user.php?form_name=".$form_name."&field_text=".$field_text."&field_value=".$field_value."','Select User','scrollbars=no,status=no,width=400,height=350')\">\n"; }
		elseif ($popup=="logo") { $show_popup="<img src='images/nuovext/16x16/actions/new_window.png' OnClick=\"window.open('bin/new_window/browse_icons.php?form_name=".$form_name."&field_text=".$field_text."&field_value=".$field_value."','Browse Icons','scrollbars=no,status=no,width=400,height=350')\">\n"; }
		else { $show_popup=""; }
		if (!EMPTY($maxlength)) { $maxlength="maxlength=".$maxlength; } else { $maxlength=""; }
		$this->form.="<tr>\n";
			$this->form.="<td valign='top'>".$desc."</td>\n";
			$this->form.="<td><input type='text' name='".$name."' class='inputbox' value='".$field_value."' size='".$size."' ".$maxlength." ".$extra.">".$show_popup."</td>\n";
		$this->form.="</tr>\n";
	}

	function Password($desc,$name,$popup="",$form_name="",$field_text="",$field_value="",$size="25") {
		$this->form.="<tr>\n";
			$this->form.="<td valign='top'>".$desc."</td>\n";
			$this->form.="<td><input type='password' name='".$name."' class='inputbox' value='".$field_value."' size='".$size."'></td>\n";
		$this->form.="</tr>\n";
	}

	function TimeFromTo($desc,$name_from,$name_to,$name_from_val,$name_to_val,$not_avail_name="",$not_avail_name_checked="") {
		$this->form.="<tr>\n";
			$this->form.="<td valign='top'>".$desc."</td>\n";
			$this->form.="<td>";
			/*
			$this->form.="<input type='text name='".$name_from."' value='".$name_from_val."' size='6' class='inputstyle'>\n";
			$this->form.=JCalendarTime($name_from,$name_from);
			$this->form.="<input type='text name='".$name_to."' value='".$name_to_val."' size='6' class='inputstyle'>\n";
			$this->form.=JCalendarTime($name_to,$name_to);
			*/
			/* TRIM THE SELECTED VALUES TO THE FIRST 5 CHARACTERS FOR HOUR AND MINUTE ONLY */
			$name_from_val=SUBSTR($name_from_val,0,5);
			$name_to_val=SUBSTR($name_to_val,0,5);

			$this->form.="<select name='".$name_from."' class='inputstyle'>\n";
			for ($i=0;$i<24;$i++) {
				for ($j=0;$j<46;$j) {
					if ($i==0) { $i_show="00"; } else { if ($i<10) { $i_show="0".$i; } else { $i_show=$i; } }
					if ($j==0) { $j_show="00"; } else { $j_show=$j; }

					$friendly_val=$i_show.":".$j_show;
					//echo $friendly_val." versus ".$name_from_val."<br>";
					if ($friendly_val==$name_from_val) { $selected="selected"; } else { $selected=""; }
					$this->form.="<option value='".$friendly_val.":00' ".$selected.">".$friendly_val."</option>\n";
					$j+=15;
				}
			}
			$this->form.="</select>\n";
			$this->form.=" to \n";
			$this->form.="<select name='".$name_to."' class='inputstyle'>\n";
			for ($i=0;$i<24;$i++) {
				for ($j=0;$j<46;$j) {
					if ($i==0) { $i_show="00"; } else { if ($i<10) { $i_show="0".$i; } else { $i_show=$i; } }
					if ($j==0) { $j_show="00"; } else { $j_show=$j; }

					$friendly_val=$i_show.":".$j_show;
					//echo $friendly_val." versus ".$name_from_val."<br>";
					if ($friendly_val===$name_to_val) { $selected="selected"; } else { $selected=""; }
					$this->form.="<option value='".$friendly_val.":00' ".$selected.">".$friendly_val."</option>\n";
					$j+=15;
				}
			}
			$this->form.="</select>\n";
			if (!EMPTY($not_avail_name)) {
				if ($not_avail_name_checked) { $checked="checked"; } else { $checked=""; }
				$this->form.=" Not available: <input type='checkbox' name='".$not_avail_name."' value='y' class='inputstyle' ".$checked.">\n";
			}
			$this->form.="</td>\n";
		$this->form.="</tr>\n";
	}

	function Date($desc,$name_from,$name_from_val) {
		$this->form.="<tr>\n";
			$this->form.="<td valign='top'>".$desc."</td>\n";
			$this->form.="<td>";
			$this->form.="<nobr><input type='text' name='".$name_from."' id='".$name_from."' value='".$name_from_val."' size='10' class='inputstyle'>\n";
			/* FOR MOBILE DON'T SHOW THE JCALENDAR */
			if (!defined( '_VALID_DIR__MOBILE_' )) {
				$this->form.=JCalendar($name_from,$name_from."_id");
			}
			else {
				$this->form.="<font size=1>YYYY-MM-DD</font>";
			}
			$this->form.="</nobr></td>";
		$this->form.="</tr>\n";

	}

	function Hidden($name,$value="") {
		$this->form.="<input type='hidden' name='".$name."' value='".$value."'>\n";
	}

	function TextArea($desc,$name,$rows,$cols,$value="") {
		$this->form.="<tr>\n";
			$this->form.="<td valign='top'>".$desc."</td>\n";
			$this->form.="<td><textarea rows='".$rows."' cols='".$cols."' name='".$name."' class='inputbox'>".$value."</textarea></td>\n";
		$this->form.="</tr>\n";
	}

	function DescriptionCell($desc,$value,$class="",$width1="",$width2="",$align1="",$align2="") {
		$this->form.="<tr class=".$class.">\n";
			$this->form.="<td valign='top' width=".$width1." align=".$align1.">".$desc."</td>\n";
			$this->form.="<td width=".$width2." align=".$align2.">".$value."</td>\n";
		$this->form.="</tr>\n";
	}

	function TextAreaEnterSubmit($textarea_name) {
		$this->form.="<script type='text/javascript'><!--\n";
			$this->form.="function entertag(evt){\n";
			$this->form.="evt=(evt)?evt:event;\n";
			$this->form.="charCode=(evt.which)?evt.which:evt.keyCode;\n";
			$this->form.="if(charCode==13)document.".$this->form_name.".submit();\n";
		$this->form.="}\n";
		$this->form.="window.onload=attach;\n";
		$this->form.="function attach(){\n";
			$this->form.="document.".$this->form_name.".".$textarea_name.".onkeypress = entertag;\n";
		$this->form.="}\n";
		$this->form.="//--></script>\n";
	}

	function File($name) {
		$this->form.="<tr>\n";
			$this->form.="<td valign='top'>Select file:</td>\n";
			$this->form.="<td><input name='".$name."' type='file'></td>\n";
		$this->form.="</tr>\n";
	}

	function Checkbox($desc,$name,$checked=False) {
		if ($checked) { $checked="checked"; } else { $checked=""; }
		$this->form.="<tr>\n";
			$this->form.="<td valign='top'>".$desc."</td>\n";
			$this->form.="<td><input type='checkbox' name='".$name."' value='y' class='inputstyle' ".$checked."></td>\n";
		$this->form.="</tr>\n";
	}

	function Radio($desc,$name,$arr,$selected="") {
		$this->form.="<tr>\n";
			$this->form.="<td valign='top'>".$desc."</td>\n";
			$this->form.="<td>";
			for ($i=0;$i<count($arr);$i++) {
				if ($arr[$i]==$selected) { $checked_disp="checked"; } else { $checked_disp=""; }
				$this->form.=$arr[$i].":<input type='radio' name='".$name."' value='".$arr[$i]."' class='inputstyle' ".$checked_disp.">";
			}
			$this->form.="</td>\n";
		$this->form.="</tr>\n";
	}

	function ShowDropDown($desc,$f1,$f2,$tb,$sn,$sl,$sql="",$sql_extra="",$multiple="",$extra_dd="",$extra_cell="",$width_desc="100%",$width_val="100%",$extra_td="") {
		$db=$GLOBALS['db'];
	 	if (EMPTY($sql)) {
		 	$sql="SELECT DISTINCT $f1 as $f1, $f2 as $f2
		 	      FROM ".$GLOBALS['database_ref']."$tb
		 	      $sql_extra
		 	      ORDER BY $f2";
		}

		//echo $sql;
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			$drop_down="<select name='".$sn."' class='inputbox' ".$multiple." ".$extra_dd.">";
			$drop_down.="<option value=''>--==Select One==--</option>";
			while($row=$db->FetchArray($result)) {
				if (!EMPTY($sl) && $sl==$row[$f1]) { $sel="selected"; } else { $sel=""; }
				$drop_down.="<option value='".@$row[$f1]."' ".$sel.">".@$row[$f2]."</option>";
			}
			$drop_down.="</select>";
		}
		else {
			$drop_down="<select class='inputbox'><option>No items</option></select>";
		}
		$this->form.="<tr>\n";
			$this->form.="<td valign='top' width='".$width_desc."'>".$desc."</td>\n";
			$this->form.="<td valign='top' width='".$width_val."'>".$drop_down." ".$extra_cell."</td>\n";
			if (!EMPTY($extra_td)) {
				$this->form.="<td valign='top'>".$extra_td."</td>";
			}

		$this->form.="</tr>\n";
	}

	function DropDownCounter($start_count,$end_count,$sn,$sl,$desc) {
		$drop_down="<select name='".$sn."' class='inputbox'>";
			$drop_down.="<option value=''>--==Select One==--</option>";
			for ($i=$start_count;$i<=$end_count;$i++) {
				if (!EMPTY($sl) && $sl==$row[$f1]) { $sel="selected"; } else { $sel=""; }
					$drop_down.="<option value='".$i."' ".$sel.">".$i."</option>";
				}
		$drop_down.="</select>";

		$this->form.="<tr>\n";
			$this->form.="<td valign='top'>".$desc."</td>\n";
			$this->form.="<td valign='top'>".$drop_down."</td>\n";
		$this->form.="</tr>\n";
	}

	function Submit($value,$name) {
		$this->form.="<tr>\n";
			$this->form.="<td colspan='2'>\n";
			$this->form.="<input type='submit' value='".$value."' name='".$name."' class='buttonstyle'>\n";
			$this->form.="</td>\n";
		$this->form.="</tr>\n";
	}

	function SetFocus($field) {
		$this->form.="<script language='JavaScript'>\n";
		$this->form.="document.".$this->form_name.".".$field.".focus();\n";
		$this->form.="</script>\n";
	}

	function CloseForm() {
		$this->form.="</form>\n";
	}

	function DrawForm() {
		$this->form.="</table>\n";
		return $this->form;
	}
}
?>