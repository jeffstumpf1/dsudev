<?php 
	/* Load Customers , Used in Ajax call
	   auto-customer.service.php
	   
	   /service/auto-customer.service.php?term=kaw
	*/
	$debug = 'Off';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
	$request = new Request;
	$customer = new Customer($debug, $db);
	
	$search= $request->getParam('term');
	
	echo $customer->CustomerAutoComplete($search);
?>