<?php
/*
 
 /service/delete-order.service.php?order_number=x
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

	$cnt = $order->DeleteOrder($order_number);
	

?>
