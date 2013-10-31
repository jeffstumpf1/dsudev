<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />	

	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="js/reports.js"></script>

</head>
<body>
<div id="wrapper">

<div id="navigation">
		<?php
		require "inc/nav.inc.php";
		?>
	</div>
<div id="content">
	
	<!-- Customer Banner -->
	<div id="report-salesbyCustomer" >
		<fieldset class="fsReport" >
		<legend>Sales by Customer</legend>
			<div class="kitSpacers">
				<label for="from">From </label><input type="text" id="from" name="from" size="15"/> 
				<label for="to"> to </label><input type="text" id="to" name="to" size="15"/>
				<input type="text" id="customerDBA" />
			</div>
			<div class="group">
				<div id="salesbyCustomer"/>
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
</body>
</html>
