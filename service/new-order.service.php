<?php 
	/* Save Order, Used in Ajax call

	   /service/new-order.service.php?order_number=20504R-14
	   

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
	$utilityDB = new UtilityDB($debug, $db);
	$request = new Request;
	$order = new Order($debug, $db);
	
	// queryString
	$search	= $request->getParam('on');
	$customer_number = $request->getParam('cn');
	$order_date = $request->getParam('dt');
	$order_total = $request->getParam('tot');
	$order_tax = $
	
	$json = $utilityDB->BuildJSONKeyValue($row,"part_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"part_number");
	$json .= $utilityDB->BuildJSONKeyValue($row,"part_description");
	$json .= $utilityDB->BuildJSONKeyValue($row,"part_application");
	$json .= $utilityDB->BuildJSONKeyValue($row,"stock_level");
	$json .= $utilityDB->BuildJSONKeyValue($row,"category_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"pitch_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"msrp");
	$json .= $utilityDB->BuildJSONKeyValue($row,"dealer_cost");
	$json .= $utilityDB->BuildJSONKeyValue($row,"import_cost");
	$json .= $utilityDB->BuildJSONKeyValue($row,"rec_status");
	

	$json = substr($json, 0, $json.strlen($json)-2);
	$json = "{" .$json. "}";	
	
	echo $json;
?>