<?php 
	header('Content-type: text/html; charset=utf-8');
	require "inc/back-to-referer.inc.php";
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
	$constants = new Constants();
	$order = new Order($debug, $db);
	$request  = new Request;
	$utility  = new Utility($debug);
	$utilityDB  = new UtilityDB($debug, $db);
	
	// Setup the case
	switch ( strtolower($recMode ) ) {
	    case "a":
	        $recStatusDesc = "Adding new Order";
	        break; 
		case "d":	
			$recStatusDesc = "Making Order Inactive";
			break;
		case "e":
			$recStatusDesc = "Updating Order information";
			break;
		}
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title>Order Entry</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="css/square/square.css" rel="stylesheet"/>
	
	<link href="css/blitzer/jquery-ui-1.10.3.custom.css" rel="stylesheet">
  	<script src="js/jquery-1.9.1.js"></script>
  	<script src="js/jquery-ui-1.10.3.custom.js"></script>	
    <link href="css/skins/flat/red.css" rel="stylesheet" />

	<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
	<!-- Form Validation Engine -->
	<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
	<script type="text/javascript" src="js/jquery.icheck.js"></script>

	<script src="js/jquery.printPage.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/customer.js"></script>
	<script type="text/javascript" src="js/order.js"></script>  
	<script type="text/javascript" src="js/part.js"></script>  

</head>


<body>
<div id="dialog-confirm" title="">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>This item will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>
<div id="dialog-print" title="">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Print Pick Ticket?</p>
</div>
<div id="dialog-print-tickets" title="">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Print All Pick Tickets?</p>
</div>

<div id="header">
	<h1>
		Drive Systems
	</h1>
</div>
<div id="wrapper">

<div id="navigation">
		<?php
		require "inc/nav.inc.php";
		?>
	</div>
<div id="content">
	
	<!-- Customer Banner -->
	<div id="customer-banner" >
		<fieldset class="fsCustomer" >
		<legend>Customer Information</legend>
			<div class="kitSpacers">
			<div class="ui-widget">
				<input id="customerDBA"  name="frm[customerDBA]" type="text" value="<?php echo $row['dba']?>" />
			</div>			
		</fieldset>
	</div>
	
</div>

<div id="rightCol">
	<!-- Order Info -->
	<div id="order-banner"></div>
	<div style="float:left; width:300px">
		<div id="notes-banner"></div>
		<div id="print-banner"></div>
	</div>
</div>
	
<div class="Push"></div>	

<div id="orderItemsBanner">
	<!-- Order Items Go here -->
</div>




</div>		
<div id="footer">
	Copyright © Site name, 20XX
</div>






	
<!-- Customer Update Dialog -->
	<div id="dialog-customer" title="Customer Information">
		<div id="customer"></div>
	</div>
	<div id="dialog-orderItem" title="Order Entry">
	<?php include "inc/order-form.inc.php"; ?>
	</div>
<input type="hidden" id="cust_id" name="frm[cust_id]" value="id" />
<input type="hidden" id="cust_number" name="frm[cust_number]" value="" />
<input type="hidden" id="grand-total" name="frm[grand-total]" value="0.00" />
<input type="hidden" id="order_number" name="frm[order_number]" />

<div id="log"></div>
<form id="order">
	<input type="hidden" id="order_number" name="frm[order_number]"  />
	<input type="hidden" id="customer_number" name="frm[customer_number]" />
	<input type="hidden" id="order_date" name="frm[order_date]" />
	<input type="hidden" id="order_total" name="frm[order_total]" />
	<input type="hidden" id="order_tax" name="frm[order_tax]"  />
	<input type="hidden" id="order_shipping" name="frm[order_shipping]"  />
	<input type="hidden" id="customer_po" name="frm[customer_po]"  />
	<input type="hidden" id="order_discount" name="frm[order_discount]" value="0" />
	<input type="hidden" id="order_status" name="frm[order_status]" value="NEW" />
	<input type="hidden" id="tax_rate" name="frm[tax_rate]" value="" />
	<input type="hidden" id="special_instructions" name="frm[special_instructions]" value="" />

</form>
</body>
</html>
