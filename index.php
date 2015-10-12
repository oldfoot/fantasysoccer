<?php
/* THIS ENSURES WE ARE ABLE TO CONTROL OUR INCLUDE FILES */
define( '_VALID_DIR_', 1 );

require_once "config.php";

require_once $dr."include/functions/design/top_menu_items.php";
echo "<html>\n";
echo "<head>\n";
echo "<link rel='stylesheet' href='".$wb."css/css.css' type='text/css'>\n";
/* CALENDAR POPUP */
echo "<style type='text/css'>@import url(include/jscalendar/calendar-win2k-1.css);</style>\n";
echo "<script type='text/javascript' src='include/jscalendar/calendar.js'></script>\n";
echo "<script type='text/javascript' src='include/jscalendar/lang/calendar-en.js'></script>\n";
echo "<script type='text/javascript' src='include/jscalendar/calendar-setup.js'></script>\n";

echo "<title>".$title."</title>\n";
echo "<body>\n";

echo Body();

/* THIS IS THE BODY FUNCTION */
function Body() {

	GLOBAL $dr,$ui;

	if (ISSET($_GET['msg'])) {
		require_once $dr."/include/functions/misc/error_msgs.php";
		ErrorMessages(DataEscape($_GET['msg']));
	}
	$c="<table width='749' cellpadding='0' cellspacing='0' class='plain'>\n";
		if (ISSET($_GET['module']) && file_exists($dr."/modules/".$_GET['module']."/images/logo.jpg")) {
			$c.="<tr>\n";
				$c.="<td><img src='modules/".$_GET['module']."/images/logo.jpg'></td>\n";
			$c.="</tr>\n";
		}
		if (!EMPTY($_SESSION['user_id'])) {
			$c.="<tr>\n";
				$c.="<td colspan='4'>\n";
					$c.="<table class='topmenu'>\n";
					$c.="<tr>\n";
						$c.="<td>Welcome: ".$ui->GetColVal("full_name")."</td>\n";
						$c.="<td width='50'><a href='bin/login/logout.php'><font color='white'>Logout</font></a></td>\n";
					$c.="</tr>\n";
				$c.="</table>\n";
				$c.="</td>\n";
			$c.="</tr>\n";
		}
		/* CONTENT GOES HERE */
		$c.="<tr bgcolor='#336699' height='400'>\n";
			/* MODULES MENU */
			$c.="<td valign='top'>";
			if (!ISSET($_SESSION['user_id'])) {
				
				if (ISSET($_GET['module']) && $_GET['module']=="signup") {
					$module_file=$dr."modules/signup.php";
					if (file_exists($module_file)) {
						require_once $module_file;
						$c.=LoadModule();
					}
				}
				else {
					require_once $dr."include/functions/login/login_form.php";
					$c.="<br>";
					$c.=CurveBox("<h3><font color='white'>".$GLOBALS['title']."</font></h3>");
					$c.="<br>";
					$c.=CurveBox(ShowLoginForm());
				}
			}
			else {
				$module_file=$GLOBALS['dr']."modules/".$_GET['module'].".php";
				if (file_exists($module_file)) {
					require_once $module_file;
					$c.=LoadModule();
				}
				else {
					$c.="Error";
				}
			}
			$c.="</td>\n";
			if (ISSET($_GET['module']) && ISSET($_SESSION['user_id'])) {
				$c.="<td valign='top'>\n";
					$c.="<iframe src='".$GLOBALS['wb']."/modules/wc/bin/chat.php' width='150' height='800'>\n";
				$c.="</td>\n";
			}
		$c.="</tr>\n";
		$c.="<tr>\n";
			$c.="<td colspan='4' bgcolor='#336699' align='center' class='boldwhite'>Copyright Terence Le Grange</td>\n";
		$c.="</tr>\n";
	$c.="</table>\n";

	return $c;
}

echo "</html>\n";
?>