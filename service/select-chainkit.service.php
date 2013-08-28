<?php 
	/* Load chain kit based on id , Used in Ajax call

	   select-chainkit.service.php
	   
	   /service/select-chainkit.service.php?part_number=JEFFSTESTKIT909:ER-5
	   
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
	$kit = new Kit($debug, $db);
	
	// queryString
	$search	= $request->getParam('part_number');

	$row = $kit->GetChainKitByPartNumber($search);
	$json = $utilityDB->BuildJSONKeyValue($row,"chain_kit_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"part_number");
	$json .= $utilityDB->BuildJSONKeyValue($row,"category_id");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"product_brand_id");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"frontSprocket_part_number");
	$json .= $utilityDB->BuildJSONKeyValue($row,"rearSprocket_part_number");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"chain_length");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"ch_price");
	$json .= $utilityDB->BuildJSONKeyValue($row,"rs_price");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"fs_price");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"chain_part_number");	
	$json .= $utilityDB->BuildJSONKeyValue($row,"clip_id");
	$json .= $utilityDB->BuildJSONKeyValue($row,"rec_status");
	
	$json = substr($json, 0, $json.strlen($json)-2);
	$json = "{" .$json. "}";	
	//replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, ' ')
	echo $json;
?>