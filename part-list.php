<?php
/*
if($debug=="On") {
	
}
*/
	$debug = 'Off';
 
    require_once 'db/global.inc.php';
    require_once 'classes/clsUtility.php';

	error_reporting(E_ALL|E_STRICT);

    $searchInput='';
	$DOCUMENT_ROOT="";
	$status="";
	$recMode="";
	$search='';
	
	$utility = new Utility();
	$sql = "select * from PartMaster where rec_status='0'";
	
	if(isset($_GET['status'])) {
		$recMode = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
	}
	if(isset($_GET['cat'])) {
		$partCat = (get_magic_quotes_gpc()) ? $_GET['cat'] : addslashes($_GET['cat']);
	}
	if(isset($_GET['search'])) {
		$search = (get_magic_quotes_gpc()) ? $_GET['search'] : addslashes($_GET['search']);
		$sql = sprintf("select * from PartMaster where rec_status='0' and part_number like '%s%s'", $search,'%');
	}
    // fetch data
	
    $rs = $db->query( $sql); 
    $row = $rs->fetch();
	if($debug=="On") { echo $sql; }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title>Part Listing</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.1.min.js"><\/script>')</script>
<script>
$(function() {
    	
    	$("#category").val(0);
    	$("#createSubmit").attr('disabled','disabled');
    	
		$( "#search" ).live('mouseup', function() {
			 $(this).select(); 	
		});
		
		$("#category").change(function() {
		  	$sel = $('#category').val();
		 	if($sel != '*') {
		 		$('#createSubmit').removeAttr('disabled');
		 	} else
		 	  $("#createSubmit").attr('disabled','disabled');  
		});
		
});
</script>
	
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
		 <?php echo "Part Listing - [ ".  $rs->size() ." ]"; ?>
		</h2>
		<hr />
		<div id="commandBar">
			<div id="actionBox">
			  <form id="frmAction" name="frmAction" method="post" action="create-part.php">
		  		<label>Action:</label>
				<select id="category" name="category">
				<option value="*">Select...</option>
				<?php
				 echo $utility->GetCategoryList($db, '');  
				?>
				</select>
				<input id="createSubmit" name="createSubmit" type="submit" value="Go" />
			  </form>
			</div>
			<div id="searchBox">
			  <form id="frmSearch">				
				<input id="search" name="search" type="text" value="<?php echo $search ?>" />
				<input type="submit" value="Search" />
			</div>
		</div>
		<table id="partTable">
			<tr>
				<th>Action</th>
				<th>Part Number</th>
				<th style="text-align:left;padding-left:1em">Description</th>
				<th>Size</th>
				<th>Pitch</th>
				<th>Stock</th>
				<th>MSRP</th>
				<th>Dealer Cost</th>
				<th>Import Cost</th>
			</tr>
			<tr class="row">
				<?php Do {
				$page=''; 
				switch ( $row['category_id'] ) {
					case 'FS';
						$page = 'sprocket.php';
						break;
					case 'RS':
						$page = 'sprocket.php';
						break;
					case 'CH':
						$page = 'chain.php';
						break;
					case 'KT':
						$page = 'kit.php';
						break;
					case 'OT':
						$page = "other.php";
				}						
	
				?>
				
				 
				<td><!-- Action -->
					<a href="
						<?php echo $page; ?>?part_id=<?php echo $row['part_id'];?>&status=E&cat=<?php echo $row['category_id'];?>"><div class="actionEdit"></div></a>
					<a href="<?php echo $page; ?>?part_id=<?php echo $row['part_id'];?>&status=D&cat=<?php echo $row['category_id']?>"><div class="actionStatus"></div></a>
				</td>
				<td style="text-align:left;"> <!-- Part Number -->
					<?php echo $row['part_number'] ?>
				</td>
				<td style="text-align:left;padding-left:1em;"> <!-- Description -->
					<?php echo $row['part_description'] ?>
				</td>
				<td> <!-- Category -->
					<?php echo $row['category_id'] ?>
				</td>
				<td> <!-- Pitch -->
					<?php echo $row['pitch_id'] ?>
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
