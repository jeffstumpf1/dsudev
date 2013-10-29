<?php
/*
 delete-part.service.php
 
 /service/delete-part.service.php?part_number=DA520ZVMXN&cat=CH
*/
	$debug = 'Off';
	require_once '../db/global.inc.php';
	
 	// Start logging
	include '../log4php/Logger.php';
	Logger::configure('../logconfig.xml');
	$log = Logger::getLogger('myLogger');
	 spl_autoload_register(function ($class) {
		include '../classes/' . $class . '.class.php';
	 });   
	    
   	// Create Object Customer and Request
	$constants = new Constants;
	$part = new Part($debug, $db);
	$request = new Request;

	// Querystring
	$part_number = $request->getParam('part_number');
	$cat = $request->getParam('cat');
	$cnt = $part->test('test');
	$cnt = $part->DeletePart($cat, $part_number);
	

?>
