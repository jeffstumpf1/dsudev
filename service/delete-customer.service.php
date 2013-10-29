<?php
/*
 /service/delete-customer.service.php?customer_number=x
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
	$customer = new Customer($debug, $db);
	$request = new Request;

	// Querystring
	$custId = $request->getParam('customer_id');
	$cnt = $customer->DeleteCustomer($custId);

?>
