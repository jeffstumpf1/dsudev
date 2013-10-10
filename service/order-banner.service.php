<?php 
	/* Load Order Information in banner , Used in Ajax call
	
	   /service/order-banner.service.php?order_number=130705564
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
	$utilityDB  = new UtilityDB($debug, $db);

	// Get Query Parameters
	$status = $request->GetParam('status');
	$order_number = $request->getParam('order_number');
	$tax_rate = $request->getParam('tax_rate');

	if ($debug=='On') echo "order: ", $order_number, "rate: ", $tax_rate, "status: ", $status;

	// Get Info and Display
	$row = $order->SummarizeOrder($order_number, $tax_rate);
	//print_r($row);
	
	$order_items_total = $row['order_items_total'];
	$order_shipping = $row['order_shipping'];
	$order_taxable = $row['order_taxable'];
	$order_date = $row['order_date'];
	
	if(empty($order_date)) {
		$order_date = $utility->GetDate();
		//echo $utility->GetDate();
	}
	
	
	$total = $order_items_total + $order_taxable + $order_shipping;
	
	if($debug=='On') {
		echo "Order Items Total = ". $order_items_total . "<br/>";
	}
?>	
<form id="order">
<fieldset class="fsOrderInfo">
	<legend>Order Information</legend>
	<div class="orderInfo">
		<table class="tableOrderInfo">
			<tr>
				<td norwrap="true">Order Number:</td>
				<td id="orderNumber" style="text-align:right;"><?php echo $order_number?></td>
			</tr>
			<tr>
				<td>Order Date:</td> 
				<td id="orderDate" style="text-align:right;"><input style="text-align:right;" type="text" value="<?php echo $order_date ?>" id="order_date" name="frm[order_date]"/></td>
			</tr>
			<tr>
				<td>Order PO:</td>
				<td id="" style="text-align:right;"><input id="customer_po" name="frm[customer_po]" type="text" value="<?php echo $row['customer_po']?>" style="text-align:right;"/></td>
			</tr>
			<tr>
				<td>Payment Terms:</td>
				<td id="" style="text-align:right;">
					<select id="payment_terms" name="frm[payment_terms]">
						<option value="*">Select...</option>
						<?php
						 echo $utilityDB->LookupList($row['payment_terms_id'], Constants::TABLE_PAYMENT_LIST);   
						?>
					</select>
				</td>
			</tr>			
		    <tr><td colspan="2" style="border:none;">&nbsp;</td>
		    </tr>
		</table>  
		<table class="tableOrderInfo" style="border:1px solid #ccc;">
			<tr >
				<th style="text-align:left;">Description</th><th style="text-align:right;">Cost $</th>
			</tr>
			<tr>
				<td>Order Items <span id="itemCount"></span></td>
				
				<td  style="text-align:right;"><?php echo $utility->NumberFormat($order_items_total,'')?></td>
			</tr>
			<tr>
				<td>Freight</td> 
				<td id="" style="text-align:right;"><input type="text" id="order_shipping" name="frm[order_shipping]" style="text-align:right;" value="<?php echo $utility->NumberFormat($order_shipping,'')?>"/></td>
			</tr>
			<tr>
				<td>Tax</td>
				<td id="" style="text-align:right;"><span id="tax"><?php echo $utility->NumberFormat($order_taxable,'')?></span></td>
			</tr>
			<tr>
				<td>Total<span id="itemCount"></span></td>
				<td style="text-align:right;"><span id="totalCost"><?php echo $utility->NumberFormat($total,'')?></span></td>
			</tr>
		</table>
	</div>
	<p>
	<input type="button" value="New Order Item" id="createOrderItem" />
	<input type="button" value="Save Order" id="updateOrder" />
	</p>
</fieldset>

	<input type="hidden" id="tax_rate" name="frm[tax_rate]" value="<?php echo $row['tax_rate']?>" />
	<input type="hidden" id="order_status" name="frm[order_status]" />
	<input type="hidden" id="order_number" name="frm[order_number]" value="<?php echo $order_number?>" />
</form>
<!--<script>$('#specialInstructions').val(<?php echo $row['special_instructions']?>)</script>-->