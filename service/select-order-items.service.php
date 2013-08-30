<?php 
	/* Load Orders Items , Used in Ajax call
	   
	   
	   /service/select-order-items.service.php?order_number=130705554
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
	$rs = $order->GetOrderItems($order_number);
?>	

<fieldset id="fsOrderItems">
<legend>Order Items</legend>	
<form>
<table id="chainChartTable">
<tr style="width:80px;"><th>Action</th>
	<th style="text-align:left;">Part#</th>
	<th style="text-align:left;width :35%">Description</th>
	<th style="text-align:center;">Cat</th>
	<th style="text-align:center;">%</th>
	<th style="text-align:left;">Front Sprocket</th>
	<th style="text-align:left;">Rear Sprocket</th>
	<th style="text-align:center;">Length</th>
	<th style="text-align:right;">MSRP</th>
	<th style="text-align:center;">QTY</th>
	<th style="text-align:right;">Discount</th>
	<th style="text-align:right;">Unit Price</th>
	<th style="text-align:right;">Total</th>
</tr>
<?php while ($row = $rs->fetch()) { ?>		
<tr class="row">
	<td><!-- Action -->
		<!-- Logic to handle editing graphic panels -->
		<!--<a class="edit" href="<?php echo $page; ?>?part_id=<?php echo $row['part_id'];?>&status=E&cat=<?php echo $row['category_id'];?>"><div class="actionEdit"></div></a>-->
		<a class="delete" oid="<?php echo $row['order_item_id'];?>" pn="<?php echo $row['part_number'];?>" ct="<?php echo $row['category_id']?>"><div class="actionStatus"></div></a>
	</td>
	<td style="text-align:left;"> <!-- Part Number -->
		<?php echo $row['part_number'] ?>
	</td>
	<td style="text-align:left;"> 
		<?php echo $row['description'] ?>
	</td>
	<td style="text-align:center;"> 
		<?php echo $row['category_id'] ?>
	</td>
	<td style="text-align:center;"> 
		<?php echo $row['discount'] ?>%
	</td>	
	<td style="text-align:left;"> 
		<?php echo $row['frontSprocket_part_number'] ?>
	</td>
	<td style="text-align:left;"> 
		<?php echo $row['rearSprocket_part_number'] ?>
	</td>
	<td style="text-align:center;"> 
		<?php echo $row['chain_length'] ?>
	</td>
	<td style="text-align:right;"> 
		<?php echo $utility->NumberFormat($row['msrp'],'$') ?>
	</td>
	<td style="text-align:center;"> 
		<?php echo $row['qty'] ?>
	</td>
	<td style="text-align:right;"> 
		<?php echo $utility->NumberFormat($row['discount_price'],'$') ?>
	</td>
	<td style="text-align:right;"> 
		<?php echo $utility->NumberFormat($row['unit_price'], '$') ?>
	</td>
	<td style="text-align:right;"> 
		<?php echo $utility->NumberFormat($row['total'] ,'$')?>
	</td>	
</tr>
<?php } ?>
</table></form>

</fieldset>
