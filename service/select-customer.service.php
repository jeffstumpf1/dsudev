<?php 
	/* Load Customer Information , Used in Ajax call
	   select-customer.service.php
	*/
	$debug = 'Off';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
	$customer = new Customer($debug, $db);
	$request  = new Request;
	$utility  = new Utility($debug);
	$utilityDB  = new UtilityDB($debug, $db);

	// Get Query Parameters
	$customer_number = $request->getParam('customer_number');
			
	// Get Info and Display
	$row = $customer->GetCustomer($customer_number);
	
	$customer->GetCustomer($customer_number);
		
include '../inc/customer-form.inc.php';
?>