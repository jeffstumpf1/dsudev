<?php 
	/* Load chain chart based on pitch , Used in Ajax call
	   select-chain.php
	*/
	$debug="Off";
	
    require_once '../db/global.inc.php';
    require_once '../classes/clsUtility.php';
    
    $pitch='';
    $chainLength=1;
    $part='';
    $pos='0';
    $find='';
    
	$utility = new Utility();
	$sql=''; $idx=0; $html='';
	
	if(isset($_GET['pitch'])) {
		$pitch = (get_magic_quotes_gpc()) ? $_GET['pitch'] : addslashes($_GET['pitch']);
	}
	
	if(isset($_GET['chainLength'])) {
		$chainLength = (get_magic_quotes_gpc()) ? $_GET['chainLength'] : addslashes($_GET['chainLength']);
	} 
	
	if(isset($_GET['part'])) {
		$part = (get_magic_quotes_gpc()) ? $_GET['part'] : addslashes($_GET['part']);
	}
		
	$sql = sprintf("select a.*, b.product_brand_id, b.clip_id, b.linked_chain_part_number from PartMaster a, Chain b where a.part_number = b.part_number and a.rec_status=0 and a.pitch_id='%s'", $pitch );
	$chart = $db->query( $sql); 
    $rowChart = $chart->fetch();
	if($debug=="On") {
		echo $sql."<br>";
		echo $part."<br>";
	}
	
echo "<form>";
echo  '<table id="chainChartTable">';
echo  '<tr style="width:80px;"><th>Action</th><th>Part Number</th>';
echo  '<th style="text-align:left;">Chain Description</th>';
echo  '<th style="text-align:right;">MSRP</th>';
echo  '<th style="text-align:right;">Dealer Cost</th>';
echo  '<th style="text-align:right;">Import Cost</th></tr>';
	Do {
		 $idx = $idx + 1;	
		 $val = $rowChart['part_number'] .'-'. $idx. '|' . 
		 	$utility->CalculateChainCost( $rowChart['msrp'], $chainLength, '0') .':'. 
		 	$utility->CalculateChainCost( $rowChart['dealer_cost'], $chainLength, '0'). ':' . 
		 	$utility->CalculateChainCost( $rowChart['import_cost'], $chainLength, '0');

	$find = $rowChart['part_number'] .'-'. $idx;

	$pos = strpos($part, $find);
	$checked="";
	if( $pos === false ) {		// strpos returns and integer not a false
		$checked="";
	} else	{
		$checked ="CHECKED";
	}
		
	if($debug=='On') { 
		echo "DEBUG - part:".$rowChart['part_number'] .'-'. $idx.  " -> ". $part."<br>"; 
		echo "Search:" .$search. " - " . "find: ". $find."<br>";		
	}
		
echo  '<tr class="row">';
echo  '<td><input type="radio" name="iCheck" value="'. $val . '"'. $checked. ' alt="'. $idx. '"/></td>';
echo  '<td> <!-- Part Number -->'. $rowChart['part_number'] . "-" . $idx . '</td>';
echo  '<td style="text-align:left;"> <!-- Chain Description -->' . $rowChart['part_description'].'</td>';
echo  '<td style="text-align:right;"> <!-- MSRP -->'. $utility->CalculateChainCost( $rowChart['msrp'], $chainLength, '$') . '</td>';
echo  '<td style="text-align:right;"> <!-- Dealer Cost -->'. $utility->CalculateChainCost( $rowChart['dealer_cost'], $chainLength, '$') . '</td>';
echo  '<td style="text-align:right;"> <!-- Import Cost -->'. $utility->CalculateChainCost( $rowChart['import_cost'], $chainLength, '$') . '</td>';
echo  '</tr>';

      } while ($rowChart = $chart->fetch( $chart )); 
echo  '</table></form>';

?>
