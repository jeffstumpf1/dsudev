<?php 
	header('Content-type: text/html; charset=utf-8');
	
	$debug = 'Off';
	require_once 'db/global.inc.php';
	
	function __autoload($class) {
		include 'classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
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
	
	<script src="js/jquery-1.9.1.js"></script>
	<script src="ui/jquery.ui.core.js"></script>
	<script src="ui/jquery.ui.widget.js"></script>
	<script src="ui/jquery.ui.menu.js"></script>

	<script src="ui/jquery.ui.mouse.js"></script>
	<script src="ui/jquery.ui.draggable.js"></script>
	<script src="ui/jquery.ui.position.js"></script>
	<script src="ui/jquery.ui.resizable.js"></script>
	<script src="ui/jquery.ui.button.js"></script>
	<script src="ui/jquery.ui.dialog.js"></script>
	<script src="ui/jquery.ui.autocomplete.js"></script>	
	

	<script type="text/javascript" src="js/jquery.icheck.js"></script>
	
	<script type="text/javascript" src="js/customer.js"></script>
	<script type="text/javascript" src="js/order.js"></script>  
	<script type="text/javascript" src="js/part.js"></script>  
	
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />

	<link href="css/square/square.css" rel="stylesheet">
	<link href="/themes/base/jquery.ui.all.css" rel="stylesheet">
	<link href="css/demo.css" rel="stylesheet">
	

</head>


<body>


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
</div>





	
	<div class="Push"></div>	
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

<div id="log"></div>

</body>
</html>
