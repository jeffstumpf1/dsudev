<?php 
    if ( isset($_POST['formAction']) ) { header("Location: part-list.php"); }
    
	$debug = 'Off';
	require_once 'db/global.inc.php';
	
	function __autoload($class) {
		include 'classes/' . $class . '.class.php';
	}
	
	// Create Object Customer and Request
	$constants = new Constants;
	$sprocket = new Sprocket($debug, $db);
	$request  = new Request;
	$utilityDB = new UtilityDB($debug, $db);
	$utility  = new Utility($debug);

	// Get Query Parameters
	$recMode  = $request->getParam('status');
	$search  = $request->getParam('search');
	$part_id = $request->getParam('part_id');
	$action  = $request->getParam('formAction');
	$partCat = $request->getParam('cat');



	// Was form Submitted?
	if ($action) {
		if($recMode == "E" || $recMode == "A") {
			$sprocket->UpdateSprocket( $_POST['frm'], $recMode );
		} else if ($recMode == "D") {
			$sprocket->UpdateSprocketStatus($_POST['frm']);
		}		
	}

	if ($recMode == "E"){
		// Get Info and Display
		$row = $sprocket->GetSprocket($part_id);
		//print_r($row);
	}

/**
	$d=$row['part_description'];
	$e=$row['part_application'];
	echo "<p>",$d,"</p>";
	echo "<p>",$e, "</p>";
	$d = json_encode(addslashes($d));
	$e = json_encode(addslashes($e));
	echo $d;
	echo $e;
	$d= json_decode($d);
	$e= json_decode($e);
	echo "<p>",$d,"</p>";
	echo "<p>",$e,"</p>";
*/
	
	// Setup the case
	switch ( strtolower($recMode) )  {
	    case "a":
	        $revViewDesc = "Adding Sprocket";
	        break; 
		case "d":	
			$revViewDesc = "Making Sprocket Inactive";
			break;
		case "e":
			$revViewDesc = "Updating Sprocket information";
			break;
		}
	
	
	switch (strtolower($partCat)) {
		case "fs":
			$partTypeDesc = "Front";
			break;
		case "rs":
			$partTypeDesc = "Rear";
			break;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title><?php echo($partCat)?> Sprocket Maintenance</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
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
			<?php echo($partTypeDesc)?> Sprocket Maintenance
		</h2>
		<hr />
	
		<div id="">
		   <form id="formSprocket" name="formSprocket" method="post" action="<?php echo $_PHP_SELF; ?>" >
 			<table id="tablePartMaint" align="center" style="width:950px">
				<tr>
					<td> 
						<Label>Product Category</label>
					</td>
					<td colspan="3">
						<select id="productCategory" name="frm[productCategory]">
						<?php 
							if($row['category_id'] == "FS" || $partCat == "FS") { 
								echo("<option value='FS' SELECTED>Front Sprocket</option>");
								} else {
								echo ("<option value='FS'>Front Sprocket</option>");
							}
							if($row['category_id'] == "RS" || $partCat == "RS") { 
								echo("<option value='RS' SELECTED>Rear Sprocket</option>");
								} else {
								echo ("<option value='RS'>Rear Sprocket</option>");
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label>Part Number</label>
					</td>
					<td>
<?php
include 'inc/part_logic.inc.php';
?>						
					</td>
					<td align="right">
						<label>Stock Level</label>
					</td>
					<td>
						<input id="stockLevel" name="frm[stockLevel]" type="text" value="<?php echo $row['stock_level']?>"/>
					</td>
				</tr>
<!--				<tr>
					<td>
						<label>Size</label>
					</td>
					<td colspan="3">
						<input id="size" name="frm[size]" type="text" value="<?php echo $row['sprocket_size']?>"/>
					</tr>
				</tr>  -->
				<tr>
					<td>
						<label>Pitch</label>
					</td>
					<td colspan="3">
<?php 
include 'inc/pitch-list.inc.php';
?>			
				</tr>
				</tr>
				<tr>
					<td>
						<label>Product Brand</label>
					</td>
					<td colspan="3">
<?php 
include 'inc/brand-list.inc.php';
?>	
				</tr>
				</tr>
				<tr>
					<td valign="top">
						<label>Application</label>
					</td>
					<td colspan="3">
						<textarea id="partApplication" name="frm[partApplication]"><?php echo stripslashes($row['part_application'])?></textarea>
					</td>
				</tr>				
				
				<tr>
					<td>
						<label>Description</label>
					</td>
					<td colspan="3">
						<input id="partDescription" name="frm[partDescription]" type="text" value="<?php echo stripslashes($row['part_description'])?>"/>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Notes</label>
					</td>
					<td colspan="3">
						<textarea id="notes" name="frm[notes]"><?php echo $row['sprocket_notes']?></textarea>
					</tr>
				</tr>				
				<tr>
					<td>
						<label>MSRP</label>
					</td>
					<td colspan="3">
						<input id="msrp" name="frm[msrp]" type="text" value="<?php echo $row['msrp']?>"/>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Dealer Cost</label>
					</td>
					<td colspan="3">
						<input id="dealerCost" name="frm[dealerCost]" type="text" value="<?php echo $row['dealer_cost']?>"/>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Import Cost</label>
					</td>
					<td colspan="3">
						<input id="importCost" name="frm[importCost]" type="text" value="<?php echo $row['import_cost']?>"/>
					</tr>
				</tr>	
				<tr>
					<td>
						<label>Status</label>
					</td>
					<td>
						<span class="statusMessage"><?php echo $utility->GetRecStatus( $row['rec_status'] );?></span>
					</td>
				</tr>
														
			</table>
		</div>
		<hr/>
		<div id="formCommands">
			<?php
			require "inc/formCommand.inc.php";
			?>

		<input id="partID" name="frm[partID]" value="<?php echo $part_id ?>" type="hidden"/>
		<input id="sprocketID" name="frm[sprocketID]" value="<?php echo $row['sprocket_id'] ?>" type="hidden"/>	
		<input id="recsStatus" name="frm[recStatus]" value="<?php echo $row['rec_status'] ?>" type="hidden"/>	
		</div>
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
</form>

</body>
</html>
