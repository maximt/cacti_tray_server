<?php

class ReportDocument {
	
	private $_fileName;
	private $_fields = array (
	'description', 
	'status', 
	'status_event_count', 
	'status_fail_date', 
	'status_rec_date', 
	'status_last_error', 
	'min_time', 
	'max_time', 
	'cur_time', 
	'avg_time', 
	'availability',
	'notes' );
	
	public function __construct($filename) {
		$this->_fileName = $filename;
	}
	
	public function BuildReport() {
		$hosts = Database::getInstance ()->getHosts ( $this->_fields );
		
		$this->WriteReport ( 'ERROR_NO', $hosts );
		
		//output
		header ( 'Content-type: text/xml' );
		readfile ( $this->_fileName );
	}
	
	public function CachedReport() {
		header ( 'Content-type: text/xml' );
		readfile ( $this->_fileName );
	}
	
	public function Error($message) {
		$text = $this->GenerateReport ( $message, NULL );
		
		//output
		header ( 'Content-type: text/xml' );
		echo $text;
	}
	
	private function WriteReport($error_status, $hosts) {
		
		$file = fopen ( $this->_fileName, 'w+' );
		
		if ($file === false)
			throw new Exception ( 'ERROR_CANNOT_OPEN_CACHE_FILE' );
		
		$text = $this->GenerateReport ( $error_status, $hosts );
		
		fputs ( $file, $text );
		
		fclose ( $file );
	}
	
	private function GenerateReport($error_status, $hosts) {
		$text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		
		$text .= "<report>\n";
		$text .= "\t<error>{$error_status}</error>\n";
		$text .= "\t<hosts>\n";
		
		if (! empty ( $hosts )) {
			foreach ( $hosts as $host ) {
				$text .= "\t\t<host>\n";
				
				foreach ( $host as $name => $value ) {
					$text .= "\t\t\t<{$name}>{$value}</{$name}>\n";
				}
				
				$text .= "\t\t</host>\n";
			}
		}
		
		$text .= "\t</hosts>\n";
		$text .= "</report>\n";
		
		return $text;
	}

}