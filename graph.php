<?php
require_once 'config.php';
require_once 'error_handler.php';
require_once 'authentication.php';
require_once 'database.php';

$id = ( int ) preg_replace ( '/[^0-9]/i', '', trim ( $_GET ['host_id'] ) );
$url = "{$url_path}graph_view.php?action=preview&host_id={$id}";

if ($allow_autologin !== true) {
	header ( "Location: {$url}" );
	exit ();
}

$err_handler = new ErrorHandler ();
$auth = new Authentication ();

if ($auth->Authorize ( true )) {
	header ( "Location: {$url}" );
} else {
	die ( 'Access denied' );
}

