<?php
require_once 'config.php';
require_once 'error_handler_xml.php';
require_once 'authentication.php';
require_once 'database.php';
require_once 'report_document_class.php';
require_once 'report_manager_class.php';

$err_handler = new ErrorHandlerXml ();
$auth = new Authentication ();

if ($auth->Authorize ()) {
	$file = new ReportManager ( 'report_data.xml' );
	$file->Report ();
} else {
	$report = new ReportDocument ();
	$report->Error ( 'NOT_AUTHORIZED' );
}
