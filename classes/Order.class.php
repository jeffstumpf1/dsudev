<?php
// order.class.php
	
class Order {
	
	public $debug='Off';
	private $db;
		
	private $ORDER_NUMBER='';
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
	
	
	public function GetActiveOrderNumber() {
		return $this->ORDER_NUMBER;
	}


	public function ListOrders($search) {
		$sql = sprintf( "SELECT * FROM ". Constants::TABLE_ORDER ." WHERE rec_status='0' ORDER BY order_number LIMIT ".Constants::LIMIT_ROWS);
		if( $search ) {
			$sql = sprintf("select * from ". Constants::TABLE_ORDER . " where rec_status='0' and order_number like '%s%s'", $search,'%'); 
		}
		
		// fetch data
		$rs = $this->db->query( $sql);  
		if($this->debug=='On') {
			echo "sql: " . $sql . "<br>";
			print_r($rs);
		}
		
		return $rs;

	}

	
	
	// Bring back one order or a set 
	public function GetOrderItems($order_number) {
		$sql = sprintf( "SELECT * FROM ". Constants::TABLE_ORDER_ITEMS ." Where order_number='%s'", $order_number);		
		
		// fetch data
		$rs = $this->db->query( $sql);  
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($rs). "<p/>";
		}
		
		return $rs;
	}
	
	// Sums order totals less shipping
	public function SummarizeOrder($order_number, $tax_rate) {
		$sql = sprintf("select b.customer_po, b.`order_shipping`, sum(a.total) as order_items_total, Round(sum(a.total * %s),2) as order_taxable from ". Constants::TABLE_ORDER_ITEMS ." a, ". Constants::TABLE_ORDER ." b where a.order_number = b.order_number and a.order_number='%s'", $tax_rate, $order_number);
		
		$rs = $this->db->query( $sql); 
    	$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
    	
    	$sh = 0+$row['order_shipping'];
    	$t1 = 0+$row['order_items_total'];
    	$tx = 0+$row['order_taxable'];
    	$gt = $sh + $t1 + $tx;
    	
    	// Dont update when there is no order
    	if($order_number) {
			$sql = sprintf("UPDATE ". Constants::TABLE_ORDER ." SET order_shipping=%s, order_tax=%s, order_total=%s WHERE order_number='%s'", $sh, $tx, $gt, $order_number);
			$cmd = $this->db->query($sql);
		
			if($this->debug=='On') {
				echo __METHOD__, " - ", $sql, "<p />";  
				print_r($row). "<p/>";
			}
		}
		return $row;
	}
	
	
	
	function UpdateOrder($formData, $recMode) {
		
		if($this->debug=='On') {
			echo "---UpdateOrder---".$recMode."<br>";
			echo "Status:" .$formData['order_status'];
		}

		// Order
		$orderStatus = $formData['order_status'];
		if ($orderStatus == 'NEW') {
			$orderNumber = $this->GetNextOrderNumber();
			$recMode="a";
		} else {
			$orderNumber = $formData['order_number'];
			$recMode="e";
		}
		
		$this->ORDER_NUMBER = $orderNumber;
			
		$customerNumber = $formData['customer_number'];
		$customerPO = $formData['customer_po'];
		$orderDate = $formData['order_date'];
		$orderTotal = $formData['order_total'];
		$orderTax = $formData['order_tax'];
		$orderShipping = $formData['order_shipping'];
		$orderDiscount = $formData['order_discount'];
		
				
		if( strtolower($recMode) == "e") {
		 $sql="UPDATE ". Constants::TABLE_ORDER . " SET order_status_code='". $orderStatus. "',order_number='".$orderNumber."',customer_number='". $customerNumber ."',order_date='". $orderDate. "',order_total=".$orderTotal. ",order_tax=".$orderTax.",order_shipping=". $orderShipping.",customer_po='". $customerPO ."', order_discount=". $orderDiscount. " WHERE order_number='". $orderNumber. "'";
		}
		
		if( strtolower($recMode) == "a") {
			$sql = "INSERT INTO ". Constants::TABLE_ORDER . " (order_number, customer_number, order_date, order_total, order_tax, order_shipping, customer_po, order_discount) VALUES ('".$orderNumber. "','". $customerNumber. "','".$orderDate."',0,0,0,'".$customerPO."',". $orderDiscount.")";
		}
		
		$cmd = $this->db->query( $sql );
		$retPartID = $cmd->insertID();
		$cnt = $cmd->affected();
		if ($this->debug=='On') { 
			echo $sql ." [".$cnt."]<br>"; 
			echo "Error:" .$cmd->isError()."<br>";
		}
				
					
		// need to send back the part_id
		if (strtolower($recMode) == 'a') { 
			return $order_number;
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
    	
    	$invoice = $row['invoiceNumber'];
		
		if ($this->debug=='On') { 
			echo __METHOD__, " - ", $sql, "<p />";
			echo $sql ."<br>"; 
			echo "Invoice:" .$invoice ."<br>";
		}

		//update it 
		$sql = "update properties set propValue=". $invoice . " where propName='invoiceNumber'";
		$cmd = $this->db->query( $sql );
	
		return $invoice;
	}
	


	public function DeleteOrder($order_number) {
		echo __METHOD__, " - ", $order_number, "<p />";  
		$sql = sprintf("DELETE FROM %s WHERE order_number='%s'", Constants::TABLE_ORDER, $order_number);
		$sql1 = sprintf("DELETE FROM %s WHERE order_number='%s'", Constants::TABLE_ORDER_ITEMS, $order_number);
		$cmd = $this->db->query( $sql );
		$cnt = $cmd->affected();
		
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<br />";  
			if($cmd->isError()) {
				echo "Error: ". $cmd->isError()."<br/>";
				echo "[".$cnt."]<br/>";
			}
		}

		$cmd = $this->db->query( $sql1 );
		$cnt = $cmd->affected();
		
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql1, "<br />";  
			if($cmd->isError()) {
				echo "Error: ". $cmd->isError()."<br/>";
				echo "[".$cnt."]<br/>";
			}
		}		
		return $cnt;
	}	
	
	
	
	public function DeleteOrderItem($order_id) {
		echo __METHOD__, " - ", $part, $cat, "<p />";  
		$sql = sprintf("DELETE FROM %s WHERE order_item_id =%s", Constants::TABLE_ORDER_ITEMS, $order_id);
		$cmd = $this->db->query( $sql );
		$cnt = $cmd->affected();
		
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<br />";  
			if($cmd->isError()) {
				echo "Error: ". $cmd->isError()."<br/>";
				echo "[".$cnt."]<br/>";
			}
		}
		
		return $cnt;
	}	
	
	
	
	
	
	
		function UpdateOrderItem($formData, $recMode) {
		
		if($this->debug=='On') {
			echo "---UpdateOrderItem---".$recMode."<br>";
			echo $formData;
		}

		// Order Item
		$orderNumber = $formData['h_order'];
		$partNumber = $formData['partNumber'];
		$discount = $formData['discount'];
		$category = $formData['h_cat'];
		$fs = $formData['frontSprocket'];
		$rs = $formData['rearSprocket'];
		$description = addslashes($formData['description']);
		$application = addslashes($formData['application']);
		$chainLength = $formData['chainLength'];
		if($chainLength=='') $chainLength=0;
		
		$msrp = $formData['msrp'];
		$qty = $formData['qty'];
		$discountPrice = $formData['discount-price'];
		$unitPrice = $formData['unit-price'];
		$total = $formData['total'];
		
				
		if( strtolower($recMode) == "e") {
		}
		
		if( strtolower($recMode) == "a") {
			$sql = "INSERT INTO ". Constants::TABLE_ORDER_ITEMS . " (order_number, discount, category_id, part_number, frontSprocket_part_number, rearSprocket_part_number, description, application, chain_length, msrp, qty, discount_price, unit_price, total) VALUES ('".$orderNumber. "',".$discount.",'". $category. "','".$partNumber."','".$fs."','". $rs ."','". $description."','".$application."',". $chainLength.",". $msrp. ",". $qty. ",". $discountPrice . ",". $unitPrice. ",". $total. ")";
		}
		
		$cmd = $this->db->query( $sql );
		$retPartID = $cmd->insertID();
		$cnt = $cmd->affected();
		if ($this->debug=='On') { 
			echo $sql ." [".$cnt."]<br>"; 
			echo "Error:" .$cmd->isError()."<br>";
		}
				
					
		// need to send back the part_id
		if (strtolower($recMode) == 'a') { 
			return $retPartID;	
		} else  
		    return $partID;		    	
	}
			
}
?>