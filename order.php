<?php 
    //if ( isset($_POST['formAction']) ) { header("Location: part-list.php"); }
    
    $debug = 'Off';
	
    require_once 'db/global.inc.php';
	require_once 'classes/clsChain.php'; 
	require_once 'classes/clsKit.php'; 
	require 'classes/clsUtility.php';
    
    error_reporting(E_ERROR);

	$DOCUMENT_ROOT="";
	$status="";
	$recMode="";
	$kit = new Kit();
	$utility = new Utility();
	$kit->SetDebug($debug);


	if(isset($_GET['part_id'])) {
		$part_id = (get_magic_quotes_gpc()) ? $_GET['part_id'] : addslashes($_GET['part_id']);
	}
	
	if(isset($_GET['status'])) {
		$recMode = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
	}

	// Update Controller
	if (isset( $_POST['formAction'] )) {
			
		if(strtolower($recMode) == "e" || strtolower($recMode) == "a") {
			$part_id = $chain->UpdateKit( $db, $_POST['frm'], $recMode );
		} else if (strtolower($recMode) == "d") {
			$chain->UpdateKitStatus($db, $_POST['frm'] );
		}
	}

    // fetch data
	$sql = sprintf( "select a.*,b.chain_id, b.product_brand_id, b.linked_chain_part_number, b.clip_id from PartMaster a, Chain b where a.part_number = b.part_number and a.rec_status=0 and a.part_id = %s", $part_id );
    $rs = $db->query( $sql); 
    $row = $rs->fetch();

	if ($debug=='On') { echo $sql."<br>"; }	
	
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
	<script type="text/javascript" src="js/chain_kit.js"></script>
	 
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
			<?php echo($recStatusDesc)?> <hr />
		</h2>
		
				<div id="KitContent">
			<fieldset>
				<legend>Chain Kt</legend>
				
					<table width="100%">
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


		<div id="formContent">
			<div class="group">
				<div class="kitSpacers">
					<label class="titleTop" style="margin-left:0">Part</label><br/>
<?php
include 'includes/part_logic.php';
?>					
				</div>
				<div class="kitSpacers">
					<label class="titleTop" for="pitch">Pitch</label><br/>
<?php 
include 'includes/pitch-list.php';
?>
				</div>
				<div class="kitSpacers">
					<label class="titleTop" for="brand">MFG</label><br/>
<?php 
include 'includes/brand-list.php';
?>
				</div>
				<div class="kitSpacers">
					<label class="titleTop" for="ML">Master</label><br/>
					<select id="ML"  name="frm[ml']" >
						<option value="*">Select</option>
						<option value="ML">M/L</option>
					</select>
				</div>

			</div>
			<div class="group">
				<div class="kitSpacers">
					<label class="titleTop" for="fsPartNumber">Front Sprocket</label><br/>
					<input id="fsPartNumber"  name="frm[fsPartNumber']" type="text" />
				</div>
				
				<div class="kitSpacers">
					<label  class="titleTop" for="rsPartNumber">Rear Sprocket</label><br/>
					<input id="rsPartNumber"  name="frm[rsPartNumber']" type="text" />
				</div>
				<div class="kitSpacers">
					<label  class="titleTop" for="chainLength">Chain Length</label><br/>
					<input id="chainLength"  name="frm[chainLength']" type="text" />
				</div>

			</div>
			<div class="group">
			</div>
			<div class='group'>
				<div class="kitSpacersDesc">	
					<label class="titleTop" style="margin-left:0" for="fsPartNumber">Description</label>
					<textarea id="notes" nam="frm[notes]" style="margin-left:0"><?php echo $row['notes']?></textarea>
				</div>	
			</div>		
			
			<div class="groupCommand">			
				<div id="formCommands">
					<?php
					require($DOCUMENT_ROOT . "includes/formCommand.php");
					?>
					<input type="text" id="fs" value=""/>
					<input type="text" id="rs" value=""/>
					<input type="text" id="ch" value=""/>
				</div>
			</div>
			
			
			
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