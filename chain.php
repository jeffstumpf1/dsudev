<?php 
    //if ( isset($_POST['formAction']) ) { header("Location: part-list.php"); }
    
    $debug = 'On';
	
    require_once 'db/global.inc.php';
	require_once 'classes/clsChain.php'; 
	require 'classes/clsUtility.php';
    
    error_reporting(E_ERROR);

	$DOCUMENT_ROOT="";
	$status="";
	$recMode="";
	$chain = new Chain();
	$utility = new Utility();
	$chain->SetDebug($debug);


	if(isset($_GET['part_id'])) {
		$part_id = (get_magic_quotes_gpc()) ? $_GET['part_id'] : addslashes($_GET['part_id']);
	}
	
	if(isset($_GET['status'])) {
		$recMode = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
	}

	// Update Controller
	if (isset( $_POST['formAction'] )) {
			
		if(strtolower($recMode) == "e" || strtolower($recMode) == "a") {
			$part_id = $chain->UpdateChain( $db, $_POST['frm'], $recMode );
		} else if (strtolower($recMode) == "d") {
			$chain->UpdateChainStatus($db, $_POST['frm'] );
		}
	}

    // fetch data
	$sql = sprintf( "select a.*,b.chain_id, b.product_brand_id, b.linked_chain_part_number, b.clip_id from PartMaster a, Chain b where a.part_number = b.part_number and a.rec_status=0 and a.part_id = %s", $part_id );
    $rs = $db->query( $sql); 
    $row = $rs->fetch();

	if ($debug=='On') { echo $sql."<br>"; }	
	
	
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
<!-- Dialog box Used to show Chains -->
<div id="dialog" title="Basic dialog">
  <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>

<div id="dialog-form" title="Select Chain"></div>

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
			<?php echo($recStatusDesc)?> 
		</h2>
		<hr />
	
		<div id="formContent">
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
include 'includes/part_logic.php';
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
include 'includes/pitch-list.php';
?>
				</td>
				<td align="right">
					<label>Clip</label>
				</td>
				<td>
				<select id="clip" name="frm[clip]">
				<option value="*">Select...</option>
					<?php
					 echo $utility->GetClipList($db, $row['clip_id']);  
					?>
				</select>
				</td>				
				</tr>
				<td>
					<label>Product Brand</label>
				</td>
				<td colspan="3">
<?php
include 'includes/brand-list.php';
?>
				</td>
			</tr>
				<tr>
					<td valign="top">
						<label>Application</label>
					</td>
					<td colspan="3">
						<textarea id="partApplication" name="frm[partApplication]"><?php echo $row['part_application']?></textarea>
					</td>
				</tr>				

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
			require($DOCUMENT_ROOT . "includes/formCommand.php");
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
