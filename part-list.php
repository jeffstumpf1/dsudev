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
			Part Listing
		</h2>
		<hr />
		<div id="commandBar">
			<div id="actionBox">
			  <form id="frmAction">
		  		<label>Action:</label>
				<select>
					<option value="FS">New Front Sprocket</option>
					<option value="RS">New Rear Sprocket</option>
					<option value="CH">New Chain</option>
					<option value="KT">New Kit</option>
					<option value="OT">New Other</option>
				</select>
				<input type="button" value="Go" />
			  </form>
			</div>
			<div id="searchBox">
			  <form id="frmSearch">
				<input id="search" type="text" value="Part Search" />
				<input type="button" value="Go" />
			</div>
		</div>
		<table id="partTable">
			<tr>
				<th>Action</th>
				<th>Part Number</th>
				<th>Description</th>
				<th>Size</th>
				<th>Pitch</th>
				<th>Brand</th>
				<th>MSRP</th>
				<th>Dealer Cost</th>
				<th>Import Cost</th>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="sprocket.php?id=CU009&status=E&cat=FS"><div class="actionEdit"></div></a>
					<a href="sprocket.php?id=CU009&status=D&cat=FS"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Part Number -->
					21603R-15
				</td>
				<td> <!- Description -->
					Superlite 520 Drilled Race C/S
				</td>
				<td> <!- Size -->
					15
				</td>
				<td> <!- Pitch -->
					520
				</td>
				<td> <!- Brand -->
					Superlite
				</td>
				<td> <!- MSRP -->
					$33.95
				</td>
				<td> <!- Dealer Cost -->
					$22.07
				</td>
				<td> <!- Import Cost -->
					$4.50
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="chain.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="chain.php?id=CU009&status=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Part Number -->
					21603R-15
				</td>
				<td> <!- Description -->
					Chain 520 Drilled Race C/S
				</td>
				<td> <!- Size -->
					15
				</td>
				<td> <!- Pitch -->
					520
				</td>
				<td> <!- Brand -->
					Superlite
				</td>
				<td> <!- MSRP -->
					$33.95
				</td>
				<td> <!- Dealer Cost -->
					$22.07
				</td>
				<td> <!- Import Cost -->
					$4.50
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="part.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="part.php?id=CU009&status=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Part Number -->
					21603R-15
				</td>
				<td> <!- Description -->
					Superlite 520 Drilled Race C/S
				</td>
				<td> <!- Size -->
					15
				</td>
				<td> <!- Pitch -->
					520
				</td>
				<td> <!- Brand -->
					Superlite
				</td>
				<td> <!- MSRP -->
					$33.95
				</td>
				<td> <!- Dealer Cost -->
					$22.07
				</td>
				<td> <!- Import Cost -->
					$4.50
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="part.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="part.php?id=CU009&status=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Part Number -->
					21603R-15
				</td>
				<td> <!- Description -->
					Superlite 520 Drilled Race C/S
				</td>
				<td> <!- Size -->
					15
				</td>
				<td> <!- Pitch -->
					520
				</td>
				<td> <!- Brand -->
					Superlite
				</td>
				<td> <!- MSRP -->
					$33.95
				</td>
				<td> <!- Dealer Cost -->
					$22.07
				</td>
				<td> <!- Import Cost -->
					$4.50
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="part.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="part.php?id=CU009&status=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Part Number -->
					21603R-15
				</td>
				<td> <!- Description -->
					Superlite 520 Drilled Race C/S
				</td>
				<td> <!- Size -->
					15
				</td>
				<td> <!- Pitch -->
					520
				</td>
				<td> <!- Brand -->
					Superlite
				</td>
				<td> <!- MSRP -->
					$33.95
				</td>
				<td> <!- Dealer Cost -->
					$22.07
				</td>
				<td> <!- Import Cost -->
					$4.50
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="part.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="part.php?id=CU009&status=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Part Number -->
					21603R-15
				</td>
				<td> <!- Description -->
					Superlite 520 Drilled Race C/S
				</td>
				<td> <!- Size -->
					15
				</td>
				<td> <!- Pitch -->
					520
				</td>
				<td> <!- Brand -->
					Superlite
				</td>
				<td> <!- MSRP -->
					$33.95
				</td>
				<td> <!- Dealer Cost -->
					$22.07
				</td>
				<td> <!- Import Cost -->
					$4.50
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="part.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="part.php?id=CU009&status=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Part Number -->
					21603R-15
				</td>
				<td> <!- Description -->
					Superlite 520 Drilled Race C/S
				</td>
				<td> <!- Size -->
					15
				</td>
				<td> <!- Pitch -->
					520
				</td>
				<td> <!- Brand -->
					Superlite
				</td>
				<td> <!- MSRP -->
					$33.95
				</td>
				<td> <!- Dealer Cost -->
					$22.07
				</td>
				<td> <!- Import Cost -->
					$4.50
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="part.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="part.php?id=CU009&status=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Part Number -->
					21603R-15
				</td>
				<td> <!- Description -->
					Superlite 520 Drilled Race C/S
				</td>
				<td> <!- Size -->
					15
				</td>
				<td> <!- Pitch -->
					520
				</td>
				<td> <!- Brand -->
					Superlite
				</td>
				<td> <!- MSRP -->
					$33.95
				</td>
				<td> <!- Dealer Cost -->
					$22.07
				</td>
				<td> <!- Import Cost -->
					$4.50
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="part.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="part.php?id=CU009&status=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Part Number -->
					21603R-15
				</td>
				<td> <!- Description -->
					Superlite 520 Drilled Race C/S
				</td>
				<td> <!- Size -->
					15
				</td>
				<td> <!- Pitch -->
					520
				</td>
				<td> <!- Brand -->
					Superlite
				</td>
				<td> <!- MSRP -->
					$33.95
				</td>
				<td> <!- Dealer Cost -->
					$22.07
				</td>
				<td> <!- Import Cost -->
					$4.50
				</td>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<a href="part.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="part.php?id=CU009&status=D"><div class="actionStatus"></div></a>
				</td>
				<td> <!- Part Number -->
					21603R-15
				</td>
				<td> <!- Description -->
					Superlite 520 Drilled Race C/S
				</td>
				<td> <!- Size -->
					15
				</td>
				<td> <!- Pitch -->
					520
				</td>
				<td> <!- Brand -->
					Superlite
				</td>
				<td> <!- MSRP -->
					$33.95
				</td>
				<td> <!- Dealer Cost -->
					$22.07
				</td>
				<td> <!- Import Cost -->
					$4.50
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
