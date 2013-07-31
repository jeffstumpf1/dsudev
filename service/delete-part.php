<?php
/** Delete Part **/
	$debug="Off";
	
    require_once '../db/global.inc.php';
    require_once '../classes/clsUtility.php';

	$part = $_GET['part_number'];
	$cat = $_GET['cat'];

	
	$sql = sprintf("DELETE FROM PartMaster WHERE part_number ='%s'", $part);
	$cmd = $db->query( $sql );
	$cnt = $cmd->affected();
	if ($debug=='On') { echo $sql ."<br>"; }	

	
	switch ( $cat ) {
		case 'KT':
			$sql = sprintf("DELETE FROM ChainKit WHERE part_number='%s'", $part);	
			break;
		case 'CH':
			$sql = sprintf("DELETE FROM Chain WHERE part_number='%s'", $part);	
			break;
		case 'FS':
			$sql = sprintf("DELETE FROM Sprocket WHERE part_number='%s'", $part);	
			break;
		case 'RS':
			$sql = sprintf("DELETE FROM Sprocket WHERE part_number='%s'", $part);	
			break;
		case 'OT':
			//$sql = "DELETE FROM Other WHERE part_number=". $part;	
			break;
	}
	
	$cmd = $db->query( $sql );
	$cnt = $cnt + $cmd->affected();
if ($debug=='On') { echo $sql .' '. $cnt."<br>"; }	
	if ($cnt==2) {
		echo "Part Deleted: ". $part;
	} else 
		echo "Part Not Deleted: ". $part;
?>