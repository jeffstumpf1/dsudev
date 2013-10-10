<?php 
	$debug = 'Off';
	require_once 'db/global.inc.php';
	
	function __autoload($class) {
		include 'classes/' . $class . '.class.php';
	}
	
	// Create Objects
	$constants = new Constants;
	$part = new Part($debug, $db);
	$request  = new Request;
	$utility = new Utility($debug);
	$utilityDB = new UtilityDB($debug, $db);
	
	// Get Query Parameters
	$status  = $request->getParam('status','');
	$recMode = $request->getParam('cat','');
	$search  = $request->getParam('search','');

	// Get List
	$rs = $part->ListParts($search);

?>
<!DOCTYPE>
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<meta charset="utf-8" />
	<title>Part Listing</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>	
  	<script src="js/part.js"></script>
<script>
	// Selects Chains based on pitch
	$(function () {
		$("#radio").buttonset();
		$cat='';
		$("input[name='cat']").on("change", function () {
			$cat = $(this).val();
			$('#search').val($cat);
			$('#frmActionCat').submit();
		});

	});    		

</script>
</head>
<body>

<div id="dialog-confirm" title="">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>This part will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>

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
<div id="wrapper">
		<h2>
		 <?php echo "Part Listing - [ ".  $rs->size() ." ]"; ?>
		</h2>
		<hr />
		<div id="commandBar">
			<div id="actionBox">
			  <form id="frmAction" name="frmAction" method="post" action="create-part.php">
		  		<label>Action:</label>
				<select id="category" name="category">
				<option value="*">Select...</option>
				<?php
				 echo $utilityDB->LookupList('', Constants::TABLE_CATEGORY_LIST);   
				?>
				</select>
				<input id="createSubmit" name="createSubmit" type="submit" value="Go" />
			  </form>
			</div>
			
		<div id="searchBox">
			<form id="frmActionCat" method="get" action="<?php echo $_PHP_SELF?>">
				<div id="radio">
					<input id="r1" type="radio" class="radioPitch" name="cat" value="KT" />
					<label for="r1">Chain Kits</label>
					<input id="r2" type="radio" class="radioPitch" name="cat" value="FS" />
					<label for="r2">Front Sprockets</label>
					<input id="r3" type="radio" class="radioPitch" name="cat" value="RS" />
					<label for="r3">Rear Sprockets</label>
					<input id="r4" type="radio" class="radioPitch" name="cat" value="CH" />
					<label for="r4">Chains</label>
					<input id="r5" type="radio" class="radioPitch" name="cat" value="CR" />
					<label for="r5">Carriers</label>
					<input id="r6" type="radio" class="radioPitch" name="cat" value="RI" />
					<label for="r6">Rims</label>
					<input id="r7" type="radio" class="radioPitch" name="cat" value="OT" />
					<label for="r7">Other</label>
					
				</div>
				<input type="hidden" id="search" value="" name="search"/>
			  </form>
		  
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
				<th>Category</th>
				<th>Pitch</th>
				<th>Stock</th>
				<th>MSRP</th>
				<th>Dealer Cost</th>
				<th>Import Cost</th>
			</tr>
			<tr class="row">
				<?php while ($row = $rs->fetch()) { 
				$page=''; 
				switch ( $row['category_id'] ) {
					case 'FS';
						$page = 'sprocket.php';
						break;
					case 'RS':
						$page = 'sprocket.php';
						break;
					case 'CH':
						$page = 'chain.php';
						break;
					case 'KT':
						$page = 'kit.php';
						break;
					case 'OT' || 'CR' || 'RI':
						$page = "other.php";
				}						
	
				?>
				
				 
				<td><!-- Action -->
<?php include 'inc/action-logic.inc.php'?>
				</td>
				<td style="text-align:left;"> <!-- Part Number -->
					<?php echo $row['part_number'] ?>
				</td>
				<td style="text-align:left;padding-left:1em;"> <!-- Description -->
					<?php echo stripslashes($row['part_description']) ?>
				</td>
				<td> <!-- Category -->
					<?php echo $row['category_id'] ?>
				</td>
				<td> <!-- Pitch -->
					<?php echo $row['pitch_id'] ?>
				</td>
				<td> <!-- Stock Level -->
					<?php echo $row['stock_level'] ?>
				</td>
				<td> <!-- MSRP -->
					<?php echo $utility->NumberFormat( $row['msrp'], '$') ?>
				</td>
				<td> <!-- Dealer Cost -->
					<?php echo $utility->NumberFormat($row['dealer_cost'], '$') ?>
				</td>
				<td> <!-- Import Cost -->
					<?php echo $utility->NumberFormat($row['import_cost'], '$') ?>
				</td>
			</tr>
			<?php }  ?>
		</table>
	
	
	
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
</body>
</html>
