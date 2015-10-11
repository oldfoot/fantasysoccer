<?php
class MySQLFunctions {

	var $hostname;// HOSTNAME THAT THE OBJECT SHOULD CONNECT TO
  var $username;// USERNAME THAT THE OBJECT SHOULD USE
  var $password;// PASSWORD THAT THE OBJECT SHOULD USE
  var $database;// DATABASE THAT THE OBJECT SHOULD USE
  var $query_num;// COUNTS THE TOTAL QUERIES THAT THE OBJECT HAS DONE. SOME BBS DO THIS. MIGHT BE OF USE FOR OPTIMIZATION

	function set_cred($hostname,$database,$username,$password) { // A METHOD TO SET THE CREDENTIALS TO CONNECT TO THE DATABASE
		$this->hostname=$hostname;
		$this->database=$database;
		$this->username=$username;
		$this->password=$password;
	}
	function db_connect() { // DATABASE CONNECTION
		$result = @mysql_connect($this->hostname, $this->username, $this->password) or die ('Connection to database failed.'); // DATABASE CONNECTION
		if (!$result) {
			echo 'Connection to database server at: '.$this->hostname.' failed.';
		 	return false;
		}
		else {
			mysql_select_db($this->database); // SELECT THE DATABASE
			mysql_query("set autocommit=1"); // RUN IN AUTOCOMMIT MODE FOR INNODB TABLES
			return $result;
		}
	}
	function db_pconnect() { // PERSISTENT CONNECTION
		$result = mysql_pconnect($this->hostname, $this->username, $this->password);

		if (!$result) {
			echo 'Connection to database server at: '.$this->hostname.' failed.';
			return false;
		}
		return $result;
	}
	function Query($query,$query_no="") { // THE METHOD TO EXECUTE QUERIES
  	//$result = mysql_query($query) or die("Query failed:	$query<br><br>".mysql_error());
  	$result = mysql_query($query) or die(ShowSQLError($query_no,$query));
  	return $result;
  }
  function FetchArray($result) { // A METHOD TO RETURN THE RESULT AS AN ARRAY
  	return mysql_fetch_array($result);
  }
  function FetchAssoc($result) { // AN ALTERNATIVE METHOD TO RETURN AS AN ASSOCIATIVE ARRAY
  	return mysql_fetch_assoc($result);
  }
  function FetchRow($result) { // AN ALTERNATIVE METHOD TO RETURN ROWS
    $query = mysql_fetch_row($result);
    return $result;
  }
  function ReturnQueryNum() { // A METHOD TO RETURN THE QUERY NUMBER
    return $this->query_num;
  }
  function NumRows($result) { // A METHOD TO RETURN THE NUMBER OF ROWS IN A RESULT
  	return mysql_num_rows($result);
  }
  function AffectedRows() { // A METHOD TO DETERMINE HOW MANY ROWS WERE AFFECTED BY THE QUERY
  	return mysql_affected_rows();
  }
  function LastInsertID() { // A METHOD TO OBTAIN THE LAST INSERTED AUTOINCREMENT ID
  	return mysql_insert_id();
  }
  function StartTransaction() { // A METHOD TO START A TRANSACTION
  	mysql_query("set autocommit=0");
  }
  function Commit() { // COMMIT
  	mysql_query("commit");
  }
  function Rollback() { // ROLLBACK
  	mysql_query("rollback");
  }
}

function ShowSQLError($sql_id,$query="") {
	echo "An error has occured. Report being generated now...<br>";

	echo "Error: ".$sql_id."<br>";
	echo "This is the SQL error:<p>";
	echo mysql_error()."<p>";
	echo "This is the SQL:<p>";
	echo $query."<br>";

	//echo $data."<br>";
	$db=$GLOBALS['db'];
	$sql="INSERT INTO error_sql_data (sql_id, output) VALUES ('".EscapeData($sql_id)."','".EscapeData(mysql_error())."')";
	//echo $sql."<br>";
	//$db->query($sql);
	echo "Report generated. Please go back and continue. The problem will be resolved soon.<br>";
	die();
}
?>