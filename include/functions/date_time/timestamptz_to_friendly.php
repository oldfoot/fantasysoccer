<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_SSTARS_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $dr."include/functions/date_time/date_to_seconds.php";

function TimestampTZToFriendly($t) {
	ini_set("date.timezone","Asia/Kuala_Lumpur");
	//echo $t."<br>";
	$year  = substr($t, 0, 4);
	$month = substr($t, 5, 2);
	$day  = substr($t, 8, 2);
	$hour  = substr($t, 11, 2);
	$min  = substr($t, 14, 2);
	$sec  = substr($t, 17, 2);

	//echo $year."-".$month."-".$day." ".$hour.":".$min.":".$sec."<br>";
	//echo date("Y-m-d H:i:s")."<br>";
	/* RETURNS AN INTEGET WHICH IS A UNIX TIMESTAMP */
	$date_given=DateToSeconds($t);
	/* ADD THE TIMESTAMP TO THIS */
	$date_now=DateToSeconds(date("Y-m-d H:i:s"));
	//echo "Given:".$date_given."<br>";
	//echo "Now  :".$date_now."<br>";
	//echo time()."<br>";
	$difference=$date_now-$date_given;
	//echo "Differ:".$difference."<br>";
	if ($difference < 60) {
		//echo "Less than 1 minute ago";
		return "Less than 1 minute ago";
	}
	elseif ($difference < 3600 ) {
		//echo "Minutes ago";
		return FLOOR(($difference/60))." minutes ago";
	}
	elseif ($difference < 86400 ) {
		//echo "found";
		return FLOOR(($difference/3600))." hour/s ago";
		//echo $return_value;
		//." hour(s) and ".$min." mins ago";
	}
	else {
		return $year."-".$month."-".$day;
	}
}

?>