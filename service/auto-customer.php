<?php 
	/* Load Customers , Used in Ajax call
	   auto-customer.php
	*/
	$debug="Off";
	$t='';
	$b0='{"id":';
	$b1='","label":"';
	$b3= '","value":"';
	$search='';
	$search= $_GET['term'];
	
    require_once '../db/global.inc.php';
	
	$sql = sprintf("select dba, customer_number from Customer where rec_status='0' and dba like '%s%s' limit 25",  $search,'%');
	$rs = $db->query( $sql); 

	if($debug=="On") {
		echo $sql."<br>";
	}

while ($row = $rs->fetch() ) {
	$t= $t . $b0 .'"'. $row['dba'] . $b1. $row['dba'].$b3. $row['customer_number']. '"},'; 
}  

$t = substr($t, 0, $t.strlen($t)-1);
echo "[" .$t. "]";
?>