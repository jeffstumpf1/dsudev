<?php 
/*
if($debug=="On") {
	
}
*/
	$debug = 'Off';
	$retval ='';
	//echo "[".$debug."]<br>";
	
    require_once 'db/global.inc.php';
	require_once 'classes/clsSprocket.php';
    require_once 'classes/clsUtility.php'; 

    error_reporting(E_ERROR);

	$DOCUMENT_ROOT="";
	$status="";
	$recMode="";
	$sprocket = new Sprocket(); 
	$sprocket->SetDebug($debug);	
	
	if(isset($_GET['part_id'])) {
		$part_id = (get_magic_quotes_gpc()) ? $_GET['part_id'] : addslashes($_GET['part_id']);
	}
	
	if(isset($_GET['status'])) {
		$recMode = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
	}

	if(isset($_GET['cat'])) {
		$partCat = (get_magic_quotes_gpc()) ? $_GET['cat'] : addslashes($_GET['cat']);
	}

	// Update Controller
	if (isset( $_POST['formAction'] )) {
			
		if($recMode == "E" || $recMode == "A") {
			$retval = $sprocket->UpdateSprocket( $db, $_POST['frm'], $recMode );
		} else if ($recMode == "D") {
			$retval = $sprocket->UpdateSprocketStatus($db, $_POST['frm'] );
		}
		if($debug=='On') { echo 'Records updated ('.$recMode.') '. $retval .'<br>';}
	}

    // fetch data
	$sql = sprintf( "select a.*,b.sprocket_id, b.sprocket_size, b.sprocket_notes from PartMaster a, Sprocket b where a.part_number = b.part_number and a.part_id = %s", $part_id );
    $rs = $db->query( $sql); 
    $row = $rs->fetch();

	if($debug=="On") {
		echo $sql;
	}
	
	$utility = new Utility();
	
	// Setup the case
	switch ( $recMode )  {
	    case "A":
	        $recStatusDesc = "Adding Sprocket";
	        break; 
		case "D":	
			$recStatusDesc = "Making Sprocket Inactive";
			break;
		case "E":
			$recStatusDesc = "Updating Sprocket information";
			break;
		}
	
	
	switch ($partCat) {
		case "FS":
			$partTypeDesc = "Front";
			break;
		case "RS":
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
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.1.min.js"><\/script>')</script>
  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script>
		$(function() {
    		
  		});
  	</script
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
			<?php echo($partTypeDesc)?> Sprocket Maintenance
		</h2>
		<hr />
	
		<div id="formContent">
		   <form id="formSprocket" name="formSprocket" method="post" action="<?php echo $_PHP_SELF; ?>" >
 			<table id="tablePartMaint" align="center">
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
						<input id="partNumber" name="frm[partNumber]" type="text" value="<?php echo $row['part_number']?>"/>
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
						<label>Size</label>
					</td>
					<td colspan="3">
						<input id="size" name="frm[size]" type="text" value="<?php echo $row['sprocket_size']?>"/>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Pitch</label>
					</td>
					<td colspan="3">
						<select id="pitch" name="frm[pitch]">
						<option value="*">Select...</option>
						<?php
						 echo $utility->GetPitchList($db, $row['pitch_id']);  
						?>
						</select>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Product Brand</label>
					</td>
					<td colspan="3">
						<select id="brand" name="frm[brand]">
						<option value="*">Select...</option>
						<?php
						 echo $utility->GetBrandList($db, $row['']);  
						?>
						</select>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Description</label>
					</td>
					<td colspan="3">
						<input id="partDescription" name="frm[partDescription]" type="text" value="<?php echo $row['part_description']?>"/>
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
			require($DOCUMENT_ROOT . "includes/formCommand.php");
			?>
		</div>
		<input id="partID" name="frm[partID]" value="<?php echo $part_id ?>" type="hidden"/>
		<input id="sprocketID" name="frm[sprocketID]" value="<?php echo $row['sprocket_id'] ?>" type="hidden"/>	
		<input id="recsStatus" name="frm[recStatus]" value="<?php echo $row['rec_status'] ?>" type="hidden"/>	
		</form>
	</div>
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
</form>

</body>
</html>
