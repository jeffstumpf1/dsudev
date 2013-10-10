<?php
// sprocket.class.php
	
class Sprocket {
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
	

	public function GetSprocket($id) {
		$sql = sprintf( "select a.*,b.* FROM ". Constants::TABLE_PART . " a, ". Constants::TABLE_SPROCKET . " b where a.part_number = b.part_number and a.rec_status='0' and a.part_id = %s", $id );
		
		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $row;
	}


	public function GetSprocketByPartNumber($part_number) {
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






	
	/** Used for the JQuery Autocomplete box **/
	public function SprocketAutoComplete($cat, $pitch, $search) {
		$sql = sprintf("select part_number, msrp, dealer_cost, import_cost from %s where rec_status='0' and category_id='%s' and pitch_id='%s' and part_number like '%s%s' limit 25",Constants::TABLE_PART, $cat, $pitch, $search,'%');
		$rs = $this->db->query( $sql); 
		
		// work var
		$t='';
		$b0='{"id":';
		$b1='","label":"';
		$b3= '","value":"';
		
		// Build JSOn
		while ($row = $rs->fetch() ) {
			$t= $t . $b0 .'"'. $row['part_number'] . '|'. $row['msrp'].":".$row['dealer_cost'].":".$row['import_cost'].  $b1. $row['part_number'].$b3. $row['part_number']. '"},'; 
			//$t= $t . $b3 . $row['part_number'] . '|'. $row['msrp']."*".$row['dealer_cost']."*".$row['import_cost']. '"},';   
		}  

		$t = substr($t, 0, $t.strlen($t)-1);
		$json = "[" .$t. "]";
		
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			//print_r($rs). "<p/>";
			echo $json . "<p/>";
		}
		
		return $json;

	}

	
	
	function UpdateSprocket($formData, $recMode) {
		
		$productCategory = $formData['productCategory'];
		$partNumber = $formData['partNumber'];
		$size = $formData['size'];	
		$stockLevel = $formData['stockLevel'];
		$pitch = $formData['pitch'];	
		$brand = $formData['brand'];	
		$partDescription = addslashes($formData['partDescription']); 	
		$notes = $formData['notes']; 
		$msrp = $formData['msrp'];   
		$dealerCost = $formData['dealerCost'];
		$importCost = $formData['importCost'];
		$partID = $formData['partID'];
		$sprocketID = $formData['sprocketID'];
		$partApplication=addslashes($formData['partApplication']);

		if( strtolower($recMode) == "e") {
			$sqlPartMaster = "UPDATE ". Constants::TABLE_PART. " SET part_number='". $partNumber ."', part_description='". $partDescription."',part_application='". $partApplication. "', stock_level=". $stockLevel .", category_id='". $productCategory ."', pitch_id='". $pitch ."', msrp=". $msrp .", dealer_cost=". $dealerCost .", import_cost=". $importCost ." WHERE part_id=". $partID;
			$sqlSprocket = "UPDATE ". Constants::TABLE_SPROCKET. " SET part_number='". $partNumber ."', category_id='". $productCategory ."', sprocket_notes='".  $notes ."'  WHERE sprocket_id=". $sprocketID;			
		}
		
		if( strtolower($recMode) == "a") {
			$sqlPartMaster = "INSERT INTO ". Constants::TABLE_PART ."(part_number, part_description, part_application, stock_level, category_id, pitch_id, msrp, dealer_cost, import_cost) VALUES ('". $partNumber ."','". $partDescription ."','".$partApplication."',". $stockLevel .",'". $productCategory ."','". $pitch ."'," .$msrp .",". $dealerCost .",". $importCost .")";			
			$sqlSprocket = "INSERT INTO ". Constants::TABLE_SPROCKET. "(part_number, category_id, sprocket_notes, sprocket_size) VALUES ('". $partNumber ."','". $productCategory. "','". $notes ."',". $size .")";			
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
		$cmd = $this->db->query( $sqlSprocket );
		$cnt = $cnt + $cmd->affected();

		if($this->debug=='On') {
			echo "<p>",__METHOD__, " - ", $sqlSprocket;  
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
	
	
	
	function UpdateSprocketStatus($formData) {
		$partID = $formData['partID'];
		$sprocketID = $formData['sprocketID'];	
	
		$sql = "DELETE FROM ". Constants::TABLE_PART. " WHERE part_id=". $partID;
		$cmd = $db->query( $sqlPart );
		$cnt = $cmd->affected();
		
		$sql = "DELETE FROM ". Constants::TABLE_SPROCKET. " WHERE sprocket_id=". $sprocketID;
		$cmd = $db->query( $sql );
		$cnt = $cnt + $cmd->affected();
		
		
		return $cnt;
		
	}
			
}
?>