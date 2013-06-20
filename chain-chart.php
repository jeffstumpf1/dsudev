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
  	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script>
		$(function() {
			
			// Selects Chains based on pitch
			$(function () {
			    $("#radio").buttonset();

			    $("input[name='pitch']").on("change", function () {
			        $pitch = $(this).val();
					$("#pitchNumber").html($pitch + " - Chain Chart");
			    });

			});    		

  		});
    </script>
	
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
			<label id="pitchNumber" /> 
		</h2>
		<hr />
		<div id="commandBar">
			<div id="actionBox">
			  <form id="frmAction">
		  		<label>Select Pitch Options:</label>
				<div id="radio">
					<input id="r1" type="radio" class="radioPitch" name="pitch" value="420" />
					<label for="r1">420</label>
					<input id="r2" type="radio" class="radioPitch" name="pitch" value="428" />
					<label for="r2">428</label>
					<input id="r3" type="radio" class="radioPitch" name="pitch" value="520" checked="checked" />
					<label for="r3">520</label>
					<input id="r4" type="radio" class="radioPitch" name="pitch" value="525" />
					<label for="r4">525</label>
					<input id="r5" type="radio" class="radioPitch" name="pitch" value="530" />
					<label for="r5">530</label>
				</div>
			  </form>
			  <br />
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
					<a href="chain-chart.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="chain-chart.php?id=CU009&status=D"><div class="actionStatus"></div></a>
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
			<tr class="row">
				<td><!- Action -->
					<a href="chain-chart.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="chain-chart.php?id=CU009&status=D"><div class="actionStatus"></div></a>
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
			<tr class="row">
				<td><!- Action -->
					<a href="chain-chart.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="chain-chart.php?id=CU009&status=D"><div class="actionStatus"></div></a>
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
			<tr class="row">
				<td><!- Action -->
					<a href="chain-chart.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="chain-chart.php?id=CU009&status=D"><div class="actionStatus"></div></a>
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
			<tr class="row">
				<td><!- Action -->
					<a href="chain-chart.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="chain-chart.php?id=CU009&status=D"><div class="actionStatus"></div></a>
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
			<tr class="row">
				<td><!- Action -->
					<a href="chain-chart.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="chain-chart.php?id=CU009&status=D"><div class="actionStatus"></div></a>
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
			<tr class="row">
				<td><!- Action -->
					<a href="chain-chart.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="chain-chart.php?id=CU009&status=D"><div class="actionStatus"></div></a>
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
			<tr class="row">
				<td><!- Action -->
					<a href="chain-chart.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="chain-chart.php?id=CU009&status=D"><div class="actionStatus"></div></a>
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
			<tr class="row">
				<td><!- Action -->
					<a href="chain-chart.php?id=CU009&status=E"><div class="actionEdit"></div></a>
					<a href="chain-chart.php?id=CU009&status=D"><div class="actionStatus"></div></a>
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
