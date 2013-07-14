<?php 
	/* Load chain chart based on pitch , Used in Ajax call
	   select-chain.php
	*/
	$debug="Off";
	
    require_once '../db/global.inc.php';
    require_once '../classes/clsUtility.php';
    
    $pitch='';
	$utility = new Utility();
	$sql=''; $idx=0; $html='';
	$pitchCode = $_GET['pitch'];

	$sql = sprintf("select a.*, b.product_brand_id, b.clip_id, b.linked_chain_part_number from PartMaster a, Chain b where a.part_number = b.part_number and a.rec_status=0 and a.pitch_id='%s'", $pitchCode );
	$chart = $db->query( $sql); 
    $rowChart = $chart->fetch();
	if($debug=="On") {
		echo $sql."<br>";
	}
	
echo "<form>";
echo  '<table id="chainChartTable">';
echo  '<tr><th>Part Number</th>';
echo  '<th style="text-align:left;">Chain Description</th>';
echo  '<th>MSRP</th>';
echo  '<th>Dealer Cost</th>';
echo  '<th>Import Cost</th></tr>';
	Do {
		 $idx = $idx + 1;	
echo  '<tr class="row">';
echo  '<td> <!-- Part Number -->'. $rowChart['part_number']."-".$idx. '</td>';
echo  '<td> <!-- Chain Description --><a href="#'. $rowChart['part_number']. '" alt="'. $idx . '" class="chainSelected">'. $rowChart['part_description'] .'</a>';
echo  '</td><td> <!-- MSRP -->'. $utility->NumberFormat( $rowChart['msrp'], '$') . '</td>';
echo  '<td> <!-- Dealer Cost -->'. $utility->NumberFormat( $rowChart['dealer_cost'], '$'). '</td>';
echo  '<td> <!-- Import Cost -->'. $utility->NumberFormat( $rowChart['import_cost'], '$'). '</td>';
echo  '</tr>';

      } while ($rowChart = $chart->fetch( $chart )); 
echo  '</table></form>';

?>
