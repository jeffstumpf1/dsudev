<?php
/*
	Todo: Line order items
		: Calculate Subtotal
		: Calculate item cost
*/
define("PAD_WEB_NUMBER", 8);

class Order{

	// Recordset Object
	var $orderRow;
	var $subtotal;
	var $shipcost;
	var $ordertax;
	
	// Constants
	//constant NEWLINE = '<br/>';
	
	// Customer Order Information
	var $cust_id;
	var $cust_lastname;
	var $cust_firstname;
	var $cust_addr1;
	var $cust_addr2;
	var $cust_city;
	var $cust_st;
	var $cust_country;
	var $cust_phone;
	var $cust_email;
	
	// Shipping & Delivery Information
	var $delivery_firstname;
	var $delivery_lastname;
	var $delivery_addr1;
	var $delivery_addr2;
	var $delivery_city;
	var $delivery_postal;
	var $delivery_st;
	var $delivery_country;
	
	// Billing Information
	var $bill_firstname;
	var $bill_lastname;
	var $bill_addr1;
	var $bill_addr2;
	var $bill_city;
	var $bill_postal;
	var $bill_st;
	var $bill_country;

	// Payment Information
	var $paypal_email;
	var $paypal_selected;
	var $cc_type;
	var $cc_number;
	var $cc_expires;
	var $cc_securitycode;
	
	// General Order Information
	var $order_dateStarted;
	var $order_dateFinished;
	var $order_datePayment;
	var $order_status;
	var $order_promoCode;
	var $order_shippingMethod;
	var $order_placedWebsite;
	var $order_lastPageSelected;
	var $order_confirmationEmail;
	
	
/************* FUNCTIONS ***************/	

	function getPaymentMethod(){
		$lastDigit = substr($this->cc_number, -5);
		return $this->cc_type . " *".$lastDigit;
	}
	
	// Get Web Order Number
	function getWebOrder($orderNum){
		$len = (strlen($orderNum) - PAD_WEB_NUMBER)*-1;
		$webNo='';
		for($i=0; $i<$len; $i++){
			$webNo = $webNo.'0';
		}
		return 'W'.$webNo.$orderNum;
	}
	
	
/************* ORDER CALCULATIONS ********/
	
	// Calculate Order Sub Total
	function getOrderSubTotal($format){
		$this->subtotal = $this->util_formatNumber($this->subtotal,'0');
		return $this->util_formatNumber($this->subtotal,$format);
	}

	// Calculate Estimated Tax
	function getEstimatedTax($format){
		$tax = 0;
		if($this->bill_st == 'CA'){
			$tax = $this->getOrderSubtotal('0');
			$tax = ($tax * .0875);
		}
//		$this->ordertax = $tax;
		return $this->util_formatNumber($tax,$format);
	}

	// Calculate Order Total
	function getOrderTotal($format){
		$total = 0;
		$total = $this->subtotal +
				 $this->getShippingCost('0',$this->order_shippingMethod) +
				 $this->getEstimatedTax('0');
				 		
		return $this->util_formatNumber($total,$format);
	}
	
	
	/***************  ADDRESS ****************/
	
	function getBillingName(){
		return chop($this->bill_firstname)." ".chop($this->bill_lastname);
	}
	
	function getShippingName(){
		return chop($this->delivery_firstname)." ".chop($this->delivery_lastname);
	}


	// Address Billing
	function getAddress($type){
		$addr1='';
		$addr2='';
		$city='';
		$state='';
		$postal='';
		$country='';
		$displayAddress='';
		
		switch(strtoupper($type)){
			case "BILL":
				$addr1 = $this->bill_addr1;
				$addr2 = $this->bill_addr2;
				$city  = $this->bill_city;
				$state = $this->bill_st;
				$postal= $this->bill_postal;
				$country = $this->bill_country;
				break;
			case "SHIP":
				$addr1 = $this->delivery_addr1;
				$addr2 = $this->delivery_addr2;
				$city  = $this->delivery_city;
				$state = $this->delivery_st;
				$postal= $this->delivery_postal;
				$country = $this->delivery_country;	
				break;		
		}
		// Build final address
		$displayAddress = "";
		if(!empty($addr1)) $displayAddress .= $addr1. "<br/>";
		if(!empty($addr2)) $displayAddress .= $addr2. "<br/>";
		$displayAddress .= $city. ", ". $state. "  ". $postal. "<br/>". "Country: ". $country;
		
		return $displayAddress;
	}
	
	
	/*************  SHIPPING ****************/
	
	// Get Shipping Method
	function getShippingMethod(){
		switch($this->order_shippingMethod){
			case 1:
				return "Standard Shipping";
				break;
			case 2:
				return "2-Day Shipping";
				break;
			case 3:
				return "Next Day Shipping";
			default:
				return "Standard Shipping";
		}
	}
	
	// Get Shipping Costs
	function getShippingCost($format, $shipmethod=1){
		$cost = 0;
		switch ($shipmethod) {
			case 1:
				$cost = 12.5;
				break;
			case 2:
				$cost = 30;
				break;
			case 3:
				$cost = 65;
				break;
			default:
				$cost=12.5;
		}
		
		$this->shipcost = $cost;
		//echo "<h1>".$this->shipcost."</h1>";
		return $this->util_formatNumber($cost,$format);
	}
			
	/***********  PROMOTIONS **********************/
	function getPromoDescription($type){
		switch($type)
		{
			case 'LA':
			case 'AN':
			case 'HB':
				return "Show Special at 15% Discount";
				break;
			default:
				return "Not a valid Promotion Code";
		}
		
	}
	
		
	function getPromoDiscount($type){
		switch($type)
		{
			case 'LA':
			case 'AN':
			case 'HB':
				return 15;
				break;
			default:
				return 0;
		}
		
	}	
	// Utility 
	function util_formatNumber($num, $format){
		$retVal = 0;
		if($format == '$') {
			$retVal = '$'.number_format($num,2);//$this->
		}else 
			$retVal =  number_format($num,2);	
		
		return $retVal;
	}
	
	/*************************  INITIALIZE *********************************/
	function initorder($orderRow){
		
		//echo("initialized");
		$this->orderRow = $orderRow;
		
		// General Order Information
		$this->order_dateStarted		= trim($this->orderRow['order_date_started']);
		$this->order_dateFinished		= trim($this->orderRow['order_date_finished']);
		$this->order_datePayment		= trim($this->orderRow['order_date_payment']);
		$this->order_status				= trim($this->orderRow['order_status']);
		$this->order_promoCode			= trim($this->orderRow['order_promo_code']);
		$this->order_shippingMethod 	= trim($this->orderRow['order_shipping_method']);
		$this->order_placedWebsite		= $this->orderRow['order_website'];
		$this->order_lastPageSelected	= trim($this->orderRow['last_page']);
		$this->order_confirmationEmail	= trim($this->orderRow['confirmation_email']);
		
		// Customer Order Information
		$this->cust_id					= $this->orderRow['customers_id'];
		$this->cust_lastname			= trim($this->orderRow['customer_lastname']);
		$this->cust_firstname			= trim($this->orderRow['customer_firstname']);
		$this->cust_addr1				= trim($this->orderRow['customer_street_address1']);
		$this->cust_addr2				= trim($this->orderRow['customer_street_address2']);
		$this->cust_city				= trim($this->orderRow['customer_city']);
		$this->cust_st					= trim(strtoupper($this->orderRow['customer_state']));
		$this->cust_postal				= trim($this->orderRow['customer_postcode']);
		$this->cust_country				= "USA";
		$this->cust_phone				= trim($this->orderRow['customer_telephone']);
		$this->cust_email				= trim($this->orderRow['customer_email_address']);
		
		// Shipping & Delivery Information
		$this->delivery_firstname		= trim($this->orderRow['delivery_firstname']);
		$this->delivery_lastname		= trim($this->orderRow['delivery_lastname']);
		$this->delivery_addr1			= trim($this->orderRow['delivery_street_address1']);
		$this->delivery_addr2			= trim($this->orderRow['delivery_street_address2']);
		$this->delivery_city			= trim($this->orderRow['delivery_city']);
		$this->delivery_st				= trim(strtoupper($this->orderRow['delivery_state']));
		$this->delivery_postal			= trim($this->orderRow['delivery_postcode']);
		$this->delivery_country			= "USA";
		
		// Billing Information
		$this->bill_firstname			= trim($this->orderRow['billing_firstname']);
		$this->bill_lastname			= trim($this->orderRow['billing_lastname']);
		$this->bill_addr1				= trim($this->orderRow['billing_street_address1']);
		$this->bill_addr2				= trim($this->orderRow['billing_street_address2']);
		$this->bill_city				= trim($this->orderRow['billing_city']);
		$this->bill_st					= trim(strtoupper($this->orderRow['billing_state']));
		$this->bill_postal				= trim($this->orderRow['billing_postcode']);
		$this->bill_country				= "USA";
		
		// Payment Information
		$this->paypal_email				= trim(strtolower($this->orderRow['paypal_email']));
		$this->paypal_selected			= $this->orderRow['paypal_selected'];
		$this->cc_type					= trim($this->orderRow['cc_type']);
		$this->cc_number				= trim($this->orderRow['cc_number']);
		$this->cc_expires				= trim($this->orderRow['cc_expires']);
		$this->cc_securitycode			= trim($this->orderRow['cc_security_code']);
		
		
		$this->getShippingCost('0',$this->order_shippingMethod);
		$this->getEstimatedTax('0');	
	}

				
}
?>