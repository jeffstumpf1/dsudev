<?php
	/* clsKit.php **/
	
class Kit {
	
	public $debug='On';
		
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
	
	
	
	function UpdateKit($db, $formData, $recMode) {
		
		if($this->debug=='On') {
			echo "---UpdateKit---".$recMode."<br>";
		}

		// PartMaster
		
		$productCategory = $formData['productCategory'];
		$partNumber = $formData['partNumber'];
		$partDescription = addslashes($formData['notes']);
		$stockLevel = $formData['stockLevel'];
		$msrp= $formData['msrp'];
		$dealerCost=$formData['dealerCost'];
		$importCost= $formData['importCost'];
		
		$pitch = $formData['pitch'];	
		// Kit
		$fsPartNumber = $formData['fsPartNumber'];
		$rsPartNumber= $formData['rsPartNumber'];
		$brand = $formData['brand'];	
		$clip = $formData['ml']; 
		$chainLength= 0 + $formData['chainLength'];
		
		// Unique ID's
		$partID = $formData['partID'];
		$kitID = $formData['kitID'];
		$fsPrice = $formData['fs'];
		$rsPrice = $formData['rs'];
		$chPrice = $formData['ch'];
		$chainPartNumber = $formData['chainPartNumber'];
		
		if( strtolower($recMode) == "e") {
			$sqlPartMaster = "UPDATE PartMaster SET part_number='". $partNumber ."', part_description='". $partDescription. "', stock_level=". $stockLevel .", category_id='". $productCategory ."', pitch_id='". $pitch ."', msrp=". $msrp .", dealer_cost=". $dealerCost .", import_cost=". $importCost ." WHERE part_id=". $partID;
			$sqlKit = "UPDATE ChainKit SET part_number='". $partNumber ."', category_id='". $productCategory ."', product_brand_id='".  $brand  ."', frontSprocket_part_number='" . $fsPartNumber  ."',rearSprocket_part_number='". $rsPartNumber . "', chain_length=". $chainLength .", ml_id='". $clip ."', ch_price='". $chPrice. "', fs_price='". $fsPrice. "', rs_price='". $rsPrice. "', chain_part_number='". $chainPartNumber ."' WHERE chain_kit_id=". $kitID;			
		}
		
		if( strtolower($recMode) == "a") {
			$sqlPartMaster = "INSERT INTO PartMaster(part_number, part_description, stock_level, category_id, pitch_id, msrp, dealer_cost, import_cost) VALUES ('". $partNumber ."','". $partDescription ."',". $stockLevel .",'". $productCategory ."','". $pitch ."'," .$msrp .",". $dealerCost .",". $importCost .")";			
			$sqlKit = "INSERT INTO ChainKit(part_number, category_id, product_brand_id, frontSprocket_part_number, rearSprocket_part_number, chain_length, ch_price, rs_price, fs_price, chain_part_number, ml_id) VALUES ('". $partNumber ."','". $productCategory. "','". $brand ."','". $fsPartNumber ."','" . $rsPartNumber. "',". $chainLength. ",'". $chPrice. "','". $rsPrice ."','". $fsPrice."','". $chainPartNumber. "','". $clip. "')";		
		}

		$cmd = $db->query( $sqlPartMaster );
		$retPartID = $cmd->insertID();
		$cnt = $cmd->affected();
		if ($this->debug=='On') { 
			echo $sqlPartMaster ." [".$cnt."]<br>"; 
			echo "Error:" .$cmd->isError()."<br>";
		}
		
		$cmd = $db->query( $sqlKit );
		$cnt = $cnt + $cmd->affected();
		if ($this->debug=='On') { 
			echo $sqlKit ." [".$cnt."]<br>"; 
			echo "Error:" .$cmd->isError()."<br>";
		}
		
		
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
	
	
	function UpdateKitStatus($db, $formData) {
		$partID = $formData['partID'];
		$chainID = $formData['kitID'];	
		$rec_status = $formData['recStatus'];
		$flag='0';
		
			
			$sql = "DELETE FROM PartMaster WHERE part_id=". $partID;
			$cmd = $db->query( $sql );
			$cnt = $cmd->affected();
			//echo $sql ." [".$cnt."]";
			
			$sql = "DELETE FROM ChainKit WHERE chain_kit_id=". $kitID;
			$cmd = $db->query( $sql );
			$cnt = $cnt + $cmd->affected();
			//echo $sql ." [".$cnt."]";
			
			return $cnt;
		
	}
			
}
?>