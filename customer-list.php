<?php 
	$debug = 'Off';
	require_once 'db/global.inc.php';
	
	
	function __autoload($class) {
		include 'classes/' . $class . '.class.php';
	}
	
	// Create Object Customer and Request
	$constants = new Constants;
	$customer = new Customer($debug, $db);
	$request  = new Request;

	// Get Query Parameters
	$status  = $request->getParam('status','');
	$recMode = $request->getParam('cat','');
	$search  = $request->getParam('search','');

	// Get Customers
	$rs = $customer->ListCustomers($search);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title>Customer Listing <?php echo( $searchInput); ?></title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.1.min.js"><\/script>')</script>
	
	<script>
		$(function() {			
			$( "#searchInput" ).live('mouseup', function() { $(this).select(); });
		});
	</script>
</head>
<body>
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
				<input type="submit" value="Search" />
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
					<a href="customer.php?customer_number=<?php echo $row['customer_number'];?>&status=E"><div class="actionEdit"></div></a>
					<a href="customer.php?customer_id=<?php echo $row['customer_id'];?>&status=D"><div class="actionStatus"></div></a>
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
</body>
</html>
