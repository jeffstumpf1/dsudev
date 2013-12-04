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
	$customer = new Customer($debug, $db);
	$request  = new Request;

	// Get Query Parameters
	$status  = $request->getParam('status');
	$recMode = $request->getParam('cat');
	$search  = $request->getParam('search');

	// Get Customers
	if($search=='D' || $search=='R') {
		$rs = $customer->ListCustomersByType($search);
	} else
		$rs = $customer->ListCustomers($search);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title>Customer Listing <?php echo( $searchInput); ?></title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>	
  	
	<!-- Form Validation Engine -->
	<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>

  	<script src="js/customer.js"></script>
	
	<script>
		$(function() {			
			$( "#searchInput" ).on('mouseup', function() { $(this).select(); });
			$('tr:odd').css({backgroundColor: '#efefef'});
		});
	</script>
</head>
<body>
<div id="dialog-confirm" title="">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>This customer will be permanently deleted and cannot be recovered. Are you sure?</p>
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
			Customer Listing - [ <?php echo  $rs->size() ?> ]
		</h2>
		<hr />
		<div id="commandBar">
			<div id="actionBox">
			  <form action="customer.php?status=A" method="post" accept-charset="utf-8">
				<input id="createCustomer" type="submit" value="Create a new Customer" />
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
				<th>Action</th>
				<th>Dealer Name</th>
				<th>City</th>
				<th>State</th>
				<th>Phone</th>
				<th>Discount %</th>
			</tr>
			<?php 
			while ($row = $rs->fetch() ) {?>
			
			<tr class="row">
				<td><!- Action -->
					<a href="" ct="<?php echo $row['customer_number']?>" title="Edit Customer"><div class="actionEditCustomer"></div></a>
					<a href="" class="delete" oid="<?php echo $row['customer_id'];?>" ct="<?php echo $row['customer_number']?>" title="Delete Customer"><div class="actionDeleteCustomer"></div></a>
					<a href="order-list.php?customer=<?php echo $row['customer_number']?>" title="Customer Orders"><div class="customerOrder"></div></a>

				</td>
				<td> <!- Dealer Name -->
					<?php echo $row['dba'];?>
				</td>
				<td> <!- City -->
					<?php echo $row['city'];?>
				</td>
				<td> <!- State -->
					<?php echo $row['state'];?>
				</td>
				<td> <!- Phone -->
					<?php echo $row['phone1'];?>
				</td>
				<td> <!- Discount -->
					<?php echo $row['discount'].' %';?>
				</td>
			</tr>
			<?php }  ?>
		</table>
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
<!-- Customer Update Dialog -->
	<div id="dialog-customer" title="Customer Information">
		<div id="customer"></div>
	</div>

</body>
</html>
