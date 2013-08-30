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

	// Get Query Parameters
	$pitch  = $request->getParam('pitch','');
	$chainLength  = $request->getParam('chainLength','');
	$part = $request->getParam('part');
	$action  = $request->getParam('formAction','');   
	$order_date = $utility->GetDate();
	
	// Query parameters
	$order_number = $request->getParam('order_number');
	$tax_rate = $request->getParam('tax_rate');
	if($tax_rate == '') { $tax_rate= .00000000000001; }
	
	// Get Info and Display
	$row = $order->SummarizeOrder($order_number, $tax_rate);
	
	
	$order_items_total = $row['order_items_total'];
	$order_shipping = $row['order_shipping'];
	$order_taxable = $row['order_taxable'];
	
	$total = $order_items_total + $order_taxable + $order_shipping;
	
	if($debug=='On') {
		echo "Order Items Total = ". $order_items_total . "<br/>";
	}
?>	

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
				<td id="orderDate" style="text-align:right;"><input style="text-align:right;" type="text" value="<?php echo $order_date?>" id="orderDate" /></td>
			</tr>
			<tr>
				<td>Order PO:</td>
				<td id="" style="text-align:right;"><input id="orderPO" type="text" value="<?php echo $row['customer_po']?>" style="text-align:right;"/></td>
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
				<td id="" style="text-align:right;"><input type="text" id="freightCost" style="text-align:right;" value="<?php echo $utility->NumberFormat($order_shipping,'')?>"/></td>
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
	<input type="button" value="Update Order" id="updateOrder" />
	</p>
</fieldset>
