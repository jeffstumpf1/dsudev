<?php
/*
 
 /labelprint/print-part-ticket.service.php?part_number=x
*/

	$debug = 'Off';
	require_once '../db/global.inc.php';
	// Logging
	include '../log4php/Logger.php';
	Logger::configure('../logconfig.xml');
	$log = Logger::getLogger('myLogger');
 
 
 // Start logging
 
 spl_autoload_register(function ($class) {
 	include '../classes/' . $class . '.class.php';
 });


	require 'fpdf.php';

    include'config/common.inc.php';  

   	// Create Object Customer and Request
   	$constants = new Constants;
	$part = new Part($debug, $db);
	$request = new Request;
	$row='';
	
	// Querystring
	$part_number = $request->getParam('part_number');
	$category = $request->getParam('category_id');
	$ticketNumber = $request->getParam('ticket_number');
	
	$log->debug($row);
	$log->debug("Part Number:".$part_number. " Category:".$category. "Ticket Number:". $ticketNumber);

	if($category=='KT') {
		$log->debug("ListKits(".$part_number.")");
		$row = $part->GetKit( $part_number );
	} else {
		$log->debug("GetMasterPartByPartNumber(".$part_number.")");
		$row = $part->GetMasterPartByPartNumber( $part_number );
	}
	$log->debug($row);
	$pdf = new FPDF('L','mm',array($labelsize_x,$labelsize_y));
	
	// Print the tickets
	for($i=0;$i<$ticketNumber;$i++) {
		WriteLabel($pdf, $row, $spacing);
	}

		
	$data= date("dmy")+ tempnam('/labels/','pdf');  
	$fileD = $data."_".$part_number.".pdf";
	
	// clear exiting label if any
	//$valReturn = file_exists("/labels/$data/".$fileD);
	//mkdir("./labels/".$data, 0705);
	
	
	$pdf -> Output("labels/".$fileD,"F");

	echo "labelprint/labels/".$fileD;
	
	
	/*********************************/
function WriteLabel($pdf, $row, $spacing) {
	
 	$partNumber = $row['part_number'];
	$pitch= $row['pitch_id'];
	if($pitch==-999) $pitch='';
	
	$cat = $row['category_id'];
	$application = $row['part_application'];
	$desc = $row['part_description'];
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
	$pdf->Write(3, "PART#"."  ".$partNumber." : ".$pitch."\n");
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
