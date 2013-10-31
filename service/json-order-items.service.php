<?php 
	/* Load Order Item, Used in Ajax call

	   
	   /service/select-order-item.service.php
	   
	
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
	$search	= $request->getParam('order_item_id');

	$row = $order->GetOrderItem($search);
	
	$json = $utilityDB->BuildJSONKeyValue($row,"order_item_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"order_number");
	$json .= $utilityDB->BuildJSONKeyValue($row,"discount");
	$json .= $utilityDB->BuildJSONKeyValue($row,"category_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"part_number");
	$json .= $utilityDB->BuildJSONKeyValue($row,"frontSprocket_part_number");
	$json .= $utilityDB->BuildJSONKeyValue($row,"rearSprocket_part_number");
	$json .= $utilityDB->BuildJSONKeyValue($row,"carrier_part_number");
	$json .= $utilityDB->BuildJSONKeyValue($row,"description");
	$json .= $utilityDB->BuildJSONKeyValue($row,"application");
	$json .= $utilityDB->BuildJSONKeyValue($row,"chain_length");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"chain_part_number");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"chain_orig_msrp");
	$json .= $utilityDB->BuildJSONKeyValue($row,"msrp");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"qty");		
	$json .= $utilityDB->BuildJSONKeyValue($row,"bo_qty");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"discount_price");
	$json .= $utilityDB->BuildJSONKeyValue($row,"unit_price");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"total");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"pitch_id");
	$json = substr($json, 0, $json.strlen($json)-2);
	$json = "{" .$json. "}";	
	
	echo $json;
?>