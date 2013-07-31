<?php
    //if ( isset($_POST['formAction']) ) { header("Location: customer-list.php"); }

	$debug = 'On';
	
    require_once 'db/global.inc.php';
    require_once 'classes/clsUtility.php';
	require_once 'classes/clsCustomer.php';


	$DOCUMENT_ROOT="";
	$status="";
	$recMode="";
	
	if(isset($_GET['customer_id'])) {
		$customer_id = (get_magic_quotes_gpc()) ? $_GET['customer_id'] : addslashes($_GET['customer_id']);
	}
	
	if(isset($_GET['status'])) {
		$recMode = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
	}
	
	if (isset( $_POST['formAction'] )) {
		$customer = new Customer();
		$customer->SetDebug($debug);
			
		if($recMode == "E" || $recMode == "A") {
			$customer->UpdateCustomer( $db, $_POST['frm'], $recMode );
		} else if ($recMode == "D") {
			$customer->UpdateCustomerStatus($db, $_POST['frm']);
		}		
	}

    // fetch data
	$sql = sprintf( "SELECT * FROM Customer WHERE customer_id = %s", $customer_id );
    $rs = $db->query( $sql); 
    $row = $rs->fetch();
	
	$utility = new Utility();
    	
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
  		});
		$(function() {
    		$( "#exp2" ).datepicker();
  		});

		// Hide common submit

		
		
  	</script
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
			Customer Maintenance - <?php echo( $recStatusDesc ); ?>
		</h2>
		<hr />
	
		<div id="formContent">
		<?php include 'includes/customer-form.php';?>
		</div>
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>

</body>
</html>
