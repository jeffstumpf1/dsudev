<?php 
	/* Load Order Information in banner , Used in Ajax call
	
	   /service/order-banner.service.php?order_number=10
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
	$order_number = $request->getParam('order_number');
			
	// Get Info and Display
	//$row = $order->GetOrderInformation($order_number);

?>	

<fieldset class="fsOrderInfo">
	<legend>Order Information</legend>
	<div class="orderInfo">
		<table class="tableOrderInfo">
			<tr>
				<td norwrap="true">Order Number:</td>
				<td id="orderNumber" style="text-align:right;"><?php echo $order->GetNextOrderNumber() ?></td>
			</tr>
			<tr>
				<td>Order Date:</td> 
				<td id="orderDate" style="text-align:right;"><input style="text-align:right;" type="text" value="<?php echo $order_date?>" id="orderDate" /></td>
			</tr>
			<tr>
				<td>Order PO:</td>
				<td id="orderPO" style="text-align:right;"><input id="orderPO" type="text" value="" /></td>
			</tr>
		    <tr><td colspan="2" style="border:none;">&nbsp;</td>
		    </tr>
		</table>
		<table class="tableOrderInfo" style="border:1px solid #ccc;">
			<tr >
				<th style="text-align:left;">Description</th><th style="text-align:right;">Cost $</th>
			</tr>
			<tr>
				<td>Item count <span id="itemCount"></span></td>
				<td id="itemCountCost" style="text-align:right;">$0.00</td>
			</tr>
			<tr>
				<td>Freight</td> 
				<td id="freightCost" style="text-align:right;">$0.00</td>
			</tr>
			<tr>
				<td>Surcharge</td>
				<td id="surchargeCost" style="text-align:right;"><input id="orderPO" type="text" value="0.00" style="text-align:right;"/></td>
			</tr>
			<tr>
				<td>Total<span id="itemCount"></span></td>
				<td id="totalCost" style="text-align:right;">$0.00</td>
			</tr>
		</table>
	</div>
	<p>
	<input type="button" value="Create Order Item" id="createOrderItem" disabled="true"/>
	</p>
</fieldset>
