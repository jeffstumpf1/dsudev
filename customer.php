<?php 
    if ( isset($_POST['formAction']) ) { header("Location: customer-list.php"); }

	$debug = 'Off';
	require_once 'db/global.inc.php';
	
	function __autoload($class) {
		include 'classes/' . $class . '.class.php';
	}
	
	// Create Object Customer and Request
	$constants = new Constants;
	
	$customer = new Customer($debug, $db);
	$request  = new Request;
	$utilityDB = new UtilityDB($debug, $db);
	$utility  = new Utility($debug);

	// Get Query Parameters
	$recMode  = $request->getParam('status','');
	$search  = $request->getParam('search','');
	$customer_number = $request->getParam('customer_number');
	$action  = $request->getParam('formAction','');

	// Was form Submitted?
	if ($action) {
		if($recMode == "E" || $recMode == "A") {
			$customer->UpdateCustomer( $_POST['frm'], $recMode );
		} else if ($recMode == "D") {
			$customer->UpdateCustomerStatus($_POST['frm']);
		}		
	}

	// Get Info and Display
	$row = $customer->GetCustomer($customer_number);
	    	
	// Setup the case
	switch ( $recMode )  {
	    case "A":
	        $recStatusDesc = "Adding new customer";
	        break; 
		case "D":	
			$recStatusDesc = "Making customer Inactive";
			break;
		case "E":
			$recStatusDesc = "Updating customer information";
			break;
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title>Customer Maintenance</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script>
		$(function() {
    		$( "#exp1" ).datepicker();
    		$( "#exp2" ).datepicker();
			$('#submitCustomer').remove();
		});
		
  	</script
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
			Customer Maintenance - <?php echo( $recStatusDesc ); ?>
		</h2>
		<hr />
	
		<div id="">
		<?php include 'inc/customer-form.inc.php';?>
		</div>
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>

</body>
</html>
