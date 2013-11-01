<?php
/*
 /service/ship-order.service.php?order_id=x
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
	$order = new Order($debug, $db);
	$request = new Request;

	// Querystring
	$order_number = $request->getParam('order_number');
	$cnt = $order->ShipOrder($order_number);

	//if($cnt >= 1) {
		echo $order_number . " status changed to SHIPPED.";
	//} else
	//	echo $order_number . " failed, to change status.";
		
?>
