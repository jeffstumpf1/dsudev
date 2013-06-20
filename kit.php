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
	        $recStatusDesc = "Adding new Kit";
	        break; 
		case "D":	
			$recStatusDesc = "Making Kit Inactive";
			break;
		case "E":
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
  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	
	<link href="css/square/square.css" rel="stylesheet">
	<script src="js/jquery.icheck.js"></script>
	
	<script>
	$(document).ready(function(){
	  $('input').iCheck({
	    checkboxClass: 'icheckbox_square',
	    radioClass: 'iradio_square',
	  });
	});
	</script></head>
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
			<?php echo($recStatusDesc)?> 
		</h2>
		<hr />
	
		<div id="formContent">
		  <fieldset id="kitInfo" class="kitFieldset">
		  	<legend>General Kit Information</legend>
				<div class="kitSpacers">
					<label>Part Number</label>
					<input id="partNumber" type="text" />
					<input type="hidden" id="cat" value="KT" />
				</div>
				<div class="kitSpacers">
					<label>Pitch</label>
					<select id="pitch">
						<option value="420">420 Pitch</option>
						<option value="428">428 Pitch</option>
						<option value="520" SELECTED>520 Pitch</option>
						<option value="525">525 Pitch</option>
						<option value="530">530 Pitch</option>
					</select>
				</div>
				<div class="kitSpacers">
					<label>Product Brand</label>
					<select id="brand">
						<option value="*">Select</option>
						<option value="YAM">Yamaha</option>
					</select>
				</div>
				<div class="kitSpacersDesc">	
					<p><label>Description</label>
					<textarea id="notes">
					</textarea></p>
				</div>
			</fieldset>
			
			<!-- Kit Specifics -->
			<fieldset id="kitDetails" class="kitFieldset">
		  	<legend>Kit Details</legend>
				<div class="kitSpacers">
					<label>Front Sprocket</label><br/>
					<input id="frontSprocket" type="text" />
				</div>
				<div class="kitSpacers">
					<label>Sprocket Size</label><br/>
					<input id="frontSprocketSize" type="text" />
				</div>
				<div class="kitSpacers">
					<label>Rear Sprocket</label><br/>
					<input id="rearSprocket" type="text" />
				</div>
				<div class="kitSpacers">
					<label>Sprocket Size</label><br/>
					<input id="rearSprocketSize" type="text" />
				</div>
				<div class="kitSpacers">
					<label>Chain Length</label><br/>
					<input id="chainLength" type="text" />
				</div>
				<div class="kitSpacers">
					<label>M/L</label><br/>
					<select id="ML">
						<option value="*">Select</option>
						<option value="ML">M/L</option>
					</select>
				</div>
		  	</fieldset>
			
			<!-- Chain in Kit -->
			<fieldset id="kitDetails" class="kitFieldset">
		  	<legend>Chains</legend>
			<table id="chainChartTable">
				<tr>
					<th>Action</th>
					<th style="text-align:left;">Chain Description</th>
					<th>MSRP</th>
					<th>Dealer Cost</th>
					<th>Import Cost</th>
				</tr>
				<tr class="row">
					<td><!- Action -->
						<input type="radio" name="iCheck" />
					</td>
					<td> <!- Chain Description -->
						xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
					</td>
					<td> <!- MSRP -->
						$0.00
					</td>
					<td> <!- Dealer Cost -->
						$0.00
					</td>
					<td> <!- Import Cost -->
						$0.00
					</td>
				</tr>
				<tr class="row">
					<td><!- Action -->
						<input type="radio" name="iCheck" />
					</td>
					<td> <!- Chain Description -->
						xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
					</td>
					<td> <!- MSRP -->
						$0.00
					</td>
					<td> <!- Dealer Cost -->
						$0.00
					</td>
					<td> <!- Import Cost -->
						$0.00
					</td>
				</tr>
				<tr class="row">
					<td><!- Action -->
						<input type="radio" name="iCheck" />
					</td>
					<td> <!- Chain Description -->
						xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
					</td>
					<td> <!- MSRP -->
						$0.00
					</td>
					<td> <!- Dealer Cost -->
						$0.00
					</td>
					<td> <!- Import Cost -->
						$0.00
					</td>
				</tr>
				<tr class="row">
					<td><!- Action -->
						<input type="radio" name="iCheck" />
					</td>
					<td> <!- Chain Description -->
						xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
					</td>
					<td> <!- MSRP -->
						$0.00
					</td>
					<td> <!- Dealer Cost -->
						$0.00
					</td>
					<td> <!- Import Cost -->
						$0.00
					</td>
				</tr>
				<tr class="row">
					<td><!- Action -->
						<input type="radio" name="iCheck" />
					</td>
					<td> <!- Chain Description -->
						xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
					</td>
					<td> <!- MSRP -->
						$0.00
					</td>
					<td> <!- Dealer Cost -->
						$0.00
					</td>
					<td> <!- Import Cost -->
						$0.00
					</td>
				</tr>
				<tr class="row">
					<td><!- Action -->
						<input type="radio" name="iCheck" />
					</td>
					<td> <!- Chain Description -->
						xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
					</td>
					<td> <!- MSRP -->
						$0.00
					</td>
					<td> <!- Dealer Cost -->
						$0.00
					</td>
					<td> <!- Import Cost -->
						$0.00
					</td>
				</tr>
			</table>	
			</fieldset>
			
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
