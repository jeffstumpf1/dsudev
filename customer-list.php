<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title>Customer Listing</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.1.min.js"><\/script>')</script>

	
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
			Customer Listing
		</h2>
		<hr />
		<div id="commandBar">
			<div id="actionBox">
			  <form action="customer.php?status=A" method="post" accept-charset="utf-8">
				<input id="createCustomer" type="submit" value="Create a new Customer" />
			  </form>
			</div>
			<div id="searchBox">
			  <form id="frmSearch">
				<input id="search" type="text" value="Customer Search" />
				<input type="button" value="Go" />
			</div>
		</div>
		<table id="customerTable">
			<tr>
				<th>Action</th>
				<th>Dealer Name</th>
				<th>City</th>
				<th>State</th>
				<th>Phone</th>
				<th>Discount %</th>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="customer.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="customer.php?id=CU009&status=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Dealer Name -->
					Huntington Honda
				</td>
				<td> <!- City -->
					Huntington Beach
				</td>
				<td> <!- State -->
					CA
				</td>
				<td> <!- Phone -->
					888 909-9090
				</td>
				<td> <!- Discount -->
					34%
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="customer.php?id=CU009&s=E"><div class="actionEdit"></div></a>
					<a href="customer.php?id=CU009&s=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Dealer Name -->
					Huntington Honda
				</td>
				<td> <!- City -->
					Huntington Beach
				</td>
				<td> <!- State -->
					CA
				</td>
				<td> <!- Phone -->
					888 909-9090
				</td>
				<td> <!- Discount -->
					34%
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="customer.php?id=CU009&s=E"><div class="actionEdit"></div></a>
					<a href="customer.php?id=CU009&s=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Dealer Name -->
					Huntington Honda
				</td>
				<td> <!- City -->
					Huntington Beach
				</td>
				<td> <!- State -->
					CA
				</td>
				<td> <!- Phone -->
					888 909-9090
				</td>
				<td> <!- Discount -->
					34%
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="customer.php?id=CU009&s=E"><div class="actionEdit"></div></a>
					<a href="customer.php?id=CU009&s=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Dealer Name -->
					Huntington Honda
				</td>
				<td> <!- City -->
					Huntington Beach
				</td>
				<td> <!- State -->
					CA
				</td>
				<td> <!- Phone -->
					888 909-9090
				</td>
				<td> <!- Discount -->
					34%
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="customer.php?id=CU009&s=E"><div class="actionEdit"></div></a>
					<a href="customer.php?id=CU009&s=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Dealer Name -->
					Huntington Honda
				</td>
				<td> <!- City -->
					Huntington Beach
				</td>
				<td> <!- State -->
					CA
				</td>
				<td> <!- Phone -->
					888 909-9090
				</td>
				<td> <!- Discount -->
					34%
				</td>
			</tr>
			
		</table>
	

	
	
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
</body>
</html>
