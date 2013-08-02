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
	$sql = "select * from PartMaster where rec_status='0' LIMIT 50";
	
	if(isset($_GET['status'])) {
		$recMode = (get_magic_quotes_gpc()) ? $_GET['status'] : addslashes($_GET['status']);
	}
	if(isset($_GET['cat'])) {
		$partCat = (get_magic_quotes_gpc()) ? $_GET['cat'] : addslashes($_GET['cat']);
	}
	if(isset($_GET['search'])) {
		$search = (get_magic_quotes_gpc()) ? $_GET['search'] : addslashes($_GET['search']);
		$sql = sprintf("select * from PartMaster where rec_status='0' and part_number like '%s%s' LIMIT 50", $search,'%');
	}
    // fetch data
	
    $rs = $db->query( $sql); 
    $row = $rs->fetch();
	if($debug=="On") { echo $sql; }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<meta charset="utf-8" />
	<title>Part Listing</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>	
<script>

$(function() {
    	
    	$("#category").val(0);
    	$("#createSubmit").attr('disabled','disabled');
    	
    	
		$( "#search" ).on('mouseup', function() {
			 $(this).select(); 	
		});
		
		$("#category").change(function() {
		  	$sel = $('#category').val();
		 	if($sel != '*') {
		 		$('#createSubmit').removeAttr('disabled');
		 	} else
		 	  $("#createSubmit").attr('disabled','disabled');  
		});
		
		$('.actionStatus').click(function(e){
			$part = $(this).parent().attr('pn');
			$ct = $(this).parent().attr('ct');
			$title = 'Deleting Part ('+ $part + ')';
			$( "#dialog-confirm" ).attr('title',$title);
			$( "#dialog-confirm" ).dialog({
			  resizable: false,
			  height:200,
			  modal: true,
			  buttons: {
				"Delete": function() {
				  $( this ).dialog( "close" );
				  DeletePartSelected($part, $ct);
				},
				Cancel: function() {
				  $( this ).dialog( "close" );
				}
			  }
			});
			
		});
		
		function DeletePartSelected($part, $cat) {
		$.ajax({ 
			  type: 'GET',
			  url: 'service/delete-part.php',
			  data: { part_number: $part, cat: $cat },
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
				alert(data);
				location.reload();
			  },
			  error:function(){
				alert('Error: part not deleted');
			  }
			});
		}
});
</script>
	
</head>
<body>

<div id="dialog-confirm" title="Remove Part?">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>This part will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>

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
<?php include 'includes/action-logic.php'?>
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
