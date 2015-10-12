<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function SessionOpen($save_path,$session_name) {
	SessionCleanUp(); /* REMOVES ALL EXPIRED SESSIONS*/
}

function SessionClose() {
	//SessionCleanUp(); /* REMOVES ALL EXPIRED SESSIONS*/
}

function SessionCleanUp() {
	//$sql="DELETE FROM ".$GLOBALS['database_ref']."sessions WHERE session_time < '".$GLOBALS['session_lifetime']."'";
	//$GLOBALS['db']->Query($sql);
}

function SessionRead($session_id) {
	$db=$GLOBALS['db'];
  $query="SELECT session_data
   				FROM ".$GLOBALS['database_ref']."sessions
   				WHERE session_id='".$session_id."'
   				";
  //echo $query;
  $result = $GLOBALS['db']->Query($query);
  if ($GLOBALS['db']->NumRows($result) > 0) {
  	while($row = $GLOBALS['db']->FetchArray($result)) {
  		return $row['session_data'];
  	}
  }
  else {
  	$query="INSERT INTO ".$GLOBALS['database_ref']."sessions (session_id, session_time, session_data)
            VALUES (
            '".$session_id."',
            sysdate(),
            ''
            )";
    $GLOBALS['db']->Query($query);
    return "";
  }
}

function SessionWrite($session_id,$session_data) {

	$session_data=addslashes($session_data);
  $query="UPDATE ".$GLOBALS['database_ref']."sessions
  				SET session_data = '$session_data',
  				session_time = sysdate()
  				WHERE session_id = '".$session_id."'
  				";
  $GLOBALS['db']->Query($query);
  return True;
}

function SessionDestroy($session_id) {

	$query = "DELETE FROM ".$GLOBALS['database_ref']."sessions WHERE session_id = '".$session_id."'";
  $GLOBALS['db']->Query($query);
  return True;
}
?>