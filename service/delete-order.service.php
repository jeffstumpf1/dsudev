<?php
/*
 
 /service/delete-order.service.php?order_number=x
*/
	$debug = 'On';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
	$order = new Order($debug, $db);
	$request = new Request;

	// Querystring
	$order_number = $request->getParam('order_number');

	$cnt = $order->DeleteOrder($order_number);
	

?>
