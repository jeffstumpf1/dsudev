<?php 
	/* Load Master Part, Used in Ajax call

	   select-masterPart.service.php
	   /service/select-masterPart.service.php?part_number=20504R-14
	   
		[
			{
				"part_id": "331",
				"part_number": "20504R-14",
				"part_description": "SUPERLITE 530 PITCH CHROMOLY STEEL DRILLED FRONT SPROCKET - HONDA CBR 600F2/F3 '91-96",
				"part_application": "",
				"stock_level": "0",
				"category_id": "FS",
				"pitch_id": "530",
				"msrp": "31.95",
				"dealer_cost": "20.45",
				"import_cost": "0",
				"rec_status": "0"
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
	$part = new Part($debug, $db);
	
	// queryString
	$search	= $request->getParam('part_number');

	$row = $part->GetMasterPartByPartNumber($search);
	
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