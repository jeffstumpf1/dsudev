<?php
/** Save Customer Information, Ajax Call 
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
	$customer = new Customer($debug, $db);
	$request  = new Request;
	$utility  = new Utility($debug);
	$utilityDB  = new UtilityDB($debug, $db);
	
	// Get Query Parameters
	$customer_number = $request->getParam('customer_number');
	
	$customer->UpdateCustomer($_POST['frm'] , 'E' );
?>