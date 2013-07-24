<?php
	/* clsKit.php **/
	
class Kit {
	
	public $debug='Off';
		
	var $partNumber='';
	var $productCategory='';
	var $pitch='';
	var $brand='';
	var $description='';
	var $fsPartNumber='';
	var $fsSize;
	var $rsPartNumber='';
	var $rsSize='';
	var $ml='';
	var $chainLength=0;
	var $linkedPart='';
	var $linkedDesc='';
	
	
	function SetDebug($debug) {
		$this->debug = $debug;
	}
	
	/*
	 * Calculate Chain cost for Part number
	*/
	function CalculateChainCost($chainLength, $cost) {
		$price =0;
		
		
		return $price;
	}
	
	
	function UpdateKit($db, $formData, $recMode) {
		
		if($this->debug=='On') {
			echo "---UpdateKit---";
		}

		// PartMaster
		$productCategory = $formData['productCategory'];
		$partNumber = $formData['partNumber'];
		$description = addslashes($formData['partDescription']);
		//$stockLevel = $formData['stockLevel'];
		$pitch = $formData['pitch'];	
		$msrp = $formData['msrp'];   
		$dealerCost = $formData['dealerCost'];
		$importCost = $formData['importCost'];
		// Kit
		$fsPartNumber = $formData['fsPartNumber'];
		$fsSize = $formData['fsSize'];
		$rsPartNumber= $formData['rsPartNumber'];
		$rsSize = $formData['rsSize'];
		$brand = $formData['brand'];	
		$clip = $formData['clip']; 
		$chainLength= $formData['chainLength'];
		$linkedDesc=$formData['linkedDescription'];
		$linkedPart=$formData['linkedPart'];
		$stockLevel=0;
		
		// Unique ID's
		$partID = $formData['partID'];
		$chainID = $formData['chainID'];
		
		if( strtolower($recMode) == "e") {
			$sqlPartMaster = "UPDATE PartMaster SET part_number='". $partNumber ."', part_description='". $partDescription. "', stock_level=". $stockLevel .", category_id='". $productCategory ."', pitch_id='". $pitch ."', msrp=". $msrp .", dealer_cost=". $dealerCost .", import_cost=". $importCost ." WHERE part_id=". $partID;
			$sqlKit = "UPDATE ChainKit SET part_number='". $partNumber ."', category_id='". $productCategory ."', product_brand_id='".  $brand  ."', frontSprocket_part_number='" . $fsPartNumber ."', frontSprocket_size=". $fsSize .",rearSprocket_part_number='". $rsPartNumber ."', rearSprocket_size=". $rsSize .", chain_length=". $chainLength .", linked_chain_part_number='". $linkedPart  ."', linked_chain_part_description='". $linkedDesc ."' WHERE part_id=". $partID;			
		}
		
		if( strtolower($recMode) == "a") {
			$sqlPartMaster = "INSERT INTO PartMaster(part_number, part_description, stock_level, category_id, pitch_id, msrp, dealer_cost, import_cost) VALUES ('". $partNumber ."','". $partDescription ."',". $stockLevel .",'". $productCategory ."','". $pitch ."'," .$msrp .",". $dealerCost .",". $importCost .")";			
			$sqlKit = "INSERT INTO ChainKit(part_number, category_id, product_brand_id, frontSprocket_part_number, frontSprocket_size, rearSprocket_part_number, rearSprocket_size, chain_length, linked_chain_part_number, linked_chain_part_description) VALUES ('". $partNumber ."','". $productCategory. "','". $brand ."','". $fsPartNumber ."'," . $fsSize .",'". $rsPartNumber. "',". $rsSize .",". $chainLength. ",'". $linkedPart. "','". $linkedDesc. "')";		
		}
		
		$cmd = $db->query( $sqlPartMaster );
		$retPartID = $cmd->insertID();
		$cnt = $cmd->affected();
		if ($this->debug=='On') { 
			echo $sqlPartMaster ." [".$cnt."]<br>"; 
		}
		
		$cmd = $db->query( $sqlKit );
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
			
			$sql = "DELETE FROM PartMaster WHERE part_id=". $partID;
			$cmd = $db->query( $sql );
			$cnt = $cmd->affected();
			//echo $sql ." [".$cnt."]";
			
			$sql = "DELETE FROM Chain WHERE chain_id=". $chainID;
			$cmd = $db->query( $sql );
			$cnt = $cnt + $cmd->affected();
			//echo $sql ." [".$cnt."]";
			
			return $cnt;
		}
	}
			
}
?>