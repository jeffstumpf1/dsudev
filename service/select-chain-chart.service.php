<?php 
	/* Load chain chart based on pitch , Used in Ajax call
	   select-chain.php
	   
	   /service/select-chain-chart.service.php?pitch=520&part=DS520HRXK-12&chainLength=10
	*/
	$debug = 'Off';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
   
   	// Create Object Customer and Request
	$constants = new Constants;
	$kit = new Kit($debug, $db);
	$request  = new Request;
	$utilityDB = new UtilityDB($debug, $db);
	$utility  = new Utility($debug);

	// Get Query Parameters
	$pitch  = $request->getParam('pitch','');
	$chainLength  = $request->getParam('chainLength','');
	$part = $request->getParam('part');
	$action  = $request->getParam('formAction','');   
	$idx=0;
			
	// Get Info and Display
	$rs = $kit->GetChainChart($pitch);
	
	
echo "<form>";
echo  '<table id="chainChartTable">';
echo  '<tr style="width:80px;"><th>Action</th><th>Part Number</th>';
echo  '<th style="text-align:left;">Chain Description</th>';
echo  '<th style="text-align:right;">MSRP</th>';
echo  '<th style="text-align:right;">Dealer Cost</th>';
echo  '<th style="text-align:right;">Import Cost</th></tr>';
	 while ($row = $rs->fetch()) {
		 //$idx++;	
		 //$val = $row['part_number'] .'-'. $idx. '|' . 
		 $val = $row['part_number'] . '|' . 
		 	$utility->CalculateChainCost( $row['msrp'], $chainLength, '0') .':'. 
		 	$utility->CalculateChainCost( $row['dealer_cost'], $chainLength, '0'). ':' . 
		 	$utility->CalculateChainCost( $row['import_cost'], $chainLength, '0');

	//$find = $row['part_number'] .'-'. $idx;
	$find = $row['part_number'];

	$pos = strpos($part, $find);
	$checked="";
	if( $pos === false ) {		// strpos returns and integer not a false
		$checked="";
	} else	{
		$checked ="CHECKED";
	}
		
	if($debug=='On') { 
		echo "DEBUG - part:".$row['part_number']  ." -> ". $part."<br>"; 
		echo "Search:" .$search. " - " . "find: ". $find."<br>";		
	}
		
echo  '<tr class="row">';
echo  '<td><input type="radio" name="iCheck" value="'. $val . '"'. $checked. ' alt="'. $row['sequence']. '" di="'.$row['part_description'].'" /></td>';
echo  '<td> <!-- Part Number -->'. $row['part_number'] . '-' . $row['sequence'].'</td>';
echo  '<td style="text-align:left;"> <!-- Chain Description -->' . $row['part_description'].'</td>';
echo  '<td style="text-align:right;"> <!-- MSRP -->'. $utility->CalculateChainCost( $row['msrp'], $chainLength, '$') . '</td>';
echo  '<td style="text-align:right;"> <!-- Dealer Cost -->'. $utility->CalculateChainCost( $row['dealer_cost'], $chainLength, '$') . '</td>';
echo  '<td style="text-align:right;"> <!-- Import Cost -->'. $utility->CalculateChainCost( $row['import_cost'], $chainLength, '$') . '</td>';
echo  '</tr>';

      } 
echo  '</table></form>';

?>
