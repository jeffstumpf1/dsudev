<?php
// Other.class.php
	
class Other {
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
	

	public function GetOther($id) {
		$sql = sprintf( "select a.* FROM ". Constants::TABLE_PART . " a  where a.part_id = %s", $id );
		
		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $row;
	}


	public function GetOtherByPartNumber($part_number) {
		$sql = sprintf( "select * from %s where part_number='%s'", Constants::TABLE_SPROCKET, $part_number);
		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $row;
	}

	
	
	function UpdateOther($formData, $recMode) {
		
		$productCategory = $formData['productCategory'];
		$partNumber = $formData['partNumber'];
		$size = $formData['size'];	
		$stockLevel = $formData['stockLevel'];
		$partDescription = addslashes($formData['partDescription']); 	
		$partApplication = addslashes($formData['partApplication']); 
		$msrp = $formData['msrp'];   
		$dealerCost = $formData['dealerCost'];
		$importCost = $formData['importCost'];
		$partID = $formData['partID'];
		$sprocketID = $formData['sprocketID'];
		$partApplication=addslashes($formData['partApplication']);

		if( strtolower($recMode) == "e") {
			$sqlPartMaster = "UPDATE ". Constants::TABLE_PART. " SET part_number='". $partNumber ."', part_description='". $partDescription. "', part_application='". $partApplication."', stock_level=". $stockLevel .", category_id='". $productCategory ."', msrp=". $msrp .", dealer_cost=". $dealerCost .", import_cost=". $importCost ." WHERE part_id=". $partID;
		}
		
		if( strtolower($recMode) == "a") {
			$sqlPartMaster = "INSERT INTO ". Constants::TABLE_PART ."(part_number, part_description, part_application, stock_level, category_id, msrp, dealer_cost, import_cost) VALUES ('". $partNumber ."','". $partDescription."','". $partApplication."',". $stockLevel .",'". $productCategory ."'," .$msrp .",". $dealerCost .",". $importCost .")";			
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


		// need to send back the part_id
		if (strtolower($recMode) == 'a') { 
			return $retPartID;	
		} else  
		    return $partID;
	
	}
	
				
}
?>