<?php
class session
{

    /**
     * a database connection resource
     * @var resource
     */
    private $_sess_db;

    /**
     * Open the session
     * @return bool
     */
    public function open() {
		
        if ($this->_sess_db = @mysql_connect($GLOBALS['mysql_hostname'],$GLOBALS['mysql_user'],$GLOBALS['mysql_password'])) {
            return mysql_select_db($GLOBALS['mysql_database'], $this->_sess_db) or die("Could not connect to mysql");
        }
        return false;

    }

    /**
     * Close the session
     * @return bool
     */
    public function close() {
        return @mysql_close($this->_sess_db);
    }

    /**
     * Read the session
     * @param int session id
     * @return string string of the sessoin
     */
    public function read($id) {

        $id = @mysql_real_escape_string($id);
        $sql = sprintf("SELECT `SessionData` FROM `".$GLOBALS['mysql_table_prefix']."core_sessions1` " .
                       "WHERE SessionID = '%s'", $id);
        //echo $sql;
		if ($result = @mysql_query($sql, $this->_sess_db)) {
            if (mysql_num_rows($result)) {
                $record = mysql_fetch_assoc($result);
                return $record['SessionData'];
            }
        }
        return '';

    }

    /**
     * Write the session
     * @param int session id
     * @param string data of the session
     */
    public function write($id, $data) {

        $sql = sprintf("REPLACE INTO `".$GLOBALS['mysql_table_prefix']."core_sessions1` VALUES('%s', '%s', sysdate())",
                       @mysql_real_escape_string($id),
                       @mysql_real_escape_string($data),
                       @mysql_real_escape_string(time()));
		//echo $sql;
        return @mysql_query($sql, $this->_sess_db);

    }

    /**
     * Destoroy the session
     * @param int session id
     * @return bool
     */
    public function destroy($id) {

        $sql = sprintf("DELETE FROM `".$GLOBALS['mysql_table_prefix']."core_sessions1` WHERE `SessionID` = '%s'", $id);
        return mysql_query($sql, $this->_sess_db);

}

    /**
     * Garbage Collector
     * @param int life time (sec.)
     * @return bool
     * @see session.gc_divisor      100
     * @see session.gc_maxlifetime 1440
     * @see session.gc_probability    1
     * @usage execution rate 1/100
     *        (session.gc_probability/session.gc_divisor)
     */
    public function gc($max) {

        $sql = sprintf("DELETE FROM `".$GLOBALS['mysql_table_prefix']."core_sessions1` WHERE `SessionTime` < '%s'",
                       mysql_real_escape_string(time() - $max));
        return mysql_query($sql, $this->_sess_db);

    }

}
?>