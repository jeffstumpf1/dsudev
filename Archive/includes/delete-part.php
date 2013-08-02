<?php
/** Delete Part **/
	$debug="Off";
	
    require_once '../db/global.inc.php';
    require_once '../classes/clsUtility.php';

$partID = $_GET['part_id'];
$cat = $_GET['cat_id']

	
	$sql = "DELETE FROM PartMaster WHERE part_id=". $partID;
	$cmd = $db->query( $sql );
	$cnt = $cmd->affected();
	//echo $sql ." [".$cnt."]";
	
	$sql = "DELETE FROM ChainKit WHERE chain_kit_id=". $kitID;
	$cmd = $db->query( $sql );
	$cnt = $cnt + $cmd->affected();
	//echo $sql ." [".$cnt."]";
	
	return $cnt;
?>