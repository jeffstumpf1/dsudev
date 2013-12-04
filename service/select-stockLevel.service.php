<?php 
	/* Load Master Part, Used in Ajax call

	   select-stockLevel.service.php
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
	$utilityDB = new UtilityDB($debug, $db);
	$request = new Request;
	$part = new Part($debug, $db);
	
	// queryString
	$search	= $request->getParam('part_number');

	$row = $part->GetMasterPartByPartNumber($search);
	
	echo $row["stock_level"];

?>