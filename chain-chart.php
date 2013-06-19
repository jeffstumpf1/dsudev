<?php 
    $DOCUMENT_ROOT="";
	$pitch="";
	if(isset($_GET['pitch'])) {
		$pitch = (get_magic_quotes_gpc()) ? $_GET['pitch'] : addslashes($_GET['pitch']);
	}
?>
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
			<?php echo($pitch);?> - Chain Chart
		</h2>
		<hr />
		<div id="commandBar">
			<div id="actionBox">
			  <form id="frmAction">
		  		<label>Action:</label>
				<select>
					<option value="N">New <?php echo($pitch);?> Chain</option>
					<option value="E">Edit <?php echo($pitch);?> Chain</option>
					<option value="D">Delete <?php echo($pitch);?> Chain</option>
				</select>
				<input type="button" value="Go" />
			  </form>
			</div>

		</div>
		<table id="chainChartTable">
			<tr>
				<th>Action</th>
				<th style="text-align:left;">Chain Description</th>
				<th>MSRP</th>
				<th>Dealer Cost</th>
				<th>Import Cost</th>
			</tr>
			<tr class="row">
				<td><!- Action -->
					<input type="checkbox" value="0" />
				</td>
				<td> <!- Chain Description -->
					xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
				</td>
				<td> <!- MSRP -->
					$0.00
				</td>
				<td> <!- Dealer Cost -->
					$0.00
				</td>
				<td> <!- Import Cost -->
					$0.00
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
