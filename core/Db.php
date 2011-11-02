<?php

/**
 * MySQL database wrapper
 * 
 * @version 1.1
 */

class Db {
		
	var $connect;
	var $debug = false;
	static $instance = array();
	
	function Db($host, $login, $pass, $db_name, $codepage = 'utf8'){	
		$this->connect = mysql_connect($host, $login, $pass) or $this->error();								
		mysql_select_db($db_name, $this->connect) or $this->error();		
		$this->query('SET NAMES utf8');
	}
	
	/**
	 * This work with MySQL after 4.0 version
	 */
	function query_count($query, &$count){		
		if(strpos($query, 'SQL_CALC_FOUND_ROWS') == 0){	
			$query = str_replace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS ', $query);
		}		
		$result = $this->query($query);
		$res = $this->query('SELECT FOUND_ROWS();');
		$tmp = $this->fetch($res, MYSQL_BOTH);
		$count = $tmp[0];		
		return $result;
	}
	
	function query($query){		
		if($this->debug) {
			echo "<p>$query</p>";
		}
		$result = mysql_query($query, $this->connect) or $this->error($query);		
		return $result;
	}

	function query_row($query, $type = MYSQL_ASSOC){
		$result = $this->query($query);
		if ($result && $this->rec_count($result)>0) {
		    return $this->fetch($result, $type);
		} else {
			return false;
		}			
	}
	
	function save($table, $records) {				
		$fields = array();
		$values = array();
		foreach ($records as $key => $value) {			
			$fields[] = $key;			
			if(in_array(strtoupper($value), array('NOW()'))) { // check MySQL functions
				$values[] = $value;
			} else {
				$values[] = '"' . addslashes($value) . '"';
			}
		}
		$this->query('INSERT INTO `' . $table . '` (' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ')');
	}
	
	function last_id(){
		return mysql_insert_id();
	}

	function rec_count($result){
		return mysql_num_rows($result);
	}

	function fetch($result, $type = MYSQL_ASSOC){
		return mysql_fetch_array($result, $type);
	}
	
	function get_tables(){
		return mysql_list_dbs($this->connect);
	}
	
	function list_fields($tableName){
		$fields = mysql_list_fields($this->db_name, $tableName, $this->connect);
		$columns = mysql_num_fields($fields);
		$f = array();
		for ($i = 0; $i < $columns; $i++) {
		    array_push($f, mysql_field_name($fields, $i));
		}
		return $f;
	}
	
	function error($query = '')  {
		var_dump($query);
	
		trigger_error(
			mysql_error() . ' in "' . $query . '"', E_USER_ERROR
		);
	}
	
}

?>