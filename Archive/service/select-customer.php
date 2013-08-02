<?php 
	/* Load Customer Information , Used in Ajax call
	   select-customer.php
	*/
	$debug="Off";
	
    require_once '../db/global.inc.php';
    require_once '../classes/clsUtility.php';
    
	$customer_id='';
	    
	$utility = new Utility();
	$sql=''; $idx=0; $html='';
	
	if(isset($_GET['customer_number'])) {
		$customer_number = (get_magic_quotes_gpc()) ? $_GET['customer_number'] : addslashes($_GET['customer_number']);
	}
		
    // fetch data
	$sql = sprintf( "SELECT * FROM Customer WHERE customer_number = '%s'", $customer_number );
    $rs = $db->query( $sql); 
    $row = $rs->fetch();
	if($debug=="On") {
		echo $sql."<br>";
		echo $part."<br>";
	}
	
include '../includes/customer-form.php';
