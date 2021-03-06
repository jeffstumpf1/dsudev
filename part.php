<?php 
	$debug = 'Off';
	
    require_once 'db/global.inc.php';
	require_once 'classes/clsSprocket.php';
    require_once 'classes/clsUtility.php'; 

    error_reporting(E_ERROR);

	$DOCUMENT_ROOT="";
	$status="";
	$recMode="";
	
	if(isset($_GET['part_id'])) {
		$part_id = (get_magic_quotes_gpc()) ? $_GET['part_id'] : addslashes($_GET['part_id']);
	}
	
	if(isset($_GET['status'])) {
		$recMode = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
	}

	// Update Controller
	if (isset( $_POST['formAction'] )) {
		$sprocket = new Sprocket();
			
		if($recMode == "E" || $recMode == "A") {
			$sprocket->UpdateSprocket( $db, $_POST['frm'], $recMode );
		} else if ($recMode == "D") {
			$sprocket->UpdateSprocketStatus($db, $_POST['frm'] );
		}
	}

    // fetch data
	$sql = sprintf( "select a.*,b.sprocket_id, b.sprocket_size, b.sprocket_notes from PartMaster a, Sprocket b where a.part_number = b.part_number and a.part_id = %s", $part_id );
    $rs = $db->query( $sql); 
    $row = $rs->fetch();

	//todo: echo $sql;
	$utility = new Utility();
	
	// Setup the case
	switch ( $recMode )  {
	    case "A":
	        $recStatusDesc = "Adding new part";
	        break; 
		case "D":	
			$recStatusDesc = "Making part Inactive";
			break;
		case "E":
			$recStatusDesc = "Updating part information";
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
	<title>Customer Maintenance</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.1.min.js"><\/script>')</script>
  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script>
		$(function() {
    		$( "#exp1" ).datepicker();
  		});
		$(function() {
    		$( "#exp2" ).datepicker();
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
			Customer Maintenance
		</h2>
		<hr />
	
		<div id="formContent">
			<table id="tableCustomerMaint" align="center">
				<tr>
					<td> 
						<Label>DBA Name</>
					</td>
					<td colspan="3">
						<input id="dbaName" type="text" />
					</td>
				</tr>
				<tr>
					<td>
						<label>Customer Number</label>
					</td>
					<td>
						<input id="customerNumber" type="text" />
					</td>
					<td align="right">
						<label>Discount Level</label>
					</td>
					<td>
						<input id="discountPct" type="text" />
					</td>
				</tr>
				<tr>
					<td>
						<label>Address</label>
					</td>
					<td colspan="3">
						<input id="address" type="text"/>
					</tr>
				</tr>
				<tr>
					<td>
						<label>City/State/Zip</label>
					</td>
					<td>
						<input id="city" type="text" />
					</td>
					<td>
						<select id="state">
							<option value="*">Select...</option>
							<option value="CA">California</option>
						</select>
					</td>
					<td>
						<input id="zip" type="text">
					</td>
				</tr>
				<tr>
					<td>
						<label>Phone#1/Phone#2/Fax</label>
					</td>
					<td>
						<input id="phone1" type="text" />
					</td>
					<td>
						<input id="phone2" type="text" />
					</td>
					<td>
						<input id="fax" type="text">
					</td>
				</tr>
				<tr>
					<td>
						<label>email</label>
					</td>
					<td colspan="3">
						<input id="email" type="text"/>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Credit Card/Exp/CVV</label>
					</td>
					<td>
						<input id="cc1" type="text" />
					</td>
					<td>
						<input id="exp1" type="text" />
					</td>
					<td>
						<input id="cvv1" type="text">
					</td>
				</tr>
				<tr>
					<td>
						<label>Credit Card/Exp/CVV</label>
					</td>
					<td>
						<input id="cc2" type="text" />
					</td>
					<td>
						<input id="exp2" type="text" />
					</td>
					<td>
						<input id="cvv2" type="text">
					</td>
				</tr>
				<tr>
					<td>
						<label>Notes</label>
					</td>
					<td colspan="3">
						<textarea id="notes">
						</textarea>
					</tr>
				</tr>
											
			</table>
		</div>
		
		<div id="formCommands">
			<?php
			require($DOCUMENT_ROOT . "includes/formCommand.php");
			?>
		</div>
		
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
</body>
</html>
