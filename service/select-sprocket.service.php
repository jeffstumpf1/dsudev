<?php 
	/* Load Sprocket, Used in Ajax call

	   select-sprocket.service.php
	   /service/select-sprocket.service.php?part_number=20504R-14
	   
		[
			{
				"sprocket_id": "12",
				"part_number": "20504R-14",
				"category_id": "FS",
				"product_brand_id": "SUPERLITE",
				"sprocket_size": ""
			}
		]	
	
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
	$sprocket = new Sprocket($debug, $db);
	
	// queryString
	$search	= $request->getParam('part_number');

	$row = $sprocket->GetSprocketByPartNumber($search);
	
	$json = $utilityDB->BuildJSONKeyValue($row,"sprocket_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"part_number");
	$json .= $utilityDB->BuildJSONKeyValue($row,"category_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"product_brand_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"sprocket_size");

	$json = substr($json, 0, $json.strlen($json)-2);
	$json = "{" .$json. "}";	
	
	echo $json;
?>