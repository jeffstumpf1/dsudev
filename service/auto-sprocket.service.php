<?php 
	/* Load chain chart based on pitch , Used in Ajax call

	   auto-sprocket.service.php
	   
	   /service/auto-sprocket.service.php?term=21&pitch=520&cat=FS or RS
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
	$request = new Request;
	$sprocket = new Sprocket($debug, $db);
	
	// queryString
	$pitch  = $request->getParam('pitch');
	$cat 	= $request->getParam('cat');
	$search	= $request->getParam('term');
	
	echo $sprocket->SprocketAutoComplete($cat, $pitch, $search);

?>