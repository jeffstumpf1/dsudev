<?php 
	/* Load chain chart based on pitch , Used in Ajax call
	   select-part.php
	*/
	$debug="Off";
	$t='';
	$b0='{"id":';
	$b1='","label":"';
	$b3= '","value":"';
	$search='';
	$pitch='';
	$search= $_GET['term'];
	$pitch=$_GET['pitch'];
	
    require_once '../db/global.inc.php';
	
	$sql = sprintf("select part_number, msrp, dealer_cost, import_cost from PartMaster where rec_status='0' and category_id='FS' and pitch_id='%s' and part_number like '%s%s' limit 25",$pitch, $search,'%');
	$rs = $db->query( $sql); 
    $row = $rs->fetch();
	if($debug=="On") {
		echo $sql."<br>";
	}

while ($row = $rs->fetch() ) {
	$t= $t . $b0 .'"'. $row['part_number'] . '|'. $row['msrp'].":".$row['dealer_cost'].":".$row['import_cost'].  $b1. $row['part_number'].$b3. $row['part_number']. '"},'; 
	//$t= $t . $b3 . $row['part_number'] . '|'. $row['msrp']."*".$row['dealer_cost']."*".$row['import_cost']. '"},';   
}  

$t = substr($t, 0, $t.strlen($t)-1);
echo "[" .$t. "]";
?>