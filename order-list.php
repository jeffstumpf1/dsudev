<?php 
	$debug = 'Off';
	require_once 'db/global.inc.php';
	
	
	function __autoload($class) {
		include 'classes/' . $class . '.class.php';
	}
	
	// Create Object Customer and Request
	$constants = new Constants;
	$orders = new Order($debug, $db);
	$utility = new Utility($debug);
	$request  = new Request;

	// Get Query Parameters
	$status  = $request->getParam('status','');
	$recMode = $request->getParam('cat','');
	$search  = $request->getParam('search','');

	// Get Orders
	$rs = $orders->ListOrders($search);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title>Order Listing <?php echo( $searchInput); ?></title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="/themes/base/jquery.ui.all.css" rel="stylesheet">

	<script src="js/jquery-1.9.1.js"></script>
	<script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>
	<script src="ui/jquery.ui.dialog.js"></script>
	<script src="ui/jquery.ui.menu.js"></script>
	<script src="ui/jquery.ui.mouse.js"></script>
	<script src="ui/jquery.ui.draggable.js"></script>
	<script src="ui/jquery.ui.position.js"></script>
	<script src="ui/jquery.ui.resizable.js"></script>
	<script src="ui/jquery.ui.button.js"></script>
	<script type="text/javascript" src="js/order.js"></script>  
	<script>
		$(function() {			
			$( "#searchInput" ).on('mouseup', function() { $(this).select(); });
		});
	</script>
</head>
<body>
<div id="dialog-confirm" title="">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>This Order will be permanently deleted and cannot be recovered. Are you sure?</p>
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
			  <form action="order.php?status=A" method="post" accept-charset="utf-8">
				<input id="createOrder" type="submit" value="Create a new Order" />
			  </form>
			</div>
			<div id="searchBox">
			  <form id="frmSearch">				
				<input id="search" name="search" type="text" value="<?php echo $search ?>" />
				<input type="submit" value="Search" />
			</div>
		</div>
		<table id="customerTable">
			<tr>
				<th>Action</th>
				<th>Order Number</th>
				<th>Customer</th>
				<th>Customer PO</th>
				<th>Date</th>
				<th>Total</th>
				<th>Tax</th>
				<th>Frieght</th>
				<th>Status</th>
			</tr>
			<?php 
			while ($row = $rs->fetch() ) {?>
			
			<tr class="row">
				<td><!- Action -->
					<a href="order.php?order_number=<?php echo $row['order_number'];?>&status=E"><div class="actionEdit"></div></a>
					<a class="delete" oid="<?php echo $row['order_number'];?>" pn="<?php echo $row['order_id'];?>" ct="<?php echo $row['customer_number']?>"><div class="actionOrder"></div></a>
				</td>
				<td> 
					<?php echo $row['order_number'];?>
				</td>
				<td> 
					<?php echo $row['customer_number'];?>
				</td>
				<td> 
					<?php echo $row['customer_po']?>
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
