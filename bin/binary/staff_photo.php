<?php
define( '_VALID_SSTARS_', 1 );
require_once "../../config.php";
require_once($dr."classes/user/user_info.php");

$user_id=DataEscape($_GET['user_id']);
$ui=new UserInfo($user_id);
$photograph=$ui->Photograph();

if (!EMPTY($photograph)) {
	header('Content-Type: image/jpeg');
	echo $photograph;
}
else {
	 $filename='../../images/nuvola/48x48/actions/edit.png';
   header('Content-type: image/png');
   header('Content-transfer-encoding: binary');
   //header('Content-length: '.filesize($filename));
   readfile($filename);
	//echo "<img src='".$wb."images/nuvola/48x48/actions/edit.png'>\n";
}
?>