<?php

class ReportManager {
	
	private $_cacheTime = 60; 
	private $_fileName;
	
	public function __construct($filename) {
		$this->_fileName = $filename;
	}
	
	public function Report() {
		$report = new ReportDocument ( $this->_fileName );
		
		//if not exists - write report
		if (file_exists ( $this->_fileName )) {
			$file_modify_time = time () - filemtime ( $this->_fileName );
			
			if ($file_modify_time >= $this->_cacheTime) {
				//print
				$report->BuildReport ();
			} else {
				//from cache
				$report->CachedReport ();
			}
		} else {
			//print
			$report->BuildReport ();
		}
	
	}

}