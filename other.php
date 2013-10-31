<?php 
	require "inc/back-to-referer.inc.php";
    
	$debug = 'Off';
	require_once 'db/global.inc.php';
	
 	// Start logging
	include 'log4php/Logger.php';
	Logger::configure('logconfig.xml');
	$log = Logger::getLogger('myLogger');
	 spl_autoload_register(function ($class) {
		include 'classes/' . $class . '.class.php';
	 });   
	
	// Create Object Customer and Request
	$constants = new Constants;
	$other = new Other($debug, $db);
	$request  = new Request;
	$utilityDB = new UtilityDB($debug, $db);
	$utility  = new Utility($debug);

	// Get Query Parameters
	$recMode  = $request->getParam('status','');
	$part_id = $request->getParam('part_id');
	$action  = $request->getParam('formAction','');
	$partCat = $request->getParam('cat');



	// Was form Submitted?
	if ($action) {
		if($recMode == "E" || $recMode == "A") {
			$other->UpdateOther( $_POST['frm'], $recMode );
		} else if ($recMode == "D") {
			$other->UpdateOtherStatus($_POST['frm']);
		}		
	}

	if ($recMode == "E"){
		// Get Info and Display
		$row = $other->GetOther($part_id, $cat);
	}

	// Setup the case
	switch ( strtolower($recMode) )  {
	    case "a":
	        $revViewDesc = "Adding ";
	        break; 
		case "e":
			$revViewDesc = "Updating information";
			break;
		}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title><?php echo($partCat)?> Other Maintenance</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>	
	<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
	<!-- Form Validation Engine -->
	<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>


  	<script>
	$(function() {		
		$("#formOther").validationEngine('attach');
		$("#formOther").validationEngine('init', {promptPosition : "centerRight", scroll: false});
		
		$(document).on('click', '#submit', function(event) {
			//event.preventDefault();
			if( $("#formOther").validationEngine('validate') ) {
				// validates
				$("#formOther").submit();		
			}
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
			<?php echo($partTypeDesc)?> Other Maintenance
		</h2>
		<hr />
	
		<div id="">
		   <form id="formOther" name="formOther" method="post" action="<?php echo $_PHP_SELF; ?>" >
 			<table id="tablePartMaint" align="center">
				<tr>
					<td> 
						<Label>Product Category</label>
					</td>
					<td colspan="3">
						<select class="validate[required]" id="productCategory" name="frm[productCategory]">
						<option value="*">Select...</option>
							<?php
							 $utilityDB->LookupList($partCat, Constants::TABLE_CATEGORY_LIST);  
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
						<input class="validate[required] text-input" id="stockLevel" name="frm[stockLevel]" type="text" value="<?php echo $row['stock_level']?>"/>
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
						<label>Application</label>
					</td>
					<td colspan="3">
						<textarea id="partApplication" name="frm[partApplication]" ><?php echo $row['part_application']?></textarea>
					</tr>
				</tr>
				
				<tr>
					<td>
						<label>Description</label>
					</td>
					<td colspan="3">
						<textarea id="partDescription" name="frm[partDescription]" ><?php echo $row['part_description']?></textarea>
					</tr>
				</tr>
				<tr>
					<td>
						<label>MSRP</label>
					</td>
					<td colspan="3">
						<input class="validate[required] text-input" id="msrp" name="frm[msrp]" type="text" value="<?php echo $row['msrp']?>"/>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Dealer Cost</label>
					</td>
					<td colspan="3">
						<input class="validate[required] text-input" id="dealerCost" name="frm[dealerCost]" type="text" value="<?php echo $row['dealer_cost']?>"/>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Import Cost</label>
					</td>
					<td colspan="3">
						<input class="validate[required] text-input" id="importCost" name="frm[importCost]" type="text" value="<?php echo $row['import_cost']?>"/>
					</tr>
				</tr>	

														
			</table>
		</div>
		<hr/>
		<div id="formCommands">
			<?php
			require "inc/formCommand.inc.php";
			?>

		<input id="partID" name="frm[partID]" value="<?php echo $part_id ?>" type="hidden"/>
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
