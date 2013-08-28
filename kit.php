<?php 
    if ( isset($_POST['formAction']) ) { header("Location: part-list.php"); }
    
	$debug = 'Off';
	require_once 'db/global.inc.php';
	
	function __autoload($class) {
		include 'classes/' . $class . '.class.php';
	}
	
	// Create Object Customer and Request
	$constants = new Constants;
	$kit = new Kit($debug, $db);
	$request  = new Request;
	$utilityDB = new UtilityDB($debug, $db);
	$utility  = new Utility($debug);

	// Get Query Parameters
	$recMode  = $request->getParam('status','');
	$search  = $request->getParam('search','');
	$part_id = $request->getParam('part_id');
	$action  = $request->getParam('formAction','');

	if ($recMode == "E"){
		// Get Info and Display
		$row = $kit->GetChainKit($part_id);
	}

	// Was form Submitted?
	if ($action) {
		if($recMode == "E" || $recMode == "A") {
			$kit->UpdateChainKit( $_POST['frm'], $recMode );
		} else if ($recMode == "D") {
			$kit->UpdateChainKitStatus($_POST['frm']);
		}		
	}

	
	// Setup the case
	switch ( strtolower($recMode ) ) {
	    case "a":
	        $recStatusDesc = "Adding new Kit";
	        break; 
		case "d":	
			$recStatusDesc = "Making Kit Inactive";
			break;
		case "e":
			$recStatusDesc = "Updating Kit information";
			break;
		}
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title><?php echo($partCat)?>Chain Maintenance</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>	
  	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<link href="css/square/square.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.icheck.js"></script>
	<script type="text/javascript" src="js/jquery.blockUI.js"></script>
	<script type="text/javascript" src="js/kit.js"></script>
	<script type="text/javascript" src="js/ui.js"></script>
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
		require  "inc/nav.inc.php";
		?>
	</div>
	<div id="">
	
		<h2>
			<?php echo($recStatusDesc)?> <hr />
		</h2>
		
				<div id="KitContent">
			<fieldset>
				<legend>Chain Kt</legend>
				
					<table width="100%">
						<tr>
							<th nowrap>Part Description</th>
							<th nowrap>MSRP</th>
							<th nowrap>Dealer Cost</th>
							<th nowrap>Import Cost</th>
						</tr>
						<tr>
							<td width="25%" nowrap>Front Sprocket</td>
							<td id="fsMSRP" style="text-align:right"><?php echo $utility->NumberFormat($row['msrp'])?></td>
							<td id="fsDealer" style="text-align:right"><?php echo $utility->NumberFormat($row['dealer_cost'])?></td>
							<td id="fsImport" style="text-align:right"><?php echo $utility->NumberFormat($row['import_cost'])?></td>
						</tr>
						<tr>
							<td width="25%">Rear Sprocket</td>
							<td id="rsMSRP" style="text-align:right"><?php echo $utility->NumberFormat($row['msrp'])?></td>
							<td id="rsDealer" style="text-align:right"><?php echo $utility->NumberFormat($row['dealer_cost'])?></td>
							<td id="rsImport" style="text-align:right"><?php echo $utility->NumberFormat($row['import_cost'])?></td>
						</tr>
						<tr>
							<td width="25%">Chain Length</td>
							<td id="clMSRP" style="text-align:right"><?php echo $utility->NumberFormat($row['msrp'])?></td>
							<td id="clDealer" style="text-align:right"><?php echo $utility->NumberFormat($row['dealer_cost'])?></td>
							<td id="clImport" style="text-align:right"><?php echo $utility->NumberFormat($row['import_cost'])?></td>
						</tr>
						<tr>
							<td width="25%">Total</td>
							<td id="totalMSRP" style="text-align:right"></td>
							<td id="totalDealer" style="text-align:right"></td>
							<td id="totalImport" style="text-align:right"></td>
						</tr>
					</table>
			</fieldset>
		</div>


		<div id="">
		<form id="formChainKit" name="formChainKit" method="post" >
			<div class="group">
				<div class="kitSpacers">
					<label class="titleTop" style="margin-left:0">Chain Kit Part Number</label><br/>
<?php
include 'inc/part_logic.inc.php';
?>					
				</div>
				<div class="kitSpacers">
					<label class="titleTop" for="stockLevel">Stock Level</label><br/>
					<input id="stockLevel"  name="frm[stockLevel]" type="text" value="<?php echo $row['stock_level']?>" />
				</div>
				
			</div>
			<div class="group">
				<div class="kitSpacers">
					<label class="titleTop" for="pitch">Pitch</label><br/>
<?php 
include 'inc/pitch-list.inc.php';
?>
				</div>
				<div class="kitSpacers">
					<label class="titleTop" for="brand">MFG</label><br/>
<?php 
include 'inc/brand-list.inc.php';
?>
				</div>
				<div class="kitSpacers">
					<label class="titleTop" for="clip">Masterlink</label><br/>
<?php 
include 'inc/clip-list.inc.php';
?>
				</div>

			</div>
			<div class="group">
				<div class="kitSpacers">
					<label class="titleTop" for="fsPartNumber">Front Sprocket</label><br/>
					<input id="fsPartNumber"  name="frm[fsPartNumber]" type="text" value="<?php echo $row['frontSprocket_part_number']?>" />
				</div>
				
				<div class="kitSpacers">
					<label  class="titleTop" for="rsPartNumber">Rear Sprocket</label><br/>
					<input id="rsPartNumber"  name="frm[rsPartNumber]" type="text" value="<?php echo $row['rearSprocket_part_number']?>" />
				</div>
				<div class="kitSpacers">
					<label  class="titleTop" for="chainLength">Chain Length</label><br/>
					<input id="chainLength"  name="frm[chainLength]" type="text" value="<?php echo $row['chain_length']?>" />
				</div>

			</div>
			<div class="group">
			</div>
			<div class='group'>
				<div class="kitSpacersDesc">	
					<label class="titleTop" style="margin-left:0" for="partApplication">Application</label>
					<textarea id="partApplication" name="frm[partApplication]" style="margin-left:0"><?php echo $row['part_application']?></textarea>
				</div>	
			</div>		
			
			<div class='group'>
				<div class="kitSpacersDesc">	
					<label class="titleTop" style="margin-left:0" for="fsPartNumber">Description</label>
					<textarea id="notes" name="frm[notes]" style="margin-left:0"><?php echo $row['part_description']?></textarea>
				</div>	
			</div>		
			
			<div class="group">
				<div class="kitSpacers">
					<label class="titleTop" for="msrp">MSRP</label><br/>
					<input id="msrp"  name="frm[msrp]" type="text" value="<?php echo $row['msrp']?>" />
				</div>
				
				<div class="kitSpacers">
					<label  class="titleTop" for="dealerCost">Dealer Cost</label><br/>
					<input id="dealerCost"  name="frm[dealerCost]" type="text" value="<?php echo $row['dealer_cost']?>" />
				</div>
				<div class="kitSpacers">
					<label  class="titleTop" for="importCost">Import Cost</label><br/>
					<input id="importCost"  name="frm[importCost]" type="text" value="<?php echo $row['import_cost']?>" />
				</div>
				
			</div>
			
			<div class="groupCommand">	
			<br/>		
				<div id="formCommands">
					<?php
					require "inc/formCommand.inc.php";
					?>
					<input type="hidden" id="fs" name="frm[fs]" value="<?php echo $row['fs_price']?>" />
					<input type="hidden" id="rs" name="frm[rs]" value="<?php echo $row['rs_price']?>" />
					<input type="hidden" id="ch" name="frm[ch]" value="<?php echo $row['ch_price']?>" />
					<input type="hidden" id="productCategory" name="frm[productCategory]" value="KT" />
					<input type="hidden" id="partID" name="frm[partID]" value="<?php echo $row['part_id']?>" />
					<input type="hidden" id="kitID" name="frm[kitID]" value="<?php echo $row['chain_kit_id']?>" />
					<input type="hidden" id="chainPartNumber" name="frm[chainPartNumber]" value="<?php echo $row['chain_part_number']?>" />
				</div>
			</div>
			
			
		</form>	
		</div>
		

		
		
		<hr>
		
		<div id="chainChart">
			<div id="chartList">Please select a pitch to select a chain</div>
		</div>
		
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
<div id="log"></div>
</body>
</html>
