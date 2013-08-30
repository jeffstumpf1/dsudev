<?php 
	/* Save Order, Used in Ajax call

	   /service/save-order.service.php?order_number=20504R-14
	   

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
	//$order_status = $request->getParam('order_status');
	
	$order->UpdateOrder($_POST['frm'] , 'A' );
	
	echo $order->GetActiveOrderNumber();
	

?>