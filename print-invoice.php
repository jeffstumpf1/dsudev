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
	 	
	// Create Objects
	$constants = new Constants;
	$order = new Order($debug, $db);
	$items = new OrderItems($debug, $db);
	$request  = new Request;
	$utility = new Utility($debug);
	$utilityDB = new UtilityDB($debug, $db);
	
	// Get Query Parameters
	$order_number = $request->GetParam('order_number');
	$tax_rate = $request->GetParam('tax_rate');
	
	// Get List
	$orderRow = $order->GetOrder($order_number);
	$rs = $order->GetOrderItems($order_number);
	$total = $order->SummarizeOrderPrint($order_number,$tax_rate);
	
	// Type of invoice
	$code = $request->GetParam('code');
	switch ($code) {
		case 0:
			$msg = "CUSTOMER COPY";
			break;
		case 1:
			$msg = "SHOP COPY";
			break;
		case 2:
			$msg = "PACKING SLIP";
			break;
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>invoice.php</title>
	<meta name="generator" content="BBEdit 10.5" />
	<link href="css/invoice.css" media="screen, projection" rel="stylesheet" type="text/css" />
<style type="text/css" rel="stylesheet" type="text/css" >
@page
{
	size: landscape;
	margin: 2cm;	
}

h3 {background-color: #ccc; width:300px; margin:0;}

html,
body {
   margin:0;
   padding:0;
   height:100%;
   font-family: Verdana,Arial,sans-serif;
   font-size:11px;
}
#invoice {
   min-height:100%;
   position:relative;
}


#ds { position: absolute; margin:0; padding:0em; Top:0; left:0;   font-family: Verdana,Arial,sans-serif;
   font-size:14px; font-weight: bold;
 }
#custInfo {position:absolute; margin:0 padding:1em; top: 210px; left:0px; border:1px solid #ccc;padding: 0px; }
#invInfo {position:absolute; margin:0 padding:1em; top: 40px; right:0px;}
#billTo {position:absolute; margin:0 padding:1em; top: 130px; left:0px; border:1px solid #ccc;padding: 0px;}
#shipTo {position:absolute; margin:0 padding:1em; top: 130px; right:0px; border:1px solid #ccc;padding: 0px; }
#tagMsg {position: absolute; right:0px; top:-10px; }
#tagline { text-align:right; display:block;}

#items{
	width: 100%;
	font: 8px Verdana, Arial, Helvetica, sans-serif;
	border-collapse: collapse;
	margin-left:auto;
	margin-right:auto;
	position: absolute;
	top:120px;
}

#items td {
	border-bottom: 1px solid #CCC;
	padding: .30em;
	}
	
#items td+td {
	border-left: 1px solid #CCC;
	text-align: center;
	}

.labelSpan { padding:5px; margin: 5px; }
#footer {position: fixed: bottom:0;}
#logo {position: absolute; left:0px; top:0px; width:100px; display:none}

</style>
</head>
<body>
<div id="invoice">
	<div id="body">
		<div id="logo">
			<img src="images/afamlogo-RWB-2.jpg" border="0"/>
		</div>

		<div id="ds">
			Drive Systems USA Inc.</br>
			5953 Engineer Dr.</br>
			Huntington Beach, CA</br>
			92649</br>
			Ph. 714-379-9040</br>
			Fx. 714-379-9042</br>
		</div>


		<div id="invInfo">
			<strong>INVOICE#</strong> - <?php echo $orderRow['order_number']?></br>
			<strong>DATE</strong> - <?php echo $orderRow['order_date']?></br>
			<strong>CUSTOMER NUMBER</strong> - <?php echo $orderRow['customer_number']?></br>
			<strong>PURCHASE ORDER</strong> - <?php echo $orderRow['customer_po']?></br>
			<strong>PAYMENT TERMS</strong> - <?php echo $orderRow['payment_terms_id']?></br>

		</div>

		<div id="billTo">
			<h3>BILL TO ADDRESS:</h3>
			<span class="labelSpan"><?php echo $orderRow['dba']?></br></span>
			<span class="labelSpan"><?php echo $orderRow['billing_address']?></br></span>
			<span class="labelSpan"><?php echo $orderRow['billing_city']?>, <?php echo $cust['billing_state']?></br></span>
			<span class="labelSpan"><?php echo $orderRow['billing_zip']?></br></span>
			<span class="labelSpan"><?php echo $orderRow['phone1']?></br></span>
			</span>
		</div>
		<div id="shipTo">
			<h3>SHIP TO ADDRESS:</h3>
			<span class="labelSpan"><?php echo $orderRow['dba']?></br></span>
			<span class="labelSpan"><?php echo $orderRow['address']?></br></span>
			<span class="labelSpan"><?php echo $orderRow['city']?>, <?php echo $cust['state']?></br></span>
			<span class="labelSpan"><?php echo $orderRow['zip']?></br></span>
			<span class="labelSpan"><?php echo $orderRow['phone1']?></br></span>
		</div>

		<div id="items">
			<table id="items" >
				<thead>
					<tr>
						<th width="75">Part Number</th>
						<th>Description</th>
						<th width="55">FS</th>
						<th width="55">RS</th>
						<th width="30">LT</th>
						<th width="25">QTY</th>
						<th width="25">BO</th>
						<?php if($code != 2) { ?>
						<th style="text-align:right" width="50">MSRP</th>
						<th style="text-align:right" width="50">COST</th>
						<th style="text-align:right" width="50">AMT</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php while ($itemRow = $rs->fetch()) { ?>
					<tr>
						<td style="text-align:left"><?php echo $itemRow['part_number']?></td>
						<td style="text-align:left"><?php echo $itemRow['description']?></td>
						<td><?php echo $itemRow['frontSprocket_part_number']?></td>
						<td><?php echo $itemRow['rearSprocket_part_number']?></td>
						<td><?php echo $itemRow['chain_length']?></td>
						<td><?php echo $itemRow['qty']?></td>
						<td><?php echo $itemRow['bo_qty']?></td>
						<?php if($code != 2) { ?>
							<td style="text-align:right"><?php echo $utility->NumberFormat($itemRow['msrp'],'')?></td>
							<td style="text-align:right"><?php echo $utility->NumberFormat($itemRow['unit_price'],'')?></td>
					
							<td style="text-align:right"><?php echo $utility->NumberFormat($itemRow['total'],'')?></td>
						<?php } ?>
					</tr>
					<?php } ?>

			<?php if($code != 2) { ?>
					<tr><td style="border:none">&nbsp;</td></tr>
					<tr><td style="border:none">&nbsp;</td></tr>
					<tr><td style="border:none">&nbsp;</td></tr>

					<tr>
						<td colspan="7" cellpadding="5px" rowspan="4" 
							style="border-top:1px solid #ccc;border-left:none;border-bottom:none;text-align:left;vertical-align:text-top;">
							<strong>Customer Notes: </strong></br><?php echo $orderRow['special_instructions']?> </td>
						<td colspan="2" style="text-align:right; border-top:1px solid #ccc">Subtotal</td>
						<td style="text-align:right; border-top:1px solid #ccc"><?php echo $utility->NumberFormat($total['subtotal'],'$')?></td>
					</tr>
					<tr>
						<td colspan=2" style="text-align:right;border-left: 1px solid #CCC;"><?php echo $orderRow['state'] ?> Sales Tax</td>
						<td style="text-align:right"><?php echo $utility->NumberFormat($orderRow['order_tax'],'$')?> <?php echo $row['tax_rate']?></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:right;border-left: 1px solid #CCC;">Freight</td>
						<td style="text-align:right"><?php echo $utility->NumberFormat($orderRow['order_shipping'],'$')?></td>
					</tr>
				</tbody>
				<tfoot>		
					<tr>
						<td colspan="7" style="border-left: none;border-bottom:none;">&nbsp;</td>
						<td colspan="2" style="background-color:#ccc; text-align:right">TOTAL:</td>
						<td style="text-align:right"><?php echo $utility->NumberFormat($orderRow['order_total'],'$')?></td>
					</tr>
				</tfoot>

				</table>
			</div>
			<?php } ?>


		<div id="tagMsg">
			<h2 id="tagline"><?php echo $msg?></h2>
		</div>
	</div>
</div>
</body>
</html>
