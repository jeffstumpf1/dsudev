<?php 
	/* Load Customer Information in banner , Used in Ajax call
	   customer-banner.php
	*/
	$debug="Off";
	
    require_once '../db/global.inc.php';
    require_once '../classes/clsUtility.php';
    
	$customer_id='';
	    
	$utility = new Utility();
	$sql=''; 
	
	if(isset($_GET['customer_number'])) {
		$customer_number = (get_magic_quotes_gpc()) ? $_GET['customer_number'] : addslashes($_GET['customer_number']);
	}
	
		
    // fetch data
	$sql = sprintf( "SELECT * FROM Customer WHERE customer_number = '%s'", $customer_number );
    $rs = $db->query( $sql); 
    $row = $rs->fetch();
	if($debug=="On") {
		echo $sql."<br>";
	}
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
		<label>Discount: <?php echo $row['discount']?>%  Taxable: <?php echo $row['taxable']?></label>
	</div>

	<div class="specialInstructions" >	
		<p><label>Special Instructions</label></p>
		<textarea rows="2" cols="75">Special instructions for this order.</textarea>
	</div>	
</fieldset>

