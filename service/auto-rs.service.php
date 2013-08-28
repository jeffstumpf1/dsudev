<?php 
	/* Load chain chart based on pitch , Used in Ajax call

	   auto-customer.service.php
	   
	   /service/auto-sprocket.service.php?term=kaw&pitch=520&cat='FS' or 'RS'
	*/
	$debug = 'Off';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
	$request = new Request;
	$sprocket = new Sprocket($debug, $db);
	
	// queryString
	$picth  = $request->getParam('pitch');
	$cat = $request->getParam('cat');
	$search= $request->getParam('term');
	
	echo $sprocket->CustomerAutoComplete($pitch, $cat, $search);

?>