<?php
/* chain.class.php **/
	
class Chain {
	
	private $debug='Off';
	private $db;
	
	public function __construct($debug, $db)  
    {  
    	$this->debug = $debug;
    	$this->db = $db;
    	if($this->debug=='On') {
        	echo 'The class "', __CLASS__, '" was initiated!<br />';  
        }
    }  
	

	public function GetChain($id) {
		$sql = sprintf( "select a.*,b.chain_id, b.product_brand_id, b.linked_chain_part_number, b.clip_id from ". Constants::TABLE_PART . " a, ". Constants::TABLE_CHAIN . " b where a.part_number = b.part_number and a.rec_status='0' and a.part_id = %s", $id );
		
		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $row;
	}

	public function GetChainByPartNumber($part_number) {
		$sql = sprintf( "select * from %s where part_number='%s'", Constants::TABLE_CHAIN, $part_number);
		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $row;
	}
	
	function UpdateChain($formData, $recMode) {
		
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
		$brand = $formData['brand'];	
		$clip = $formData['clip']; 
		$partApplication=$formData['partApplication'];
		// Unique ID's
		$partID = $formData['partID'];
		$chainID = $formData['chainID'];
		
		if( strtolower($recMode) == "e") {
			$sqlPartMaster = "UPDATE ". Constants::TABLE_PART. " SET part_number='". $partNumber ."', part_description='". $partDescription."',part_application='". $partApplication. "', stock_level=". $stockLevel .", category_id='". $productCategory ."', pitch_id='". $pitch ."', msrp=". $msrp .", dealer_cost=". $dealerCost .", import_cost=". $importCost ." WHERE part_id=". $partID;
			$sqlChain = "UPDATE ". Constants::TABLE_CHAIN ." SET part_number='". $partNumber ."', category_id='". $productCategory ."', product_brand_id='".  $brand  ."', clip_id='" . $clip ."' WHERE chain_id=". $chainID;			
		}
		
		if( strtolower($recMode) == "a") {
			$sqlPartMaster = "INSERT INTO ". Constants::TABLE_PART ."(part_number, part_description, part_application, stock_level, category_id, pitch_id, msrp, dealer_cost, import_cost) VALUES ('". $partNumber ."','". $partDescription ."','".$partApplication."',". $stockLevel .",'". $productCategory ."','". $pitch ."'," .$msrp .",". $dealerCost .",". $importCost .")";			
			$sqlChain = "INSERT INTO ". Constants::TABLE_CHAIN ."(part_number, category_id, product_brand_id, clip_id) VALUES ('". $partNumber ."','". $productCategory. "','". $brand ."','". $clip ."')";		
		}
		
		//Process Master part
		$cmd = $this->db->query( $sqlPartMaster ); 
		$cnt = $cmd->affected();
		
		// Get the part id if its a new record to pass back
		if(strtolower($recMode == "a")) {
			$retPartID = $cmd->insertID();
		}
				
		if($this->debug=='On') {
			echo "<p>", __METHOD__, " - ", $sqlPartMaster; 
			echo " [", $cnt, "]</p>"; 
			if($cmd->isError()) {
				echo "<p>Error: ". $cmd->isError()."</p>";
			}			
		}
	
		// Process Chain
		$cmd = $this->db->query( $sqlChain );
		$cnt = $cnt + $cmd->affected();

		if($this->debug=='On') {
			echo "<p>",__METHOD__, " - ", $sqlChain;  
			echo " [", $cnt, "]</p>"; 
			if($cmd->isError()) {
				echo "<p>Error: ". $cmd->isError()."</p>";
			}
		}
		
		
		// need to send back the part_id
		if (strtolower($recMode) == 'a') { 
			return $retPartID;	
		} else  
		    return $partID;
		    	
	}
	
	
	
	function UpdateChainStatus($formData) {
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
			
			$sql = "DELETE FROM ". Constants::TABLE_PART. " WHERE part_id=". $partID;
			$cmd = $db->query( $sql );
			$cnt = $cmd->affected();
			//echo $sql ." [".$cnt."]";
			
			$sql = "DELETE FROM ". Constants::TABLE_CHAIN ." WHERE chain_id=". $chainID;
			$cmd = $this->db->query( $sql );
			$cnt = $cnt + $cmd->affected();
			
			return $cnt;
		}
	}
			
}
?>