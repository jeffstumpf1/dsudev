<?php
/*
 
 /service/delete-order-item.service.php?order_id=x
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
	$order_id = $request->getParam('order_id');

	$cnt = $order->DeleteOrderItem($order_id);
	

?>
