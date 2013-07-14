<?php 
    require_once 'db/global.inc.php';
    error_reporting(E_ALL|E_STRICT);

    $searchInput='';
	$DOCUMENT_ROOT="";
	$status="";
	$recMode="";
	
	if(isset($_GET['status'])) {
		$recMode = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
	}
	if(isset($_GET['cat'])) {
		$partCat = (get_magic_quotes_gpc()) ? $_GET['cat'] : addslashes($_GET['cat']);
	}
	if(isset($_POST['searchInput'])) {
		$searchInput = (get_magic_quotes_gpc()) ? $_POST['searchInput'] : addslashes($_POST['searchInput']);
	}

    // fetch data
	$sql = "SELECT * FROM Customer WHERE rec_status = 0 ORDER BY dba";
    $rs = $db->query( $sql); echo 'Number of Customer(s) found ( '. $rs->size() . ')';
    $row = $rs->fetch();

	//todo: $formatter = new NumberFormatter('en-US', NumberFormatter::PERCENT);
	
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
<div id="container">
	<div id="header">
		<h1>
			Drive Systems
		</h1>
	</div>
	<div id="navigation">
		<?php
		require($DOCUMENT_ROOT . "includes/nav.php");
		?>
	</div>
<div id="content">
		<h2>
			Customer Listing
		</h2>
		<hr />
		<div id="commandBar">
			<div id="actionBox">
			  <form action="customer.php?status=A" method="post" accept-charset="utf-8">
				<input id="createCustomer" type="submit" value="Create a new Customer" />
			  </form>
			</div>
			<div id="searchBox">
			  <form id="formSearch" action="<?php $PHP_SELF;?>" method="post" accept-charset="utf-8">
				<input id="searchInput" type="text" value="Customer Search" />
				<input id="searchButton" type="submit" value="Go" />
			  </form>
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
			<?php do{ ?>
			
			<tr class="row">
				<td><!- Action -->
					<a href="customer.php?customer_id=<?php echo $row['customer_id'];?>&status=E"><div class="actionEdit"></div></a>
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
			<?php } while ($row = $rs->fetch( $rs )); ?>
		</table>
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
</body>
</html>
