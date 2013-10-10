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
	//order_number: $orderNumber, cust_number: $customerNumber, po: $customerPO, order_date: $orderDate, freight: $orderShipping, tax_rate: $tax_rate
	$orderNumber = $request->GetParam('order_number');
	$customerNumber = $request->GetParam('cust_number');
	$customerPO = $request->GetParam('po');
	$orderDate = $request->GetParam('order_date');
	$orderShipping = $request->GetParam('freight');
	$taxRate = $request->GetParam('tax_rate');
	$order_status = $request->GetParam('status');
	$paymentTerms = $request->GetParam('payment_terms');

	if($debug=='On') {
		echo "=============";
		echo "order:" . $orderNumber . " ";
		echo "Cust:" . $customerNumber . "  ";
		echo "PO:" . $customerPO . "  ";
		echo "Odate:" . $orderDate . " ";
		echo "shipping:" . $orderShipping . " ";
		echo "tax:" . $taxRate . " ";
		echo "status:" . $order_status . " ";
		echo "payment:" . $paymentTerms . " ";
	}
	
	if($order_status == "NEW" ) {
		$num = $order->NewOrder($customerNumber, $taxRate, $status);	
	} else if ( $order_status == "OPEN") {
		$num = $order->SaveOrder($orderNumber, $customerNumber, $customerPO, $orderDate, $orderShipping, $taxRate, "OPEN", $paymentTerms);
	}
	
	echo $order->GetActiveOrderNumber();

?>