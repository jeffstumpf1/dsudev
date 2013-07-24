<?php 
    //if ( isset($_POST['formAction']) ) { header("Location: part-list.php"); }
    
    $debug = 'Off';
	
    require_once 'db/global.inc.php';
	require_once 'classes/clsKit.php'; 
	require 'classes/clsUtility.php';
    
    error_reporting(E_ERROR);

	$DOCUMENT_ROOT="";
	$status="";
	$recMode="";
	$kit = new Kit();
	$utility = new Utility();
	$kit->SetDebug($debug);


	if(isset($_GET['part_id'])) {
		$part_id = (get_magic_quotes_gpc()) ? $_GET['part_id'] : addslashes($_GET['part_id']);
	}
	


    // fetch data
	$sql = sprintf( "select a.*,b.* from PartMaster a, ChainKit b where a.part_number = b.part_number and a.rec_status=0 and and a.category_id='KT' a.part_id = %s", $part_id );
    $rs = $db->query( $sql); 
    $row = $rs->fetch();

	if ($debug=='On') { echo $sql."<br>"; }	
	

?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang='en' xml:lang='en' xmlns='http://www.w3.org/1999/xhtml'>

<head>
	<title><?php echo($partCat)?>Chain Maintenance</title>
	<link href="css/layout.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>	
  	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<link href="css/square/square.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.icheck.js"></script>
	<script type="text/javascript" src="js/kit-pricing.js"></script>
	 
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
			Chain Kit Pricing Estimator<hr />
		</h2>
		


		<div id="formContent">
			<div class="group">
				<div class="kitSpacers">
					<label class="titleTop" style="margin-left:0">Part</label><br/>
<?php
include 'includes/part_logic.php';
?>					
				</div>
				<div class="kitSpacers">
					<label class="titleTop" for="pitch">Pitch</label><br/>
<?php 
include 'includes/pitch-list.php';
?>
				</div>
				<div class="kitSpacers">
					<label class="titleTop" for="brand">MFG</label><br/>
<?php 
include 'includes/brand-list.php';
?>
				</div>
				<div class="kitSpacers">
					<label class="titleTop" for="ML">Master</label><br/>
					<select id="ML"  name="frm[ml']" >
						<option value="*">Select</option>
						<option value="ML">M/L</option>
					</select>
				</div>


				<div class="kitSpacers">
					<label class="titleTop" for="fsPartNumber">Front Sprocket</label><br/>
					<input id="fsPartNumber"  name="frm[fsPartNumber']" type="text" />
				</div>
				
				<div class="kitSpacers">
					<label  class="titleTop" for="rsPartNumber">Rear Sprocket</label><br/>
					<input id="rsPartNumber"  name="frm[rsPartNumber']" type="text" />
				</div>
				<div class="kitSpacers">
					<label  class="titleTop" for="chainLength">Chain Length</label><br/>
					<input id="chainLength"  name="frm[chainLength']" type="text" />
				</div>

			</div>
	
			
			<div class="groupCommand">			
				<div id="formCommands">
					<?php
					require($DOCUMENT_ROOT . "includes/formCommand.php");
					?>
					<input type="text" id="fs" value=""/>
					<input type="text" id="rs" value=""/>
					<input type="text" id="ch" value=""/>
				</div>
			</div>
			
			
			
		</div>
		

		
		
		<hr>
		
		<div id="chainChart">
			<div id="chartList">Please select a pitch to select a chain</div>
		</div>
		
</div>
	<div id="footer">
		Copyright © Site name, 20XX
	</div>
</div>
<div id="log"></div>
</body>
</html>
