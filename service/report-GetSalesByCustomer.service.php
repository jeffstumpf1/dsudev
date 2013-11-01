<?php 
	/* Sales by Customer , Used in Ajax call
	   /service/report-GetSalesByCustomer.service.php
	*/
	$debug = 'Off';
	require_once '../db/global.inc.php';

 	// Start logging
	include '../log4php/Logger.php';
	Logger::configure('../logconfig.xml');
	$log = Logger::getLogger('myLogger');
	
	spl_autoload_register(function ($class) {
		include '../classes/' . $class . '.class.php';
	});   
   

   	// Create Object Customer and Request
	$constants = new Constants;
	$report = new Report($debug, $db);
	$request  = new Request;
	$utility  = new Utility($debug);

	// Get Query Parameters
	$customer_number  = $request->getParam('customer_number');
	$from = $request->getParam('from');
	$to = $request->getParam('to');
	$flag = $request->getParam('flag');

	if(!$from && !$to) {
		//echo "1";
		$rs = $report->GetSalesByCustomer( $customer_number );
		$total = $report->GetSalesByCustomerTotals( $customer_number );
	} else if ($customer_number) {
		//echo "2";
		$rs = $report->GetSalesByCustomerDate( $customer_number, $from, $to);
		$total = $report->GetSalesByCustomerTotalsDate( $customer_number, $from, $to);
	} else if ($flag) {
		$row = $report->GetFranchiseTaxSales( $flag, $from, $to);
		//print_r($row);
	} else {
		//echo "3";
		$rs = $report->GetAllSales( $from, $to );
		$total = $report->GetAllSalesTotalDate( $from, $to);
	}
	//print_r($total);
	//$row['Subtotal'];
?>	

<?php if (!$flag) { ?>
<table id="partTable" style="width:425px">
	<tr >
		<th style="text-align:left;">Customer</th>
		<th>Date</th>
		<th style="text-align:center;">Orders</th>
		<th style="text-align:right;">Subtotal</th>
		<th style="text-align:right;">Shipping</th>
		<th style="text-align:right;">Taxes</th>
		<th style="text-align:right;">Total</th>		
	</tr>
<?php	 while ($row = $rs->fetch()) { ?>
	<tr class="row">
		<td nowrap="true" style="text-align:left;"><?php echo $row['dba'] ?></td>
		<td style="text-align:center;"><?php echo $row['order_date'] ?></td>
		<td style="text-align:center;"><?php echo $row['Count'] ?></td>
		<td style="text-align:right;"><?php echo $utility->NumberFormat( $row['Subtotal'],'$') ?></td>
		<td style="text-align:right;"><?php echo $utility->NumberFormat( $row['Shipping'],'$') ?></td>
		<td style="text-align:right;"><?php echo $utility->NumberFormat( $row['Tax'],'$') ?></td>
		<td style="text-align:right;"><?php echo $utility->NumberFormat( $row['Total'],'$') ?></td>
	</tr>
  <?php    } ?>
  	<tr style="font-weight: normal; color:#666">
		<td ></td>
		<td style="text-align:right;">Totals:</td>
		<td style="text-align:center;"><?php echo $total['Count'] ?></td>
		<td style="text-align:right;"><?php echo $utility->NumberFormat( $total['Subtotal'],'$') ?></td>
		<td style="text-align:right;"><?php echo $utility->NumberFormat( $total['Shipping'],'$') ?></td>
		<td style="text-align:right;"><?php echo $utility->NumberFormat( $total['Tax'],'$') ?></td>		
		<td style="text-align:right;"><?php echo $utility->NumberFormat( $total['Total'],'$') ?></td>		
  	</tr>	
</table>

<?php } else { ?>

<table id="partTable" style="width:250px">
	<tr >
		<th style="text-align:right;">Taxable Sales</th>
		<th style="text-align:right;">Tax Collected</th>
	</tr>
	<tr class="row">
		<td style="text-align:right;"><?php echo $utility->NumberFormat( $row['Subtotal'],'$') ?></td>
		<td style="text-align:right;"><?php echo $utility->NumberFormat( $row['Tax'],'$') ?></td>
	</tr>
</table>
<?php } ?>

