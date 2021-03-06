<?php 
	$debug = 'Off';
	require_once 'db/global.inc.php';
	
 	// Start logging
	include 'log4php/Logger.php';
	Logger::configure('logconfig.xml');
	$log = Logger::getLogger('myLogger');
	 spl_autoload_register(function ($class) {
		include 'classes/' . $class . '.class.php';
	 });   	
	
	// Create Object Customer and Request
	$constants = new Constants;
	$orders = new Order($debug, $db);
	$utility = new Utility($debug);
	$request  = new Request;

	// Get Query Parameters
	$status  = $request->getParam('status','');
	$recMode = $request->getParam('cat','');
	$search  = $request->getParam('search','');
	$cust    = $request->getParam('customer');

	// Get Orders
	if($cust!='') {
		$rs = $orders->ListCustomerOrders($cust);
	} else 
		$rs = $orders->ListOrders($search);
	

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title>Order Listing <?php echo( $searchInput); ?><?php echo $cust; ?></title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/blitzer/jquery-ui-1.10.3.custom.css" rel="stylesheet">
  	<script src="js/jquery-1.9.1.js"></script>
  	<script src="js/jquery-ui-1.10.3.custom.js"></script>	

	<script type="text/javascript" src="js/order.js"></script>  
	<script>
		$(function() {			
			$( "#searchInput" ).on('mouseup', function() { $(this).select(); });
			$('tr:odd').css({backgroundColor: '#efefef'});

		});
	</script>
</head>
<body>
<div id="dialog-confirm" title="">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>This Order will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>
<div id="dialog-shipping" title="">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>This order will be changed to shipped status?</p>
</div>
<div id="wrapper">
	<div id="header">
		<h1>
			Drive Systems
		</h1>
	</div>
	<div id="navigation">
		<?php
		require "inc/nav.inc.php";
		?>
	</div>
<div id="wrapper">
		<h2>
			Order Listing - [ <?php echo  $rs->size() ?> ]
		</h2>
		<hr />
		<div id="commandBar">
			<div id="actionBox">
			  <form action="order.php" method="post" accept-charset="utf-8">
				<input id="createOrder" type="submit" value="Create a new Order" />
				<input type="hidden" id="order_number" value="<?php echo $nextOrder?>"/>
			  </form>
			</div>
			<div id="searchBox">
			  <form id="frmSearch">				
				<input id="search" name="search" type="text" value="<?php echo $search ?>" />
				<input type="submit" value="Search" id="submit"/>
			</div>
		</div>
		<table id="customerTable">
			<tr>
				<th width="325">Action</th>
				<th width="75">Order Number</th>
				<th width="200">Customer</th>
				<th width="100">PO</th>
				<th width="100">Terms</th>
				<th width="100">Date</th>
				<th width="100">Total</th>
				<th width="100">Tax</th>
				<th width="100">Rate</th>
				<th width="100">Frieght</th>
				<th width="100">Status</th>
			</tr>
			<?php 
			while ($row = $rs->fetch() ) 
			
			{?>
			
			<tr class="row">
				<td><!- Action -->
                <?php if( $row['order_status_code']!='SHIPPED' ) { ?>
					<a title="Edit Order" href="order.php?tax_rate=<?php echo floatval($row['tax_rate'])?>&customer_number=<?php echo $row['customer_number']?>&order_number=<?php echo $row['order_number'];?>&status=<?php echo $row['order_status_code']?>"><div class="actionEdit"></div></a>
					<a href="" title="Delete Order" class="delete" oid="<?php echo $row['order_number'];?>" pn="<?php echo $row['order_id'];?>" ct="<?php echo $row['customer_number']?>"><div class="actionOrder"></div></a>
				<?php } ?>	
                    <a title="Print Customer Invoice" href="print-invoice.php?order_number=<?php echo $row['order_number'];?>&tax_rate=<?php echo $row['tax_rate']?>&code=0" target="_BLANK"><div class="actionPrint"></div></a>
					<a title="Ship Product" href="" oid="<?php echo $row['order_number'];?>" ostatus="<?php echo $row['order_status_code'];?>" ><div class="actionShipping"></div></a>
				</td>
				<td> 
					<?php echo $row['order_number'];?>
				</td>
				<td nowrap="true" style="text-align:left"> 
					<?php echo $row['dba'];?>-<?php echo $row['customer_number'];?>
				</td>
				<td> 
					<?php echo $row['customer_po']?>
				</td>		
				<td> 
					<?php echo $row['payment_terms_id']?>
				</td>						
				<td> 
					<?php echo $row['order_date'];?>
				</td>
				<td> 
					<?php echo $utility->NumberFormat($row['order_total'],'$');?>
				</td>
				<td> 
					<?php echo $utility->NumberFormat($row['order_tax'],'$')?>
				</td>
				<td> 
					<?php echo $row['tax_rate']?>
				</td>				
				<td> 
					<?php echo $utility->NumberFormat($row['order_shipping'],'$')?>
				</td>
				<td> 
					<?php echo $row['order_status_code']?>
				</td>								
			</tr>
			<?php }  ?>
		</table>
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
</body>
</html>
