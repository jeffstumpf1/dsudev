<?php 
    $debug = 'Off';
	
    require_once 'db/global.inc.php';
	require 'classes/clsUtility.php';
    
    error_reporting(E_ERROR);

	$DOCUMENT_ROOT="";
	$status="";
	$recMode="";
	$utility = new Utility();
	$pitch="";
	
	if(isset($_GET['pitch'])) {
		$pitch = (get_magic_quotes_gpc()) ? $_GET['pitch'] : addslashes($_GET['pitch']);
	}
	
	// fetch data
	$sql = sprintf( "select a.*,b.chain_id, b.product_brand_id, b.linked_chain_part_number, b.linked_chain_part_description, b.clip_id from PartMaster a, Chain b where a.part_number = b.part_number and a.rec_status=0 and a.pitch_id = %s", $pitch );
    $rs = $db->query( $sql); 
    $row = $rs->fetch();

	if ($debug=='On') { echo $sql."<br>"; }	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title>Chain Chart</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
  	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script>
		$(function() {
			
			// Selects Chains based on pitch
			$(function () {
			    $("#radio").buttonset();

			    $("input[name='pitch']").on("change", function () {
			        $pitch = $(this).val();
					$('#pitchNumber').html($pitch + " - Chain Chart");
					$('#pitch').val($pitch);
					$('#frmAction').submit();
			    });

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
		require($DOCUMENT_ROOT . "includes/nav.php");
		?>
	</div>
<div id="wrapper">
		<h2>
			<label id="pitchNumber"><? echo $pitch ?> - Chain Chart [ <?php echo $rs->size() ?> ]</label>
			<input type="hidden" id="pitch" name="pitch" value="<?php echo $pitch?>"/>
		</h2>
		<hr />
		<div id="commandBar">
			<div id="actionBox">
			  <form id="frmAction" method="get" action="<?php echo $_PHP_SELF?>">
			    		<label>Select Pitch Options:</label>
				<div id="radio">
					<input id="r1" type="radio" class="radioPitch" name="pitch" value="420" />
					<label for="r1">420</label>
					<input id="r2" type="radio" class="radioPitch" name="pitch" value="428" />
					<label for="r2">428</label>
					<input id="r3" type="radio" class="radioPitch" name="pitch" value="520" />
					<label for="r3">520</label>
					<input id="r4" type="radio" class="radioPitch" name="pitch" value="525" />
					<label for="r4">525</label>
					<input id="r5" type="radio" class="radioPitch" name="pitch" value="530" />
					<label for="r5">530</label>
				</div>
			  </form>
			  <br />
			</div>

		</div>
		<table id="chainChartTable">
			<tr>
				<th>Action</th>
				<th>Part Number</th>
				<th style="text-align:left;">Chain Description</th>
				<th>Stock Level</th>
				<th>MSRP</th>
				<th>Dealer Cost</th>
				<th>Import Cost</th>
			</tr>
<?php Do { ?>			
			<tr class="row">
				<td><!- Action -->
					<!-- Logic to handle editing graphic panels -->
					<a href="chain.php?part_id=<?php echo $row['part_id'];?>&status=E&cat=<?php echo $row['category_id'];?>"><div class="actionEdit"></div></a>
					<a href="chain.php?part_id=<?php echo $row['part_id'];?>&status=D&cat=<?php echo $row['category_id']?>"><div class="actionStatus"></div></a>
				</td>
				<td style="text-align:left;">
					<?php echo $row['part_number']?>
				</td>
				<td style="text-align:left;"> <!- Chain Description -->
					<?php echo $row['part_description'];?>
				</td>
				<td> <!-- Stock Level -->
					<?php echo $row['stock_level'] ?>
				</td>
				<td> <!-- MSRP -->
					<?php echo $utility->NumberFormat( $row['msrp'], '$') ?>
				</td>
				<td> <!-- Dealer Cost -->
					<?php echo $utility->NumberFormat($row['dealer_cost'], '$') ?>
				</td>
				<td> <!-- Import Cost -->
					<?php echo $utility->NumberFormat($row['import_cost'], '$') ?>
				</td>
			</tr>
<?php } while ($row = $rs->fetch( $rs )); ?>	
		</table>
	

	
	
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
</body>
</html>
