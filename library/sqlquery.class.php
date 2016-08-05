<?php 
class SQLQuery{
	protected $_dbHandle;
	protected $_result;
	/**建立数据库连接**/
	function connect($address,$account,$pwd,$dbname){
		$this->_dbHandle = @mysql_connect($address,$account,$pwd)
		if($this->_dbHandle != 0){
			if(mysql_select_db($dbname,$this->_dbHandle)){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	function disconnect(){
		if(@mysql_close($this->_dbHandle != 0){
			return 1;
		}else{
			return 0;
		}
	}
	function getNumRows(){
		return mysql_num_rows($this->_result);
	}
	function freeResult(){
		mysql_free_result($this->_result);
	}
	function getError(){
		return mysql_error($this->_dbHandle);
	}
}