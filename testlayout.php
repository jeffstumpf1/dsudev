<?php 
	header('Content-type: text/html; charset=utf-8');
    if ( isset($_POST['formAction']) ) { header("Location: part-list.php"); }
    
    $debug = 'Off';
	
    require_once 'db/global.inc.php';
	require_once 'classes/clsChain.php'; 
	require_once 'classes/clsOrder.php'; 
	require 'classes/clsUtility.php';
    
    error_reporting(E_ERROR);

	$DOCUMENT_ROOT="";
	$status="";
	$recMode="";
	$order = new Order();
	$utility = new Utility();
	$order->SetDebug($debug);
	$cust_id='';
	$part_id='';
	

	if(isset($_GET['cust_id'])) {
		$cust_id = (get_magic_quotes_gpc()) ? $_GET['cust_id'] : addslashes($_GET['cust_id']);
	}


	if(isset($_GET['part_id'])) {
		$part_id = (get_magic_quotes_gpc()) ? $_GET['part_id'] : addslashes($_GET['part_id']);
	}
	
	if(isset($_GET['status'])) {
		$recMode = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
	}

	// Update Controller
	if (isset( $_POST['formAction'] )) {
			
		if(strtolower($recMode) == "e" || strtolower($recMode) == "a") {
			$part_id = $kit->UpdateOrder( $db, $_POST['frm'], $recMode );
		} else if (strtolower($recMode) == "d") {
			$kit->UpdateOrderStatus($db, $_POST['frm'] );
		}
	}

    // fetch data
	$sql = sprintf( "select a.*,b.* from PartMaster a, ChainKit b where a.part_number = b.part_number and a.rec_status=0 and a.category_id='KT' and a.part_id = %s", $part_id );
    $rs = $db->query( $sql); 
    $row = $rs->fetch();

	if ($debug=='On') { echo $sql."<br>"; }	
	
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
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>	
  	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<link href="css/square/square.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.icheck.js"></script>
	<script type="text/javascript" src="js/jquery.blockUI.js"></script>
	<script type="text/javascript" src="js/kit.js"></script>
	<script type="text/javascript" src="js/customer.js"></script>
	<script type="text/javascript" src="js/order.js"></script>
</head>
<body>


<div id="header">
	<h1>
		Drive Systems
	</h1>
</div>
<div id="wrapper">

	<div id="navigation">
		navigation here
	</div>
	
	<div id="content">
		content goes here
	</div>


	<div id="rightCol">
		<!-- Order Info -->
		Right Column stuff here
	</div>
	
	<div class="Push"></div>	
</div>		
<div id="footer">
	Copyright © Site name, 20XX
</div>


</body>
</html>
