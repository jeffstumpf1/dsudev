<?php
/** Save Customer Notes, Ajax Call 
	Passed the form data to the Customer Class
**/
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
	$order = new Order($debug, $db);
	$request  = new Request;
	
	// Get Query Parameters
	$order_number = $request->getParam('order_number');
	$notes = $request->GetParam('special_instructions');
	
	$order->SaveNotes($order_number , $notes);
?>