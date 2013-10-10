<?php 
	/* Load Customer Notes in banner , Used in Ajax call
	   customer-notes-banner.service.php
	   
	   /service/customer-notes-banner.service.php?customer_number=2
	*/
	$debug = 'Off';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
	$order = new Order($debug, $db);
	$request  = new Request;
	$utility  = new Utility($debug);

	// Get Query Parameters
	$order_number = $request->getParam('order_number');
			
	// Get Info and Display
	$row = $order->GetOrder($order_number);
			
?>	

<fieldset class="fsCustomerNotes">
	<legend>Order Notes</legend>
	<div class="specialInstructions" >	
		<p><label>Special Instructions</label></p>
		<textarea rows="3" cols="40" id="specialInstructions" style="margin-bottom: 10px"><?php echo $row['special_instructions']?></textarea>
	</div>	
	<class="group">
		<div style="text-align:center">
			<input type="button" value="Save" id="saveNotes"/> 
		</div>
	</div>	
</fieldset>

