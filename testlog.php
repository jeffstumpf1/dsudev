<?php 
require_once 'log4php/Logger.php';
Logger::configure('logConfig.xml');

// get logger by name, if this name isn't listed 
// as a logger name in the configuration 
// file you will get the root level logger
$logger = Logger::getLogger('DSU');
$logger->info("beginning log4php example");
try {
    throw new Exception("log4php example error");
}
catch(Exception $e) {
    $logger->error($e->getMessage());
}

?>