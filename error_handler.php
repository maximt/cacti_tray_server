<?php

class ErrorHandler {
	
	function __construct() {
		@set_exception_handler ( array ($this, 'handler' ) );
	}
	
	public function handler($ex) //sexy handler
	{
		die ( $ex->getMessage () );
	}
}