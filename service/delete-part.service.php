<?php
/*
 delete-part.service.php
 
 /service/delete-part.service.php?part_number=DA520ZVMXN&cat=CH
*/
	$debug = 'On';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
	$part = new Part($debug, $db);
	$request = new Request;

	// Querystring
	$part_number = $request->getParam('part_number');
	$cat = $request->getParam('cat');
	$cnt = $part->test('test');
	$cnt = $part->DeletePart($cat, $part_number);
	

?>
