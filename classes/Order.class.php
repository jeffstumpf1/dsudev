<?php
// order.class.php
	
class Order {
	
	public $debug='On';
	private $db;
		
	private $po_number='';
	private $paymentTerms='';
	private $invoice_date='';
	private $invoice_number=0;
	private $customer_name='';
	private $customer_number='';
	private $order_total=0;
	private $frieght_total=0;
	private $taxable_total=0;
	
	private $orderItems = '';  
	
	//$orderItems = new OrderItems();	
	
	public function __construct($debug, $db)  
    {  
    	$this->debug = $debug;
    	$this->db = $db;
    	if($this->debug=='On') {
        	echo 'The class "', __CLASS__, '" was initiated!<br />';  
        }
    }  
	

	public function GetOrderInformation($order_number) {
		$sql = sprintf( "SELECT * FROM ". Constants::TABLE_ORDER ." WHERE order_number = '%s'", $order_number );
		
		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $row;
	}
	
	
	
	function UpdateOrder($formData, $recMode) {
		
		if($this->debug=='On') {
			echo "---UpdateKit---".$recMode."<br>";
		}

		// PartMaster
		
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
			$sqlPartMaster = "UPDATE PartMaster SET part_number='". $partNumber ."', part_description='". $partDescription."',part_application='". $partApplication. "', stock_level=". $stockLevel .", category_id='". $productCategory ."', pitch_id='". $pitch ."', msrp=". $msrp .", dealer_cost=". $dealerCost .", import_cost=". $importCost ." WHERE part_id=". $partID;
			$sqlKit = "UPDATE ChainKit SET part_number='". $partNumber ."', category_id='". $productCategory ."', product_brand_id='".  $brand  ."', frontSprocket_part_number='" . $fsPartNumber  ."',rearSprocket_part_number='". $rsPartNumber . "', chain_length=". $chainLength .", ml_id='". $clip ."', ch_price='". $chPrice. "', fs_price='". $fsPrice. "', rs_price='". $rsPrice. "', chain_part_number='". $chainPartNumber ."' WHERE chain_kit_id=". $kitID;			
		}
		
		if( strtolower($recMode) == "a") {
			$sqlPartMaster = "INSERT INTO PartMaster(part_number, part_description, part_application, stock_level, category_id, pitch_id, msrp, dealer_cost, import_cost) VALUES ('". $partNumber ."','". $partDescription ."','".$partApplication."',". $stockLevel .",'". $productCategory ."','". $pitch ."'," .$msrp .",". $dealerCost .",". $importCost .")";			
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
	
	
	function UpdateOrderStatus($formData) {
		$partID = $formData['partID'];
		$chainID = $formData['kitID'];	

		
		$sql = "DELETE FROM PartMaster WHERE part_id=". $partID;
		$cmd = $db->query( $sql );
		$cnt = $cmd->affected();
		//echo $sql ." [".$cnt."]";
		
		$sql = "DELETE FROM ChainKit WHERE chain_kit_id=". $kitID;
		$cmd = $this->db->query( $sql );
		$cnt = $cnt + $cmd->affected();
		//echo $sql ." [".$cnt."]";
		
		return $cnt;
		
	}
	
	function GetNextOrderNumber() {
		$invoice ='';
		$sql = "select propValue+1 as invoiceNumber from properties where propName='invoiceNumber'";
		$rs = $this->db->query( $sql); 
    	$row = $rs->fetch();
		
		return $row['invoiceNumber'];
	}
			
}
?>