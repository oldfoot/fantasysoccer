<script language="php">
// NOTE - TO AVOID "Cannot send session cache limiter - headers already sent"
// maybe best to put this at the very beginning before any <html> or other output by webserver
// For most recent see http://www.cocoavillagepublishing.com/development/tools/php/scripts/ 
// v0.1 LICENSE NOTE,  This software is dual licensed using BSD-Style and LGPL. Where there is any discrepancy, the BSD-Style license will take precedence.
// Review the relative file ./license.txt for details.  The intention is that these works are available for all
// and may be profited from but not restricted in use.
//
// Start a new session to store a randomly generated string
// (may not be neccessary, $_SESSION may implicitly call session_start
session_start();
// include a common file with variables and functions
include("config.php");
//
// If $_SESSION['BASimgcharstr'] does not have at least the same number of
// characters as $BASnumimgchars OR $_POST['BASentryCode'] does not match
// we regenerate the character for the image and save string in session
//  ELSE - life is good we can kick of function for successful posting
// that will probably send email to secret address, kill session if okay
// and redirect to completed page or whatever. 
//
// Because it is so hard to tell upper from lower in many fonts,
// make all input lowercase to compare, else pick easy to read fonts
// (its a compromise).  use config.php variable $BAS_evalcase to see what to do
$BAS_EnteredCode = $_POST["BASentryCode"];
$BAS_RandomCode = $_SESSION["BASimgcharstr"];
// comment out the next to lines if you want to evaluate case of characters
// By default, "", will check not case sensitive on letters unless this is set to yes
// experience shows that it can be frequently difficult to distinguish upper from lower 
// case with fonts that don't ocr well.
$BAS_EnteredCode = strtolower($BAS_EnteredCode);
$BAS_RandomCode = strtolower($BAS_RandomCode);
//
if ( ( strlen($BAS_RandomCode) == $BASnumimgchars ) && ( $BAS_EnteredCode == $BAS_RandomCode ) && ( $BAS_RandomCode != "" ) ){
	// successfull so do the action, like email or a function in config.php
	$aphpdate = date("YmdHis");
	$mailHeaders = "From: $BAS_fromemail\n";
	$mailTo = $BAS_secretemail ;
	$mailSubject = "BAS Form submitted $aphpdate";
	$mailBody = "The following was submitted in the BAS form: \n \n";
	if (gettype($_POST)=="array"){
		reset($_POST);
		while ( list($key, $value) = each($_POST)) {
			$mailBody .= "$key=> 	$value \n\n"; 
		}
	}
	$mailBody .= " \n-------------------------------------------- \n \n";
	$mailBody .= "The following was gathered from environmental variables: \n";
	$mailBody .= "php generated date = $aphpdate \n";
	if (gettype($_SERVER)=="array"){
		reset($_SERVER);
		while ( list($key, $value) = each($_SERVER)) {
			$mailBody .= "$key=>  $value\n\n"; 
		}
	}
	mail($mailTo, $mailSubject, $mailBody, $mailHeaders); 
	// We don't need to display this page so we can destroy this session and redirect if want


	session_destroy();
	// No headers should have been sent, send the one for successful match, else we got problems
	if (!headers_sent()) {
   	header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".$MatchSendToRelativeURL);  	
   	exit;
   	} else {
   	print("<h1>code entry matched, but problem, could not send header for new page, already header?</h1></body></html>\n");
   exit;}
} else {
	$BAStmpstr = "";
	for ($i = 0; $i < $BASnumimgchars; $i++) {$BAStmpstr .= GetRandomChar();}
	session_unregister("BASimgcharstr");		
	$BASimgcharstr = $BAStmpstr;
	session_register("BASimgcharstr");		
	session_write_close();
}
</script>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
</head>
<body>
<table width="480" border="2" cellspacing="3" cellpadding="10" bgcolor="#FFFFCC">
  <tr>
    <td>
      <p align="justify"><font size="3">The following image has random alphabet or numerical
      characters. To verify that the submitted entries are not automated we ask 
      that you please type the characters you see in the image
      into the appropriate field below.&nbsp; If the characters are unclear, you
      can use the &quot;reload&quot; or &quot;refresh&quot; browser feature to
      retrieve this page
      with a new image.</font></p>
      <p align="center"><font size="2">
      <img src="./generateimage.php" border="2">
      </font></p>
      
      <form action="<script language="php">print($PHP_SELF);</script>" method="POST" name="BASform" target="_self" id="BASform">
        <p align="center"> 
          <input name="BASentryCode" type="text" id="BASentryCode" size="16">
        <br>
          <b><font color="#F40707" size="3">Enter the characters in the image
          above.</font>
 <font size="2" color="#F40707"><br>
 refresh or submit for a different image,&nbsp;<br>
 if submitted incorrectly you can try again.</font>
          </b>
        </p>
        <p> From:<br>
        <input type="text" name="BASentryname" size="58" <script language="php">if($_POST['BASentryname']){print("value='".$_POST['BASentryname']."'");}</script>>
        </p>
        <p> Email:<br>
        <input type="text" name="BASentryemail" size="48" <script language="php">if($_POST['BASentryemail']){print("value='".$_POST['BASentryemail']."'");}</script>>
        </p>
        <p> Telephone:<br>
        <input type="text" name="BASentryphone" size="28" <script language="php">if($_POST['BASentryphone']){print("value='".$_POST['BASentryphone']."'");}</script>>       
        </p>
        <p> Message:<br>
        <textarea rows="6" name="BASentrymessage" cols="50"><script language="php">if($_POST['BASentrymessage']){print($_POST['BASentrymessage']);}</script></textarea>
        </p>
        <p align="center">
          <input type="submit" name="Submit" value="SUBMIT">&nbsp;&nbsp; <input type="reset" value="RESET" name="reset">
        </p>
      </form>
      
      <p><i><b><font size="1">Why do I need to type characters from a picture to
      submit information?<br>
      </font></b><font size="1"><b>&nbsp;</b>Unfortunately security measures often
      sacrifice convenience. This request was implemented because spammers and attackers
      can and do&nbsp; use automated programs that abuse services. Typing the characters from
      the image into the form field verifies that a person—not an automated program—submitting the information. In most cases,
      automated programs cannot recognize the
      characters in the image. </font></i></p>
      
      <p>
    </td>
  </tr>
</table>
</body>
</html>
