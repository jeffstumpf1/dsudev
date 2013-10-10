<?php 
	/* Print banner , Used in Ajax call
	   
	   /service/print-invoice-banner.service.php?order_number=xxx
	*/
	$debug = 'Off';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$order = new Order($debug, $db);
	$request  = new Request;

	// Get Query Parameters
	$order_number = $request->getParam('order_number');
	$tax_rate = $request->GetParam('tax_rate');
	$code = $request->GetParam('code');

?>	

<fieldset class="fsPrintInvoice">
	<legend>Print Invoices</legend>
	<class="group">
		<div style="text-align:center">
			<div class="kitSpacers">
				<a title="Print Customer Invoice" target="_BLANK" href="print-invoice.php?order_number=<?php echo $order_number?>&tax_rate=<?php echo $tax_rate?>&code=0"><div class="printCustomer"></div></a>
			</div>
			<div class="kitSpacers">
				<a title="Print Invoice for Shop" target="_BLANK" href="print-invoice.php?order_number=<?php echo $order_number?>&tax_rate=<?php echo $tax_rate?>&code=1"><div class="printShop"></div></a>
			</div>
			<div class="kitSpacers">
				<a title="Print Packing Slip" target="_BLANK" href="print-invoice.php?order_number=<?php echo $order_number?>&tax_rate=<?php echo $tax_rate?>&code=2"><div class="printPacking"></div></a>
			</div>
			<div class="kitSpacers">
				<a title="Print Pick Tickets" target="_BLANK" href="" oid="<?php echo $order_number?>"><div class="printTickets"></div></a>
			</div>
			<div class="kitSpacers">
				<a title="Email Invoice" target="_BLANK" href="service/email-invoice.service.php?order_number=<?php echo $order_number?>"><div class="emailInvoice"></div></a>
			</div>
			
		</div>
	</div>	
</fieldset>

