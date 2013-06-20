<?php 
	$partCat="";
	$recMode="";
	if(isset($_GET['status'])) {
		$recMode = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
	}
	if(isset($_GET['cat'])) {
		$partCat = (get_magic_quotes_gpc()) ? $_GET['cat'] : addslashes($_GET['cat']);
	}
	
	// Setup the case
	switch ( $recMode )  {
	    case "A":
	        $recStatusDesc = "Adding new chain";
	        break; 
		case "D":	
			$recStatusDesc = "Making chain Inactive";
			break;
		case "E":
			$recStatusDesc = "Updating chain information";
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
  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  	
    <script>
 $(function() {	
		  $( "#dialog-form" ).dialog({
		      autoOpen: false,
		      height: 300,
		      width: 650,
		      modal: true,
				Cancel: function() {
				          $( this ).dialog( "close" );
			      }				
			});
			
			$( "#selectChain" )
		      .click(function() {
		        $( "#dialog-form" ).dialog( "open" );
		      });
		
			/* Once a chain is selected update the contents to the form field for storing */
			$( ".chainSelected" )
		      .click(function() {
			    $partNumber = $( this ).attr('href');
				$partNumber = $partNumber.substring(1);
				$partDesc = $(this).text();
			    $( "#chainSelectedPartNumber").val( $partNumber );
			    $( "#chainSelectedDesc" ).text( $partNumber + '-' + $partDesc );
		        $( "#dialog-form" ).dialog( "close" );
		      });
});		   

  	</script
</head>
<body>
<!-- Dialog box Used to show Chains -->
<div id="dialog" title="Basic dialog">
  <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>

<div id="dialog-form" title="Select Chain">

  <form>
	<table id="chainChartTable">
		<tr>
		    <th>Part Number</th>
			<th style="text-align:left;">Chain Description</th>
			<th>MSRP</th>
			<th>Dealer Cost</th>
			<th>Import Cost</th>
		</tr>
		<tr class="row">
			<td> <!-- Part Number -->
				520UI78
			<td> <!-- Chain Description -->
				<a href="#520UI78" class="chainSelected">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</a>
			</td>
			<td> <!-- MSRP -->
				$0.00
			</td>
			<td> <!-- Dealer Cost -->
				$0.00
			</td>
			<td> <!-- Import Cost -->
				$0.00
			</td>
		</tr>
	</table>
  </form>
</div>

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
			<table id="tablePartMaint" align="center">
				<tr>
					<td> 
						<Label>Part Category</>
					</td>
					<td colspan="3">
						<strong>&nbsp;Chain</strong> <input type="hidden" id="cat" value="CH" />
					</td>
				</tr>
				<tr>
					<td>
						<label>Part Number</label>
					</td>
					<td>
						<input id="partNumber" type="text" />
					</td>
					<td align="right">
						<label>Stock Level</label>
					</td>
					<td>
						<input id="stockLevel" type="text" />
					</td>
				</tr>
				<tr>
				<td>
					<label>Pitch</label>
				</td>
				<td>
					<select id="pitch">
						<option value="420">420 Pitch</option>
						<option value="428">428 Pitch</option>
						<option value="520" SELECTED>520 Pitch</option>
						<option value="525">525 Pitch</option>
						<option value="530">530 Pitch</option>
					</select>
				</td>
				<td align="right">
					<label>Clip</label>
				</td>
				<td>
					<select id="clip">
						<option value="RV">RV</option>
					</select>
				</td>				
				</tr>
				<td>
					<label>Product Brand</label>
				</td>
				<td colspan="3">
					<select id="pitch">
						<option value="*">Select</option>
						<option value="428">Superlite</option>
					</select>
				</td>
			</tr>

				<tr>
					<td valign="top">
						<label>Description</label>
					</td>
					<td colspan="3">
						<textarea id="notes">
						</textarea>
					</td>
				</tr>				
				<tr>
					<td>
						<label>MSRP</label>
					</td>
					<td colspan="3">
						<input id="msrp" type="text"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Dealer Cost</label>
					</td>
					<td colspan="3">
						<input id="dealerCost" type="text"/>
					</td>
				</tr>
				<tr>
					<td>
						<label>Import Cost</label>
					</td>
					<td colspan="3">
						<input id="importCost" type="text"/>
					</td>
				</tr>
				<tr>
					<td>
						<input id="selectChain" type="button" value="Select Chain" />
					</td>
					<td colspan="3">
						<label id="chainSelectedDesc">Use the button to select a chain</label>
						<input id="chainSelectedPartNumber" type="hidden" />
					</td>
				</tr>											
			</table>
		</div>
		<hr />
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
