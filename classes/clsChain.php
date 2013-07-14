<?php
	/* clsChain.php **/
	
class Chain {
	
	public $debug='Off';
	
	function SetDebug($debug) {
		$this->debug = $debug;
	}
	
	
	function UpdateChain($db, $formData, $recMode) {
		
		if($this->debug=='On') {
			echo "---UpdateChain---";
		}

		// PartMaster
		$productCategory = $formData['productCategory'];
		$partNumber = $formData['partNumber'];
		$partDescription = addslashes($formData['partDescription']);
		$stockLevel = $formData['stockLevel'];
		$pitch = $formData['pitch'];	
		$msrp = $formData['msrp'];   
		$dealerCost = $formData['dealerCost'];
		$importCost = $formData['importCost'];
		// Chain
		$linkedChainPart=addslashes($formData['linkedChainPart']);
		$linkedChainPartDescription=addslashes($formData['linkedChainPartDescription']);
		$brand = $formData['brand'];	
		$clip = $formData['clip']; 
		// Unique ID's
		$partID = $formData['partID'];
		$chainID = $formData['chainID'];
		
		if( strtolower($recMode) == "e") {
			$sqlPartMaster = "UPDATE PartMaster SET part_number='". $partNumber ."', part_description='". $partDescription. "', stock_level=". $stockLevel .", category_id='". $productCategory ."', pitch_id='". $pitch ."', msrp=". $msrp .", dealer_cost=". $dealerCost .", import_cost=". $importCost ." WHERE part_id=". $partID;
			$sqlChain = "UPDATE Chain SET part_number='". $partNumber ."', category_id='". $productCategory ."', product_brand_id='".  $brand ."', linked_chain_part_number='". $linkedChainPart . "', linked_chain_part_description='". $linkedChainPartDescription ."', clip_id='" . $clip ."' WHERE chain_id=". $chainID;			
		}
		
		if( strtolower($recMode) == "a") {
			$sqlPartMaster = "INSERT INTO PartMaster(part_number, part_description, stock_level, category_id, pitch_id, msrp, dealer_cost, import_cost) VALUES ('". $partNumber ."','". $partDescription ."',". $stockLevel .",'". $productCategory ."','". $pitch ."'," .$msrp .",". $dealerCost .",". $importCost .")";			
			$sqlChain = "INSERT INTO Chain(part_number, category_id, product_brand_id, linked_chain_part_number, linked_chain_part_description, clip_id) VALUES ('". $partNumber ."','". $productCategory. "','". $brand ."','". $linkedChainPart ."','" . $linkedChainPartDescription. "','". $clip ."')";		
		}
		
		$cmd = $db->query( $sqlPartMaster );
		$retPartID = $cmd->insertID();
		$cnt = $cmd->affected();
		if ($this->debug=='On') { 
			echo $sqlPartMaster ." [".$cnt."]<br>"; 
		}
		
		$cmd = $db->query( $sqlChain );
		$cnt = $cnt + $cmd->affected();
		if ($this->debug=='On') { echo $sqlChain ." [".$cnt."]<br>"; }
		
		
		if ($this->debug=='On') { 
			echo "------------<br>"; 
			echo "returnPartID: " . $retPartID;
		}		
			
		// need to send back the part_id
		if (strtolower($recMode) == 'a') { 
			return $retPartID;	
		} else  
		    return $partID;
		    	
	}
	
	
	
	function UpdateChainStatus($db, $formData) {
		$partID = $formData['partID'];
		$chainID = $formData['chainID'];	
		$rec_status = $formData['recStatus'];
		$flag='0';
		
		if (isset($rec_status)) {
			
			if ($rec_status == '0') {
				$flag='1';
			} else {
				$flag ='0';
			}
			
			$sql = "UPDATE PartMaster SET rec_status='". $flag ."' WHERE part_id=". $partID;
			$cmd = $db->query( $sql );
			$cnt = $cmd->affected();
			//echo $sql ." [".$cnt."]";
			
			$sql = "UPDATE Chain SET rec_status='". $flag ."' WHERE chain_id=". $chainID;
			$cmd = $db->query( $sql );
			$cnt = $cnt + $cmd->affected();
			//echo $sql ." [".$cnt."]";
			
			return $cnt;
		}
	}
			
}
?>