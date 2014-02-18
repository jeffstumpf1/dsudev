<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />	

	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="js/reports.js"></script>
<style type="text/css" media="print">
	#navigation,
	#report-salesbyCustomer, 
	#report-salesbyCustomerDate ,
	#report-franchiseTaxSales
	{ display:none; }
	
</style>

</head>
<body>
<div id="wrapper">

<div id="navigation">
		<?php
		require "inc/nav.inc.php";
		?>
	</div>
<div id="content">
		<div id="report-salesbyCustomer" >
		<fieldset class="fsReport" >
		<legend>Sales by Customer YTD</legend>
			<div class="kitSpacers">
				<input type="text" id="customerDBA" style="width: 250px;" />
				<input type="hidden" id="customerNumber" />   
			</div>
			<div class="group">
				<div id="salesbyCustomer"/>
			</div>
		</fieldset>
	</div>
	<div id="report-salesbyCustomerDate" >
		<fieldset class="fsReport" >
		<legend>Sales by Customer Date</legend>
			<div class="kitSpacers">
				<label for="from">From </label><input type="text" id="from" name="from" size="15"/> 
				<label for="to"> to </label><input type="text" id="to" name="to" size="15"/>
				<input type="button" id="button-salesbyCustomerDate" value="Get Report" />
			</div>
			<div class="group">
				<div id="salesbyCustomerDate"/>
			</div>
		</fieldset>
	</div>
	
</div>

<div id="rightCol" style="float:left; padding:10px;">
	<div id="report-allSales" >
		<fieldset class="fsReport" >
		<legend>Get All Sales by Date</legend>
			<div class="kitSpacers">
				<label for="from">From </label><input type="text" id="fromAll" name="fromAll" size="15"/> 
				<label for="to"> to </label><input type="text" id="toAll" name="to" size="15"/>
				<label for="typeDlr">Type </label>
				<select id="typeDlr" name="typeDlr">
					<option value="D">Dealer</option>
					<option value="R">Retail</option>
					<option value="W">Wholesale</option>
				</select>
				<input type="button" id="button-allSales" value="Get Report" />
			</div>
			<div class="group">
				<div id="allSales"/>
			</div>
		</fieldset>
	</div>
	
	<div id="report-franchiseTaxSales" >
		<fieldset class="fsReport" >
		<legend>Franchise Sales Tax</legend>
			<div class="kitSpacers">
				<label for="from">From </label><input type="text" id="fromAllTax" name="fromAllTax" size="15"/> 
				<label for="to"> to </label><input type="text" id="toAllTax" name="toTax" size="15"/>
				<input type="button" id="button-franchiseSales" value="Get Report" />
			</div>
			<div class="group">
				<div id="franchiseTaxSales"/>
			</div>
		</fieldset>
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
</body>
</html>
