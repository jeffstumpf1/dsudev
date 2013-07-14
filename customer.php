<?php
	$debug = 'Off';
	
    require_once 'db/global.inc.php';
    require_once 'classes/clsUtility.php';
	require_once 'classes/clsCustomer.php';


	$DOCUMENT_ROOT="";
	$status="";
	$recMode="";
	
	if(isset($_GET['customer_id'])) {
		$customer_id = (get_magic_quotes_gpc()) ? $_GET['customer_id'] : addslashes($_GET['customer_id']);
	}
	
	if(isset($_GET['status'])) {
		$recMode = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
	}
	
	if (isset( $_POST['formAction'] )) {
		$customer = new Customer();
			
		if($recMode == "E" || $recMode == "A") {
			$customer->UpdateCustomer( $db, $_POST['frm'], $recMode );
		} else if ($recMode == "D") {
			$customer->UpdateCustomerStatus($db, $_POST['frm']);
		}		
	}

    // fetch data
	$sql = sprintf( "SELECT * FROM Customer WHERE customer_id = %s", $customer_id );
    $rs = $db->query( $sql); 
    $row = $rs->fetch();
	
	$utility = new Utility();
    	
	// Setup the case
	switch ( $recMode )  {
	    case "A":
	        $recStatusDesc = "Adding new customer";
	        break; 
		case "D":	
			$recStatusDesc = "Making customer Inactive";
			break;
		case "E":
			$recStatusDesc = "Updating customer information";
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
			Customer Maintenance - <?php echo( $recStatusDesc ); ?>
		</h2>
		<hr />
	
		<div id="formContent">
		  <form id="formCustomer" method="post" action="<?php $PHP_SELF ?>" >
			<table id="tableCustomerMaint" align="center">
				<tr>
					<td> 
						<Label>DBA Name</>
					</td>
					<td colspan="3">
						<input id="dbaName" name="frm[dbaName]" type="text" value="<?php echo $row['dba']; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label>Customer Number</label>
					</td>
					<td>
						<input id="customerNumber" name="frm[customerNumber]" type="text" value="<?php echo $row['customer_number'];?>" />
					</td>
					<td align="right">
						<label>Discount Level</label>
					</td>
					<td>
						<input id="discountPct" name="frm[discountPct]" type="text" value="<?php echo $row['discount'];?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label>Address</label>
					</td>
					<td colspan="3">
						<input id="address" name="frm[address]" type="text" value="<?php echo $row['address'];?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>City/State/Zip</label>
					</td>
					<td>
						<input id="city" name="frm[city]" type="text" value="<?php echo $row['city'];?>"/>
					</td>
					<td>
						<select id="state" name="frm[state]">
							<option value="*">Select...</option>
							<?php
							 echo $utility->GetStatesList($db, $row['state']);  
							?>
						</select>
					</td>
					<td>
						<input id="zip" name="frm[zip]" type="text" value="<?php echo $row['zip'];?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Phone#1/Phone#2/Fax</label>
					</td>
					<td>
						<input id="phone1" name="frm[phone1]" type="text" value="<?php echo $row['phone1'];?>"/>
					</td>
					<td>
						<input id="phone2" name="frm[phone2]" type="text" value="<?php echo $row['phone2'];?>"/>
					</td>
					<td>
						<input id="fax" name="frm[fax]" type="text" value="<?php echo $row['fax'];?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>email</label>
					</td>
					<td colspan="3">
						<input id="email" name="frm[email]" type="text" value="<?php echo $row['email'];?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Credit Card/Exp/CVV</label>
					</td>
					<td>
						<input id="cc1" name="frm[cc1]" type="text" value="<?php echo $row['cc_num1'];?>"/>
					</td>
					<td>
						<input id="exp1" name="frm[exp1]" type="text" value="<?php echo $row['cc_exp1'];?>"/>
					</td>
					<td>
						<input id="cvv1" name="frm[cvv1]" type="text"value="<?php echo $row['cc_cvv1'];?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Credit Card/Exp/CVV</label>
					</td>
					<td>
						<input id="cc2" name="frm[cc2]" type="text" value="<?php echo $row['cc_num2'];?>"/>
					</td>
					<td>
						<input id="exp2" name="frm[exp2]" type="text" value="<?php echo $row['cc_exp2'];?>"/>
					</td>
					<td>
						<input id="cvv2" name="frm[cvv2]" type="text" value="<?php echo $row['cc_cvv2'];?>"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Notes</label>
					</td>
					<td colspan="3">
						<textarea id="notes" name="frm[notes]"><?php echo $row['notes'];?></textarea>
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
											
			</table>
		
		<hr/>
		<div id="formCommands">
			<?php
			require($DOCUMENT_ROOT . "includes/formCommand.php");
			?>
		</div>
	<!-- end of form -->
		<input type="hidden" id="customerID" name="frm[customerID]" value="<?php echo $row['customer_id'];?>" />
		<input type="hidden" id="rec_mode" name="frm[rec_mode]" value="<?php echo $recMode;?>" />
		<input id="recstStatus" name="frm[recStatus]" value="<?php echo $row['rec_status'] ?>" type="hidden"/>
		<input type="hidden" valued="7147234478" />
	</form>
	</div>
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>

</body>
</html>
