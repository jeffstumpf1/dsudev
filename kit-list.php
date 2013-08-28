<?php
	$debug = 'Off';
	require_once 'db/global.inc.php';
	
	function __autoload($class) {
		include 'classes/' . $class . '.class.php';
	}
	
	// Create Objects
	$constants = new Constants;
	$part = new part($debug, $db);
	$request  = new Request;
	$utility = new Utility($debug);
	
	// Get Query Parameters
	$status  = $request->getParam('status','');
	$search  = $request->getParam('search','');

	// Get List
	$rs = $part->ListKits($search);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title>Chain Kit Listing</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.1.min.js"><\/script>')</script>
<script>
$(function() {
    	
    	
		$( "#search" ).live('mouseup', function() {
			 $(this).select(); 	
		});

		
});
</script>
	
</head>
<body>
<div id="wrapper">
	<div id="header">
		<h1>
			Drive Systems
		</h1>
	</div>
	<div id="navigation">
		<?php
		require "inc/nav.inc.php";
		?>
	</div>
<div id="">
		<h2>
		 <?php echo "Chain Kit Listing - [ ".  $rs->size() ." ]"; ?>
		</h2>
		<hr />
		<div id="commandBar">

			<div id="searchBox">
			  <form id="frmSearch">				
				<input id="search" name="search" type="text" value="<?php echo $search ?>" />
				<input type="submit" value="Search" />
			</div>
		</div>
		<table id="partTable">
			<tr>
				<th>Action</th>
				<th>Part Number</th>
				<th style="text-align:left;padding-left:1em">Description</th>
				<th>Pitch</th>
				<th>Front Sprocket</th>
				<th>Rear Sprocket</th>
				<th>Chain Length</th>
				<th>MSRP</th>
				<th>Dealer Cost</th>
				<th>Import Cost</th>
			</tr>
			<tr class="row">


				<?php 

				Do {
					// sum up the sprockets
					$msrp =0;
					$dealer_cost=0;
					$import_cost=0;
					$psql = "select msrp, dealer_cost, import_cost FROM PartMaster WHERE part_number IN ('". $row['frontSprocket_part_number']."','".$row['rearSprocket_part_number'] ."')";
					$fs = $db->query($psql); 
					while ($fsrow = $fs->fetch() ){
						$msrp = $msrp  + $fsrow['msrp'];
						$dealer_cost = $dealer_cost + $fsrow['dealer_cost'];
						$import_cost = $import_cost + $fsrow['import_cost'];
					}
					if($debug=="On") {
						echo $psql. "<br>";
						echo 'msrp:'.$msrp.' dealer_cost:'. $dealer_cost. ' import_cost:' . $import_cost.'<br>';
					}
					$page='kit-pricing.php'; 
					
				?>
				<td><!-- Action -->
					<a href="
						<?php echo $page; ?>?part_id=<?php echo $row['part_id'];?>"><div class="actionCalculator"></div></a>
					<!--<a href="<?php echo $page; ?>?part_id=<?php echo $row['part_id'];?>&status=D&cat=<?php echo $row['category_id']?>"><div class="actionStatus"></div></a>-->
				</td>
				<td style="text-align:left;"> <!-- Part Number -->
					<?php echo $row['part_number'] ?>
				</td>
				<td style="text-align:left;padding-left:1em;"> <!-- Description -->
					<?php echo $row['part_description'] ?>
				</td>

				<td> <!-- Pitch -->
					<?php echo $row['pitch_id'] ?>
				</td>
				<td> <!-- Front Sprocket Part -->
					<?php echo $row['frontSprocket_part_number'] ?>
				</td>
				<td> <!-- Rear Sprocket Part -->
					<?php echo $row['rearSprocket_part_number'] ?>
				</td>
				<td> <!-- Chain Length -->
					<?php echo $row['chain_length'] ?>
				</td>				
				<td> <!-- MSRP -->
					<?php echo $utility->NumberFormat($msrp, '$') ?>
				</td>
				<td> <!-- Dealer Cost -->
					<?php echo $utility->NumberFormat($dealer_cost, '$') ?>
				</td>
				<td> <!-- Import Cost -->
					<?php echo $utility->NumberFormat($import_cost, '$') ?>
				</td>
			</tr>
			<?php } while ($row = $rs->fetch( $rs )); ?>
		</table>
	
	
	
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
</body>
</html>
