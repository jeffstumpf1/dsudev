<?php 
	$partCat="";
	if(isset($_GET['cat'])) {
		$partCat = (get_magic_quotes_gpc()) ? $_GET['cat'] : addslashes($_GET['cat']);
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
			<?php echo($partCat)?> Sprocket Maintenance
		</h2>
		<hr />
	
		<div id="formContent">
			<table id="tablePartMaint" align="center">
				<tr>
					<td> 
						<Label>Rear Sprocket</>
					</td>
					<td colspan="3">
						<select id="cat">
							<option value="FS">Front Sprocket</option>
							<option value="RS" SELECTED>Rear Sprocket</option>
						</select>
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
						<label>Size</label>
					</td>
					<td colspan="3">
						<input id="size" type="text"/>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Pitch</label>
					</td>
					<td colspan="3">
						<select id="pitch">
							<option value="420">420 Pitch</option>
							<option value="428">428 Pitch</option>
							<option value="520" SELECTED>520 Pitch</option>
							<option value="525">525 Pitch</option>
							<option value="530">530 Pitch</option>
						</select>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Product Brand</label>
					</td>
					<td colspan="3">
						<select id="pitch">
							<option value="*">Select</option>
							<option value="428">Superlite</option>
						</select>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Description</label>
					</td>
					<td colspan="3">
						<input id="partDesc" type="text"/>
					</tr>
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
				<tr>
					<td>
						<label>MSRP</label>
					</td>
					<td colspan="3">
						<input id="msrp" type="text"/>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Dealer Cost</label>
					</td>
					<td colspan="3">
						<input id="dealerCost" type="text"/>
					</tr>
				</tr>
				<tr>
					<td>
						<label>Import Cost</label>
					</td>
					<td colspan="3">
						<input id="importCost" type="text"/>
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
