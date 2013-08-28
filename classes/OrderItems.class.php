<?php
/*
 Order Line Items
 orderItems.class.php
*/
class OrderItems {
	private $debug='Off';
	private $db;
	
	var $part_number='';
	var $part_application='';
	var $part_pitch='';
	var $msrp=0;
	var $net_price=0;
	var $discount_percent=0;
	var $line_amount=0;

	
	public function __construct($debug, $db)  
    {  
    	$this->debug = $debug;
    	$this->db = $db;
    	if($this->debug=='On') {
        	echo 'The class "', __CLASS__, '" was initiated!<br />';  
        }
    }  

}
?>