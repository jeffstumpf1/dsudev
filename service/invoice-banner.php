<?php 
	/* Load Invoice Information in banner , Used in Ajax call
	   invoice-banner.php
	*/
	$debug="Off";
	
    require_once '../db/global.inc.php';
    require_once '../classes/clsUtility.php';
    require_once '../classes/clsOrder.php';
	
	$order = new Order();
	$utility = new Utility();
	$sql=''; 
	
	$order_number= $order->GetNextOrderNumber($db);
	$order_date = $utilty->GetDate();
	
	if(isset($_GET['order_number'])) {
		$order_number = (get_magic_quotes_gpc()) ? $_GET['order_number'] : addslashes($_GET['order_number']);
	}
	
		
    // fetch data
	$sql = sprintf( "SELECT * FROM Order WHERE customer_number = '%s'", $customer_number );
    //$rs = $db->query( $sql); 
    //$row = $rs->fetch();
	if($debug=="On") {
		echo $sql."<br>";
	}
?>	
<style type="text/css">
 .fs {background-color:#efefef;width:500px}
 .fs p { font-weight: bold; margin-top:5px; margin-bottom: 5px;}
 .orderInfo { float:left; margin 5px 5px; padding:5px; width:225px;}
</style>
<fieldset class="fs">
	<legend>Order Information< ]</legend>
	<p>				
		<div class="kitSpacers">
			<label for="orderNumber">Order Number:</label>
			<input id="orderNumber" type="text" value="<?php echo $order->GetNextOrderNumber($db)?>" /><br/>
			<label for="orderDate">Order Date:</label>
			<input type="text" value="<?php echo $utility->GetDate()?>" id="orderDate" />
			<label for="orderPO">Order PO:</label>
			<input id="orderPO" type="text" value="" />
		</div>
	</p>
	<div class="orderInfo">
		<table id="">
			<tr>
				<th>Description</th><th>Cost $</th>
			</tr>
			<tr>
				<td>Item count <span id="itemCount"></span></td>
				<td id="itemCountCost">$0.00</td>
			</tr>
			<tr>
				<td>Freight</td> 
				<td id="freightCost">$0.00</td>
			</tr>
			<tr>
				<td>Surcharge</td>
				<td id="surchargeCost">$0.00</td>
			</tr>
			<tr>
				<td>Total<span id="itemCount"></span></td>
				<td id="totalCost">$0.00</td>
			</tr>
		</table>
	</div>

</fieldset>
