<?php

	$debug = 'On';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
	$part = new Part($debug, $db);
	$part->test('it works');
	$cnt = $part->DeletePart('CH', $part);
?>