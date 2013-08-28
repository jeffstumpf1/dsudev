<?php
/** Save Customer Information, Ajax Call 
	Passed the form data to the Customer Class
**/
	$debug = 'On';
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
	
	$customer->UpdateCustomer($_POST['frm'] , 'E' );
?>