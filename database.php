<?php

class Database {
	
	private static $_instance;
	private $_link;
	
	public static function getInstance() {
		if (! is_a ( self::$_instance, 'Database' )) {
			self::$_instance = new Database ();
		}
		return self::$_instance;
	}
	
	public function __construct() {
		global $database_port, $database_hostname, $database_username, $database_password, $database_default;
		
		$this->_link = mysqli_connect ( $database_hostname, $database_username, $database_password, $database_default, $database_port );
		
		if (empty ( $this->_link )) {
			throw new Exception ( 'ERROR_MYSQL_CONNECTION' );
		}
		
		mysqli_select_db ( $this->_link, $database_default );
	}
	
	public function __destruct() {
		if (! empty ( $this->_link ))
			mysqli_close ( $this->_link );
	}
	
	public function getHosts($fields) {
		$mysql_columns = '`' . implode ( '`, `', $fields ) . '`';
		
		$result = mysqli_query ( $this->_link, "SELECT `id`,`hostname`,{$mysql_columns} FROM `host`" );
		
		if (empty ( $result )) {
			throw new Exception ( 'ERROR_CANNOT_GET_HOST_INFO' );
		}
		
		$hosts = array ();
		
		while ( $row = mysqli_fetch_assoc ( $result ) ) {
			$hosts [] = $row;
		}
		
		mysqli_free_result ( $result );
		
		return $hosts;
	}
	
	public function getUser($username) {
		$username = trim ( $username );
		
		$result = mysqli_query ( $this->_link, "SELECT `id`, `username`, `password` FROM `user_auth` WHERE `username` like '{$username}'" );
		
		if (empty ( $result )) {
			throw new Exception ( 'ERROR_CANNOT_GET_USER_INFO' );
		}
		
		$user = mysqli_fetch_assoc ( $result );
		
		mysqli_free_result ( $result );
		
		return $user;
		;
	}
}
