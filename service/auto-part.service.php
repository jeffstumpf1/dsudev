<?php 
	/* Load chain chart based on pitch , Used in Ajax call

	   auto-part.service.php
	   
	   /service/auto-sprocket.service.php?term=21&pitch=520&cat=FS or RS
	*/
	$debug = 'Off';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
	$request = new Request;
	$part = new Part($debug, $db);
	
	// queryString
	$search	= $request->getParam('term');
	
	echo $part->MasterPartAutoComplete($search);

?>