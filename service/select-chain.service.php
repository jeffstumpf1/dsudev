<?php 
	/* Load chain, Used in Ajax call

	   select-chain.service.php
	   /service/select-chain.service.php?part_number=DA525VXG
	   
			{
				"chain_id": "28",
				"part_number": "DA525VXG",
				"category_id": "CH",
				"product_brand_id": "*",
				"clip_id": "*"
			}

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
	$chain = new Chain($debug, $db);
	
	// queryString
	$search	= $request->getParam('part_number');

	$row = $chain->GetChainByPartNumber($search);
	
	$json = $utilityDB->BuildJSONKeyValue($row,"chain_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"part_number");
	$json .= $utilityDB->BuildJSONKeyValue($row,"category_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"product_brand_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"clip_id");

	$json = substr($json, 0, $json.strlen($json)-2);
	$json = "{" .$json. "}";	
	
	echo $json;
?>