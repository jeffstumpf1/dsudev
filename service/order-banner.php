<?php 
	/* Load Invoice Information in banner , Used in Ajax call
	   order-banner.php
	*/
	$debug="Off";
	
    require_once '../db/global.inc.php';
    require_once '../classes/clsUtility.php';
    require_once '../classes/clsOrder.php';
	
	$order = new Order();
	$utility = new Utility();
	$sql=''; 
	
	
	$order_date = $utility->GetDate();
	
	if(isset($_GET['order_number'])) {
		$order_number = (get_magic_quotes_gpc()) ? $_GET['order_number'] : addslashes($_GET['order_number']);
	}
	
		
    // fetch data
	$sql = sprintf( "SELECT * FROM Order WHERE customer_number = '%s'", $order_number );
    //$rs = $db->query( $sql); 
    //$row = $rs->fetch();
	if($debug=="On") {
		echo $sql."<br>";
	}
?>	

<fieldset class="fsOrderInfo">
	<legend>Order Information</legend>
	<div class="orderInfo">
		<table class="tableOrderInfo">
			<tr>
				<td norwrap="true">Order Number:</td>
				<td id="orderNumber" style="text-align:right;"><?php echo $order->GetNextOrderNumber($db) ?></td>
			</tr>
			<tr>
				<td>Order Date:</td> 
				<td id="orderDate" style="text-align:right;"><input type="text" value="<?php echo $order_date?>" id="orderDate" /></td>
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

</fieldset>
