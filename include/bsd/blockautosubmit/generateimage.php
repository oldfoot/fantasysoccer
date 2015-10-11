<script language="php">
// LICENSE NOTE,  This software is dual licensed using BSD-Style and LGPL. Where there is any discrepancy, the BSD-Style license will take precedence.
// Review the relative file ./license.txt for details.  The intention is that these works are available for all
// and may be profited from but not restricted in use.
// For most recent see http://www.cocoavillagepublishing.com/development/tools/php/scripts/
//
// Retrieve the character string to impose over the image.
session_start();
// 
// include a common file with variables and functions
include("config.php");
// 
if ($BASnumimgchars < 1 ){
	print("PROBLEM, no value for BASnumimgchars, maybe did not load config.php");
	exit;}
//
$BAS_RandomImgCode = $_SESSION["BASimgcharstr"];
//
// generate an image output, at end will send it.
// NOTE, older versions of gd had limitations so a lot of neater php gd functions
// cannot be used and work with platforms running older versions of gd, example only 8bit colors...
//
// CHECK MODE, if BAS_mode="test" then need bigger image to display comments
if ($BAS_mode=="test"){
  // Create the image higher to allow comments
  $BASimage = imagecreate((10 + $BASnumimgchars*50),(72 + $BASnumimgchars*30));
  } else { 
  $BASimage = imagecreate((10 + $BASnumimgchars*50), 96);
  }
//
// Allocate some colors (try to stick to 256 color palete so can work with older versions of gd)
//
// first color may be used by default for background?
$BASimgcolor_bkg = imagecolorallocate($BASimage, 240, 240, 240);
$BASimgcolor_black = imagecolorallocate($BASimage, 0, 0, 0);
$BASimgcolor_white = imagecolorallocate($BASimage, 255, 255, 255);
$BASimgcolor_font = imagecolorallocate($BASimage, 40, 40, 40);
$BASimgcolor_grey = imagecolorallocate($BASimage, 200, 200, 200);
//
// Flood Fill our image - but may not matter, may do first imagecolorallocate anyways
imagefill($BASimage, 0, 0, $BASimgcolor_bkg);
//
// function to verify file names end with ttf we will use for truetypefontsources
function CheckExt($filename, $ext) {
         $passed = FALSE;
         $testExt = "\.".$ext."$";
         if (eregi($testExt, $filename)) {
            $passed = TRUE;
            }
         return $passed;
}
//
//  We can optionally put some random noise or arcs into the picture to messup OCR:
if ($BASaddimgnoise == "yes"){ 
	$num1arcs = ($BASnumimgchars + 3) ;
	for ($i=1; $i<=$num1arcs; $i++) {
		imagearc($BASimage, -15+$i*30+rand(-20,20), 40+rand(-20,20), 96+rand(-20,20), 96+rand(-20,20), 0, 360, $BASimgcolor_font);
		}
	$num2arcs = ($BASnumimgchars + 3);
	for ($i=1; $i<=$num2arcs; $i++) {
		imagearc($BASimage, -15+$i*30+rand(-20,20), 40+rand(-20,20), 96+rand(-20,20), 96+rand(-20,20), 0, 360, $BASimgcolor_grey);
		}
}
//
// Probably would be faster to change scripting to use pick from a 
// permanent list of ttf fonts, especially for heavy usage, but to
// make it easy, we have a routine to look in a sub folder for *.ttf
// files and make array to randomly pick from, this way can put *.ttf
// files into the sub folder "./ttf/" and let php do the grunt work:
//
// Make an array with ttf file names
$ttfdirectory = dirname($_SERVER["PATH_TRANSLATED"]) . "/ttf/" ;
$TTFCHOICES=array();
if (is_dir($ttfdirectory)){
 if($dir_handle = opendir($ttfdirectory)){
   while($file = readdir($dir_handle)){
     if($file !== "." && $file !== ".." && CheckExt($file,"ttf")){
     $TTFCHOICES[] = $file;
     }
   }
  }
  closedir($dir_handle);
} else { 
echo " problem, no ttf directory "; 
exit;
}
//
// really should verify array has enough ttf files to be used...
 $numberttfchoices = count($TTFCHOICES);  // bad news if zero!
 if ($numberttfchoices < 1){
 echo "warning - no ttf source \n";
 exit; }

// randomly pick the $BASnumimgchars (4 in tests) fonts and put into array including the full path
// Create a random number for font angle between -30 and +30
$fontsource = array();
$fontangle = array();
srand ((float) microtime() * 10000000);
$rand_keys = array_rand ($TTFCHOICES, $BASnumimgchars);
	for ($i = 0; $i < $BASnumimgchars; $i++) {
       	$fontsource[] = $ttfdirectory . $TTFCHOICES[$rand_keys[$i]];
       	$fontangle[] = rand(-30,30);
       	}
// we now write the random chars in our picture
	for ($i = 0; $i < $BASnumimgchars; $i++) {
	imagettftext($BASimage, 46, $fontangle[$i], 15+50*$i, 56+rand(-10,+10), $BASimgcolor_font, $fontsource[$i], $BAS_RandomImgCode[$i]);
//
// FOR testing so we know the fonts, and what the character was suppose to be:
if ($BAS_mode=="test"){
  imagestring($BASimage, 10, 5, 100+20*$i, $BAS_RandomImgCode[$i] . "   " . $TTFCHOICES[$rand_keys[$i]], $BASimgcolor_font);
 	}
}
//
//Now we send the picture to the Browser
header("Content-type: image/jpeg");
imagejpeg($BASimage);
//
// see also comments on http://us4.php.net/manual/en/function.imagestring.php for elipses and bkgrond.
//
</script>
