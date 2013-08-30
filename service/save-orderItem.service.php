<?php 
	/* Save Order, Used in Ajax call

	   /service/save-orderItem.service.php
	   

	*/
	
	$debug = 'Off';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
	$utilityDB = new UtilityDB($debug, $db);
	$request = new Request;
	$order = new Order($debug, $db);
	
	// queryString
	$mode = $request->getParam('mode');
	
	$order->UpdateOrderItem($_POST['frm'] , 'A' );

?>