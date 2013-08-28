<?php 
	/* Load Customer Information in banner , Used in Ajax call
	   customer-banner.service.php
	   
	   /service/customer-banner.service.php?customer_number=2
	*/
	$debug = 'Off';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
	$customer = new Customer($debug, $db);
	$request  = new Request;
	$utility  = new Utility($debug);

	// Get Query Parameters
	$customer_number = $request->getParam('customer_number');
			
	// Get Info and Display
	$row = $customer->GetCustomer($customer_number);
			
?>	

<fieldset class="fsCustomer">
	<legend>Customer Information [ #<?php echo $row['customer_number']?> ]</legend>
	<p>				
		<div class="kitSpacers">
			<input id="customerDBA"  name="frm[customerDBA]" type="text" value="<?php echo $row['dba']?>" />
			<input type="button" id="editCustomer" value="Update"/>
			<input type="checkbox" value="0" id="useBillingforShipping">&nbsp;Billing Address for Shipping
		</div>
	</p>
	<div class="custInfo">
		<label><?php echo $row['address']?></label><br/>
		<label><?php echo $row['city']?>, <?php echo $row['state']?> <?php echo $row['zip']?></label><br/>
		<label>Phone:<?php echo $row['phone1']?> fax: <?php $row['fax']?></label><br/>
		<label><?php echo $row['email']?></label> 
	</div>
	<div class="custInfo">
		<label><?php echo $row['billing_address']?></label><br/>
		<label><?php echo $row['billing_city']?>, <?php echo $row['billing_state']?> <?php echo $row['billing_zip']?></label><br/>
		<label>Phone:<?php echo $row['phone1']?> fax: <?php $row['fax']?></label><br/> 
		<label>Discount: <?php echo $row['discount']?></label><label>%  Taxable: <?php echo $row['taxable']?></label>
	</div>

	<div class="specialInstructions" >	
		<p><label>Special Instructions</label></p>
		<textarea rows="2" cols="75">Special instructions for this order.</textarea>
	</div>	
	<input type="hidden" id="customer-discount" value="<?php echo $row['discount']?>"/>
	<input type="hidden" id="customer-taxable" value="<?php echo $row['taxable']?>"/>
</fieldset>

