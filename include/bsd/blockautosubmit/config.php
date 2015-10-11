<script language="php">
// LICENSE NOTE,  This software is dual licensed using BSD-Style and LGPL. Where there is any discrepancy, the BSD-Style license will take precedence.
// Review the relative file ./license.txt for details.  The intention is that these works are available for all
// and may be profited from but not restricted in use.
// For most recent see http://www.cocoavillagepublishing.com/development/tools/php/scripts/
// NOTE - TO AVOID "Cannot send session cache limiter - headers already sent"
// try to avoid blank lines and tabs to minimize chance header starts premature by web output
// 
// Defining some settings with variables
//
// $BAS_mode="";  blank means nominal, if "test" then we evoke more scripts
//$BAS_mode="test" ;
$BAS_mode="";
//
// Important, number of characters in image, suggest 4
$BASnumimgchars = 4 ;  
//
// set $BASaddimgnoise = "yes" for arcs and noise to be added to image to further confuse ocr
$BASaddimgnoise = "no";
//$BASaddimgnoise = "yes" ;
//
// IF entered code matches random generated string, after action will redirect page
// to this location using php header function.  Scripting code so header will use
// relative location per notes at http://us2.php.net/manual/en/function.header.php
$MatchSendToRelativeURL="good_submission.html" ;
//
// Action for good match, for now the function sends an email, which should be
// a secret or a priority like email to pager of fax....
$BAS_secretemail="blockautosubmit@webengr.com" ;
//
// Fromemail for notificationsof successful submissions, 
$BAS_fromemail = "www@".$_SERVER['HTTP_HOST'] ;
//
//
//
//
//******************************************//
//  BELOW YOU PROBABLY WILL NOT BE CHANGING //
//******************************************//
//
// declare some functions to be used in places 
// function to return random characters for image
function GetRandomChar() {
	// Seed with microseconds since last "whole" second
	mt_srand((double)microtime()*1000000);
	// Use random number 1-3, if 1, we generate a number 0-9 (ascii 48 to 57), 
	// if it was 2, we generate an uppercase character (ascii 65 to 70),
	// if it was 3, we generate a lowercase character (ascii 97 to 122),
	switch (mt_rand(1,3)) {
	case 1:
	        $BAErandchar = mt_rand(48, 57);
	        break;
	case 2:
	        $BAErandchar = mt_rand(65, 90);
	        break;
	case 3:
	 	    $BAErandchar = mt_rand(97, 122); 
	        break;
		}	
	return chr($BAErandchar);
	}
//
//
//
</script>
