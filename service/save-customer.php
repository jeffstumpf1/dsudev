<?php
/** Save Customer Information, Ajax Call 
	Passed the form data to the Customer Class
**/
	$debug="On";
	
    require_once '../db/global.inc.php';
    require_once '../classes/clsUtility.php';
    require_once '../classes/clsCustomer.php';
	    
	$customer = new Customer();
	$customer->SetDebug($debug);
	
	
	$sql='';
	
	if(isset($_POST['customer_number'])) {
		$customer_number = (get_magic_quotes_gpc()) ? $_POST['customer_number'] : addslashes($_POST['customer_number']);
	}
	
	$customer->UpdateCustomer( $db, $_POST['frm'] , 'E' );
?>