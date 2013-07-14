<?php
	/* clsSprocket.php **/
	
class Sprocket {
	public $debug='Off';
	
	function SetDebug($debug) {
		$this->debug = $debug;
	}
	
	
	function UpdateSprocket($db, $formData, $recMode) {
	
		if($this->debug=='On') {
			echo "---UpdateSprocket---".$recMode."<br>";
		}
		
		$productCategory = $formData['productCategory'];
		$partNumber = $formData['partNumber'];
		$size = $formData['size'];	
		$stockLevel = $formData['stockLevel'];
		$pitch = $formData['pitch'];	
		$brand = $formData['brand'];	
		$partDescription = $formData['partDescription']; 	
		$notes = $formData['notes']; 
		$msrp = $formData['msrp'];   
		$dealerCost = $formData['dealerCost'];
		$importCost = $formData['importCost'];
		$partID = $formData['partID'];
		$sprocketID = $formData['sprocketID'];
		
		if( strtolower($recMode) == "e") {
			$sqlPartMaster = "UPDATE PartMaster SET part_number='". $partNumber ."', part_description='". $partDescription. "', stock_level=". $stockLevel .", category_id='". $productCategory ."', pitch_id='". $pitch ."', msrp=". $msrp .", dealer_cost=". $dealerCost .", import_cost=". $importCost ." WHERE part_id=". $partID;
			$sqlSprocket = "UPDATE Sprocket SET part_number='". $partNumber ."', category_id='". $productCategory ."', sprocket_notes='".  $notes ."', sprocket_size=". $size ." WHERE sprocket_id=". $sprocketID;			
		}
		
		if( strtolower($recMode) == "a") {
			$sqlPartMaster = "INSERT INTO PartMaster(part_number, part_description, stock_level, category_id, pitch_id, msrp, dealer_cost, import_cost) VALUES ('". $partNumber ."','". $partDescription ."',". $stockLevel .",'". $productCategory ."','". $pitch ."'," .$msrp .",". $dealerCost .",". $importCost .")";			
			$sqlSprocket = "INSERT INTO Sprocket(part_number, category_id, sprocket_notes, sprocket_size) VALUES ('". $partNumber ."','". $productCategory. "','". $notes ."',". $size .")";			
		}
				
		
		$cmd = $db->query( $sqlPartMaster );
		$retPartID = $cmd->insertID();
		$cnt = $cmd->affected();
		if ($this->debug=='On') { 
			echo $sqlPartMaster ." [".$cnt."]<br>";
			echo "$retPartID [".$retPartID."]<br>";
			echo "Error:" .$cmd->isError();
		 }
		
		$cmd = $db->query( $sqlSprocket );
		$cnt = $cnt + $cmd->affected();
		if ($this->debug=='On') { 
			echo $sqlSprocket ." [".$cnt."]<br>";
		 }

		if ($this->debug=='On') { "------------<br>"; }	
		
		// need to send back the part_id
		if (strtolower($recMode) == 'a') { 
			return $retPartID;	
		} else  
		    return $partID;
	
	}
	
	
	
	function UpdateSprocketStatus($db, $formData) {
		$partID = $formData['partID'];
		$sprocketID = $formData['sprocketID'];	
		$rec_status = $formData['recStatus'];
		$flag='0';
		
		if (isset($rec_status)) {
			
			if ($rec_status == '0') {
				$flag='1';
			} else {
				$flag ='0';
			}
		
			$sqlPart = "UPDATE PartMaster SET rec_status='". $flag ."' WHERE part_id=". $partID;
			$cmd = $db->query( $sqlPart );
			$cnt = $cmd->affected();
			
			$sql = "UPDATE Sprocket SET rec_status='". $flag ."' WHERE sprocket_id=". $sprocketID;
			$cmd = $db->query( $sql );
			$cnt = $cnt + $cmd->affected();
			
			if($this->debug=="On") {
				echo "UpdateSprocketStatus Delete";
				echo $sqlPart. "[" . $cnt. "]<br/>";
				echo $sql. "["  .$cnt. "]<br/>";
				echo "Error:" .$cmd->isError();
			}
			
			return $cnt;
		}
	}
			
}
?>