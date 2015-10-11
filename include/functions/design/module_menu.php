<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $dr."include/functions/string/initcap.php";

function ModuleMenu($head,$module,$arr_menu,$arr_images="") {
	$ui=$GLOBALS['ui'];
	$wb=$GLOBALS['wb'];
	$dr=$GLOBALS['dr'];
	$c="<table class='plain'>\n";
		$c.="<tr>\n";
			$c.="<td colspan='2' class='bold'>".$head."</td>\n";
		$c.="</tr>\n";
		/* LOOP ALL THE ITEMS IN THE MENU ARRAY */
		for ($i=0;$i<count($arr_menu);$i++) {
			/* CHECK THE ACL FOR THIS MODULE */
			if (CheckAccess($GLOBALS['ui']->GetColVal("role_id"),$module,$arr_menu[$i])) {
				$friendly=InitCap($arr_menu[$i]);
				if (defined( '_VALID_SSTARS__MOBILE_' )) {
					$c.="<tr><td colspan='2'>+<a href='index.php?module=".$module."&task=".$arr_menu[$i]."'>".$friendly."</a></td></tr>";
				}
				else {
					$menu_icon=$dr."modules/".$module."/images/menu_icons/".$arr_menu[$i].".png";
					//echo $menu_icon;
					if (!file_exists($menu_icon)) {
						$icon=$wb."images/nuvola/16x16/actions/blend.png";
					}
					else {
						$icon=$wb."modules/".$module."/images/menu_icons/".$arr_menu[$i].".png";
					}
					$c.="<tr>\n";
						$c.="<td width='16'><img src='".$icon."'></td>\n";
						$c.="<td><a href='index.php?module=".$module."&task=".$arr_menu[$i]."'>".$friendly."</a></td>\n";
					$c.="</tr>\n";
				}
			}
		}
	$c.="</table>\n";
	return $c;
}
?>