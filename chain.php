<?php 
    if ( isset($_POST['formAction']) ) { header("Location: part-list.php"); }
    
	$debug = 'Off';
	require_once 'db/global.inc.php';
	
	function __autoload($class) {
		include 'classes/' . $class . '.class.php';
	}
	
	// Create Object Customer and Request
	$constants = new Constants;
	$chain = new Chain($debug, $db);
	$request  = new Request;
	$utilityDB = new UtilityDB($debug, $db);
	$utility  = new Utility($debug);

	// Get Query Parameters
	$recMode  = $request->getParam('status','');
	$search  = $request->getParam('search','');
	$part_id = $request->getParam('part_id');
	$action  = $request->getParam('formAction','');



	// Was form Submitted?
	if ($action) {
		if($recMode == "E" || $recMode == "A") {
			$chain->UpdateChain( $_POST['frm'], $recMode );
		} else if ($recMode == "D") {
			$chain->UpdateChainStatus($_POST['frm']);
		}		
	}

	if ($recMode == "E"){
		// Get Info and Display
		$row = $chain->GetChain($part_id);
	}
	
	
	// Setup the case
	switch ( strtolower($recMode) )  {
	    case "a":
	        $recStatusDesc = "Adding new Chain";
	        break; 
		case "d":	
			$recStatusDesc = "Making Chain Inactive";
			break;
		case "e":
			$recStatusDesc = "Updating Chain information";
			break;
		}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title><?php echo($partCat)?>Chain Maintenance</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
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
		require($DOCUMENT_ROOT . "inc/nav.inc.php");
		?>
	</div>
	<div id="">
		<h2>
			<?php echo($recStatusDesc)?> 
		</h2>
		<hr />
	
		<div id="">
		   <form id="formChain" name="formChain" method="post" action="<?php echo $_PHP_SELF; ?>" >
			<table id="tablePartMaint" align="center">
				<tr>
					<td> 
						<Label>Part Category</>
					</td>
					<td colspan="3">
						<strong>&nbsp;Chain</strong> <input type="hidden" id="productCategory" name="frm[productCategory]" value="CH" />
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
				<tr>
				<td>
					<label>Pitch</label>
				</td>
				<td>
<?php 
include 'inc/pitch-list.inc.php';
?>
				</td>
				<td align="right">
					<label>Sequence</label>
				</td>
					<td>
						<input id="sequence" name="frm[sequence]" type="text" value="<?php echo $row['sequence']?>"/>
					</td>
				
				<td>
					
				</td>				
				</tr>
				<td>
					<label>Product Brand</label>
				</td>
				<td colspan="3">
<?php
include 'inc/brand-list.inc.php';
?>
				</td>
			</tr>
<!--				<tr>
					<td valign="top">
						<label>Application</label>
					</td>
					<td colspan="3">
						<textarea id="partApplication" name="frm[partApplication]"><?php echo $row['part_application']?></textarea>
					</td>
				</tr>		-->		

				<tr>
					<td valign="top">
						<label>Description</label>
					</td>
					<td colspan="3">
						<textarea id="partDescription" name="frm[partDescription]"><?php echo $row['part_description']?></textarea>
					</td>
				</tr>				
				<tr>
					<td>
						<label>MSRP</label>
					</td>
					<td colspan="3">
						<input id="msrp" name="frm[msrp]" type="text" value="<?php echo $row['msrp']?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Dealer Cost</label>
					</td>
					<td colspan="3">
						<input id="dealerCost" name="frm[dealerCost]" type="text" value="<?php echo $row['dealer_cost']?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Import Cost</label>
					</td>
					<td colspan="3">
						<input id="importCost" name="frm[importCost]" type="text" value="<?php echo $row['import_cost']?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Status</label>
					</td>
					<td>
						<span class="statusMessage"><?php echo $utility->GetRecStatus( $row['rec_status'] );?></span>
					</td>
				</tr>
	<!--  This is used in Chain Kit 			
				<tr>
					<td>
						<input id="selectChain" name="frm[selectChain]" type="button" value="Select Chain" />
					</td>
					<td colspan="3">
						<label id="chainSelectedDesc"><?php echo $row['linked_chain_part_description']?></label>
						<input id="chainSelectedPartNumber" name="frm[linkedChainPart]" type="hidden" value="<?php echo $row['linked_chain_part_number']?>"/>
					</td>
				</tr>	
	-->										
			</table>
		</div>
		<hr />
		<div id="formCommands">
			<?php
			require "inc/formCommand.inc.php";
			?>
			<input id="partID" name="frm[partID]" value="<?php echo $part_id; ?>" type="hidden" />
			<input id="chainID" name="frm[chainID]" value="<?php echo $row['chain_id']; ?>" type="hidden" />	
			<input id="recStatus" name="frm[recStatus]" value="<?php echo $row['rec_status']; ?>" type="hidden" />
		</div>
		
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
</form>
</body>
</html>
