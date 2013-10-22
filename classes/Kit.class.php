<?php
// kit.class.php
	
class Kit {
	
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
	

	public function GetChainKit($id) {
		$sql = sprintf( "select a.*,b.* FROM ". Constants::TABLE_PART . " a, ". Constants::TABLE_CHAIN_KIT . " b where a.part_number = b.part_number and a.rec_status='0' and a.category_id='KT' and a.part_id = %s", $id );
		
		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $row;
	}
	
	public function GetChainKitByPartNumber($part_number) {
		$sql = sprintf( "select * from %s where part_number='%s'", Constants::TABLE_CHAIN_KIT, $part_number);
		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $row;
	}


	public function GetChainChart($pitch) {
		$sql = sprintf("select a.*, b.* from ". Constants::TABLE_PART . " a, ". Constants::TABLE_CHAIN . " b where a.part_number = b.part_number and a.category_id='CH' and a.rec_status=0 and a.pitch_id='%s' order by b.sequence, b.product_brand_id", $pitch );
		
		// fetch data
		$rs = $this->db->query( $sql);  
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($rs). "<p/>";
		}
		
		return $rs;
	}

	

	
	function UpdateChainKit($formData, $recMode) {

		$productCategory = $formData['productCategory'];
		$partNumber = $formData['partNumber'];
		$partDescription = addslashes($formData['notes']);
		$partApplication= addslashes($formData['partApplication']);
		
		$stockLevel = $formData['stockLevel'];
		$msrp= $formData['msrp'];
		$dealerCost=$formData['dealerCost'];
		$importCost= $formData['importCost'];
		
		$pitch = $formData['pitch'];	
		// Kit
		$fsPartNumber = $formData['fsPartNumber'];
		$rsPartNumber= $formData['rsPartNumber'];
		$crPartNumber= $formData['crPartNumber'];
	
		$brand = $formData['brand'];	
		$clip = $formData['clip']; 
		$chainLength= 0 + $formData['chainLength'];
		
		// Unique ID's
		$partID = $formData['partID'];
		$kitID = $formData['kitID'];
		$fsPrice = $formData['fs'];
		$rsPrice = $formData['rs'];
		$chPrice = $formData['ch'];
		$crPrice = $formData['cr'];
		$chainPartNumber = $formData['chainPartNumber'];
		
		if( strtolower($recMode) == "e") {
			$sqlPartMaster = "UPDATE ". Constants::TABLE_PART. " SET part_number='". $partNumber ."', part_description='". $partDescription."',part_application='". $partApplication. "', stock_level=". $stockLevel .", category_id='". $productCategory ."', pitch_id='". $pitch ."', msrp=". $msrp .", dealer_cost=". $dealerCost .", import_cost=". $importCost ." WHERE part_id=". $partID;
			$sqlKit = "UPDATE ". Constants::TABLE_CHAIN_KIT. " SET part_number='". $partNumber ."', category_id='". $productCategory ."', product_brand_id='".  $brand  ."', frontSprocket_part_number='" . $fsPartNumber  ."',rearSprocket_part_number='". $rsPartNumber ."',carrier_part_number='". $crPartNumber ."', chain_length=". $chainLength .", clip_id='". $clip ."', ch_price='". $chPrice. "', fs_price='". $fsPrice. "', rs_price='". $rsPrice."', cr_price='". $crPrice. "', chain_part_number='". $chainPartNumber ."' WHERE chain_kit_id=". $kitID;			
		}
		
		if( strtolower($recMode) == "a") {
			$sqlPartMaster = "INSERT INTO ". Constants::TABLE_PART ."(part_number, part_description, part_application, stock_level, category_id, pitch_id, msrp, dealer_cost, import_cost) VALUES ('". $partNumber ."','". $partDescription ."','".$partApplication."',". $stockLevel .",'". $productCategory ."','". $pitch ."'," .$msrp .",". $dealerCost .",". $importCost .")";			
			$sqlKit = "INSERT INTO ". Constants::TABLE_CHAIN_KIT. "(part_number, category_id, product_brand_id, frontSprocket_part_number, rearSprocket_part_number, carrier_part_number,chain_length, ch_price, rs_price, fs_price, cr_price, chain_part_number, clip_id) VALUES ('". $partNumber ."','". $productCategory. "','". $brand ."','". $fsPartNumber ."','" . $rsPartNumber. "','" . $crPartNumber. "',". $chainLength. ",'". $chPrice. "','". $rsPrice ."','". $fsPrice."','". $crPrice."','". $chainPartNumber. "','". $clip. "')";		
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


		// Process Kit
		$cmd = $this->db->query( $sqlKit );
		$cnt = $cnt + $cmd->affected();

		if($this->debug=='On') {
			echo "<p>",__METHOD__, " - ", $sqlKit;  
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
	
	
	function UpdateChainKitStatus($formData) {
		$partID = $formData['partID'];
		$chainID = $formData['kitID'];	
			
		$sql = "DELETE FROM ". Constants::TABLE_PART. " WHERE part_id=". $partID;
		$cmd = $db->query( $sql );
		$cnt = $cmd->affected();
		
		$sql = "DELETE FROM ". Constants::TABLE_CHAIN_KIT. " WHERE chain_kit_id=". $kitID;
		$cmd = $db->query( $sql );
		$cnt = $cnt + $cmd->affected();
		
		return $cnt;
		
	}
			
}
?>