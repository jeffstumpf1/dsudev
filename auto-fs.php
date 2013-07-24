<?php 
	/* Load chain chart based on pitch , Used in Ajax call
	   select-part.php
	*/
	$debug="Off";
	$t='';
	
	$search='';
	$search= $_GET['term'];
	
    require_once '../db/global.inc.php';
	
	$sql = sprintf("select part_number from PartMaster where rec_status='0' and category_id='FS' and part_number like '%s%s' limit 25", $search,'%');
	$rs = $db->query( $sql); 
    $row = $rs->fetch();
	if($debug=="On") {
		echo $sql."<br>";
	}

while ($row = $rs->fetch() ) {
	$t= $t . '"'. $row['part_number'] . '",';
}
$t = substr($t, 0, $t.strlen($t)-1);
echo "[" .$t. "]";
?>