<?php
/*
 
 /labelprint/print-ticket.service.php?id=x
*/

	$debug = 'Off';
	require_once '../db/global.inc.php';
	
	function __autoload($class) {
		include '../classes/' . $class . '.class.php';
	}
	require 'fpdf.php';

    include'config/common.inc.php';  

   	// Create Object Customer and Request
   	$constants = new Constants;
	$order = new Order($debug, $db);
	$request = new Request;
	
	// Querystring
	$id = $request->getParam('id');
	$row = $order->GetOrderItem( $id );
		
	$pdf = new FPDF('L','mm',array($labelsize_x,$labelsize_y));
	for($i=0;$i<$row['qty'];$i++) {
		WriteLabel($pdf, $row, $spacing);
	}
		
	$data= date("dmy")+ tempnam('/labels/','pdf');  
	$fileD = $data."_".$id.".pdf";
	
	// clear exiting label if any
	//$valReturn = file_exists("/labels/$data/".$fileD);
	//mkdir("./labels/".$data, 0705);
	
	
	$pdf -> Output("labels/".$fileD,"F");

	echo "labelprint/labels/".$fileD;
	
	
	/*********************************/
function WriteLabel($pdf, $row, $spacing) {
 	$part = $row['part_number'];
	$pitch= $row['pitch_id'];
	if($pitch==-999) $pitch='';
	
	$cat = $row['category_id'];
	$order_number = $row['order_number'];
	$order_date = getdate();
	$application = $row['application'];
	$desc = $row['description'];
	$fs = $row['frontSprocket_part_number'];
	$rs = $row['rearSprocket_part_number'];
	$price = $row['unit_price'];
	$fs = $row['frontSprocket_part_number'];
	$rs = $row['rearSprocket_part_number'];
	$cl = $row['chain_length'];

	//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
	
	$pdf->AddPage();
	$pdf->SetMargins(1,2,1);
	$pdf->SetAutoPageBreak(3);
	$pdf->SetY(3) ;
	$pdf->SetFont('Arial','B',14);
	$pdf->Write(3, "PART#"."  ".$part." : ".$pitch."\n");
	$pdf->Line(2, 8, 100, 8);
	$pdf->SetFont('Arial','B',10);
	//$pdf->Text(5, 15, $address) ;
	$pdf->Write($spacing, "\n".$application);
	$pdf->Write($spacing, "\n\n".$desc);
	if($cat=='KT') {
		$pdf->Write(5, "\n"."FS: ".$fs. " / RS: ". $rs. " / CL: ". $cl);
	}
}
?>