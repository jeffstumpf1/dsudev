<?php
// order.class.php
	
class Order {
	
	public $debug='Off';
	private $db;
	private $log;
		
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
        
        try {
        	$this->log = Logger::getLogger(__CLASS__);
			$this->Log('The class "'. __CLASS__. '" was initiated!');

		}
			catch(Exception $e) {
    		echo error($e->getMessage());
		}

    }  

	/** Logger can be used from any member method. */
    public function Log($msg, $level=null) {
    	$level = isset($level) ? $level : 'i';
    	switch (strtolower( $level )) {
    		case 't':
    			$this->log->trace($msg);
    			break;
    		case 'd':
    			$this->log->debug($msg);
    			break;
    		case 'i':
    			$this->log->info($msg);
    			break;
    		case 'w':
    			$this->log->warn($msg);
    			break;
    		case 'e':
    			$this->log->error($msg);
    			break;
    		case 'f':
    			$this->log->fatal($msg);
    			break;
    	}
	}
	


	
	public function GetActiveOrderNumber() {
		return $this->ORDER_NUMBER;
	}


	public function GetOrder($order_number) {
		$sql = sprintf( "SELECT a.*, b.* FROM ". Constants::TABLE_ORDER ." a, ".Constants::TABLE_CUSTOMER." b WHERE a.customer_number=b.customer_number AND a.order_number='%s'", $order_number);
		
		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch(); 
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($rs). "<p/>";
		}
		
		return $row;
	}

	public function SummarizeOrderPrint($order_number, $tax_rate) {
		$tax_rate +=0;
		
	    if($tax_rate!="0") {
			$sql = sprintf("select b.`order_shipping` as freight, sum(a.total) as subtotal, Round(sum(a.total * %s),2) as tax from ". Constants::TABLE_ORDER_ITEMS ." a, ". Constants::TABLE_ORDER ." b where a.order_number = b.order_number and a.order_number='%s'",$tax_rate, $order_number);
		} else
			$sql = sprintf("select b.`order_shipping` as freight, sum(a.total) as subtotal, 0 as tax from ". Constants::TABLE_ORDER_ITEMS ." a, ". Constants::TABLE_ORDER ." b where a.order_number = b.order_number and a.order_number='%s'", $order_number);
		
		$rs = $this->db->query( $sql); 
    	$row = $rs->fetch();
		if($this->debug=='On') {
			echo "<p>",__METHOD__,$order_number, $tax_rate, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		return $row;
	}

	public function ListOrders($search) {
		$sql = sprintf( "SELECT a.*, b.dba FROM ". Constants::TABLE_ORDER ." a, ".Constants::TABLE_CUSTOMER." b WHERE a.customer_number=b.customer_number AND a.rec_status='0' ORDER BY a.order_number LIMIT ".Constants::LIMIT_ROWS);
		if( $search ) {
			$sql = sprintf("select a.*, b.dba from ". Constants::TABLE_ORDER ." a, ".Constants::TABLE_CUSTOMER." b where a.customer_number=b.customer_number AND rec_status='0' and order_number like '%s%s'", $search,'%'); 
		}
		
		// fetch data
		$rs = $this->db->query( $sql);  
		if($this->debug=='On') {
			echo "sql: " . $sql . "<br>";
			print_r($rs);
		}
		
		return $rs;

	}

	public function ListCustomerOrders($search) {
		$sql = sprintf("select a.*, b.dba from ". Constants::TABLE_ORDER ." a, ".Constants::TABLE_CUSTOMER." b where a.customer_number=b.customer_number AND a.rec_status='0' and a.customer_number='%s'", $search,'%'); 
		
		// fetch data
		$rs = $this->db->query( $sql);  
		if($this->debug=='On') {
			echo "sql: " . $sql . "<br>";
			print_r($rs);
		}
		
		return $rs;

	}

	public function GetOrderItem($order_item_id) {
		$sql = sprintf( "Select * from ". Constants::TABLE_ORDER_ITEMS ." where order_number <> '' and order_item_id=%s", $order_item_id);		
		$this->Log(__METHOD__);
		$this->Log($sql);
		
		// fetch data
		$rs = $this->db->query( $sql);
		$row = $rs->fetch();  
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $row;
	}
	
	
	// Bring back one order or a set 
	public function GetItemCount($order_number) {
		$sql = sprintf( "SELECT Count(*) as itemCount FROM ". Constants::TABLE_ORDER_ITEMS ." Where order_number='%s'", $order_number);		

		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($rs). "<p/>";
		}
		
		return $row['itemCount'];
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
	    if($tax_rate>0) {
			$sql = sprintf("select b.special_instructions, b.tax_rate, b.`order_shipping`, sum(a.total) as order_items_total, Round(sum(a.total * ".$tax_rate."),2) as order_taxable from ". Constants::TABLE_ORDER_ITEMS ." a, ". Constants::TABLE_ORDER ." b where a.order_number = b.order_number and a.order_number='%s'",  $order_number);
		} else
			$sql = sprintf("select b.special_instructions, b.tax_rate, b.`order_shipping`, sum(a.total) as order_items_total, 0 as order_taxable from ". Constants::TABLE_ORDER_ITEMS ." a, ". Constants::TABLE_ORDER ." b where a.order_number = b.order_number and a.order_number='%s'",  $order_number);

		$rs = $this->db->query( $sql); 
    	$row = $rs->fetch();
		if($this->debug=='On') {
			echo "<p>",__METHOD__, $order_number, $tax_rate," - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
    	//print_r($row). "<p/>";
    	//echo $sql;
    	
    	// Dont update when there is no order
    	if($order_number) {
    	    $tr = $tax_rate;
			if(empty($tr)) $tr=0;

			$sh = 0+$row['order_shipping'];
			$t1 = 0+$row['order_items_total'];
			$tx = 0+$row['order_taxable'];
			$gt = $sh + $t1 + $tx;
			$sql = sprintf("UPDATE ". Constants::TABLE_ORDER ." SET order_status_code='OPEN', order_shipping=%s, order_tax=%s, order_total=%s, tax_rate=%s WHERE order_number='%s'", $sh, $tx, $gt, $tr, $order_number);
			$cmd = $this->db->query($sql);
		
			if($this->debug=='On') {
				echo "<p>Update only on Order<br/>";
				echo "<p>",__METHOD__, " - ", $sql, "<p />";  
				print_r($row). "<p/>";
			}
		}
		
		
	    if($tax_rate>0) {
			$sql = sprintf("select b.payment_terms_id, b.customer_po, b.order_shipping, b.tax_rate, b.`order_shipping`, sum(a.total) as order_items_total, Round(sum(a.total * ".$tax_rate."),2) as order_taxable from ". Constants::TABLE_ORDER_ITEMS ." a, ". Constants::TABLE_ORDER ." b where a.order_number = b.order_number and a.order_number='%s'",  $order_number);
		} else
			$sql = sprintf("select b.payment_terms_id, b.customer_po, b.order_shipping, b.tax_rate, b.`order_shipping`, sum(a.total) as order_items_total, 0 as order_taxable from ". Constants::TABLE_ORDER_ITEMS ." a, ". Constants::TABLE_ORDER ." b where a.order_number = b.order_number and a.order_number='%s'",  $order_number);

		$rs = $this->db->query( $sql); 
    	$row = $rs->fetch();
		if($this->debug=='On') {
			echo "<p>Last Method call to return genrated data</br>";
			echo "<p>",__METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}

		return $row;
	}
	
	
	function SaveOrder($orderNumber, $customerNumber, $customerPO, $orderDate, $orderShipping, $tax_rate, $status, $paymentTerms) {
		
		if($this->debug=='On') {
			echo "---SaveOrder---".$recMode."<br>";
			echo "Status:" .$formData['order_status'];
		}
		$orderStatus="OPEN";
				
		$sql="UPDATE ". Constants::TABLE_ORDER . " SET modified_dt='". date("m-d-Y")."',tax_rate='".$tax_rate."',order_status_code='". $orderStatus. "',order_number='".$orderNumber."',customer_number='". $customerNumber ."',order_date='". $orderDate. "',order_shipping=". $orderShipping.",customer_po='". $customerPO ."',payment_terms_id='".$paymentTerms."' WHERE order_number='". $orderNumber. "'";
					
		$cmd = $this->db->query( $sql );
		$cnt = $cmd->affected();
		if ($this->debug=='On') { 
			echo $sql ." [".$cnt."]<br>"; 
			echo "Error:" .$cmd->isError()."<br>";
		}
		$this->ORDER_NUMBER = $orderNumber;	
		return $this->ORDER_NUMBER. " order number";						
	}
	
	
	
	
	
		function UpdateOrder($formData) {
		$this->debug ='On';
		
		if($this->debug=='On') {
			echo "---UpdateOrder---".$recMode."<br>";
			echo "Status:" .$formData['order_status'];
		}

		// Order
		$orderStatus = $formData['order_status'];
		$orderNumber = $formData['order_number'];
				
		$customerNumber = $formData['customer_number'];
		$customerPO = $formData['customer_po'];
		$orderDate = $formData['order_date'];
		$orderShipping = $formData['order_shipping'];
		$orderStatus = 'OPEN';
		$tax_rate = $formData['tax_rate'];
				
		$sql="UPDATE ". Constants::TABLE_ORDER . " SET modified_dt='". date("m-d-Y")."',tax_rate='".$tax_rate."',order_status_code='". $orderStatus. "',order_number='".$orderNumber."',customer_number='". $customerNumber ."',order_date='". $orderDate. "',order_shipping=". $orderShipping.",customer_po='". $customerPO ."' WHERE order_number='". $orderNumber. "'";
		echo $sql;
					
		$cmd = $this->db->query( $sql );
		$cnt = $cmd->affected();
		if ($this->debug=='On') { 
			echo $sql ." [".$cnt."]<br>"; 
			echo "Error:" .$cmd->isError()."<br>";
		}
		$this->ORDER_NUMBER = $orderNumber;	
		return $this->ORDER_NUMBER. " order number";						
	}
	
	function NewOrder($custNumber, $taxRate, $status) {
		
		if($this->debug=='On') {
			echo "---NewOrder---".$recMode."<br>";
			echo "Status:" .$formData['order_status'];
		}

		// Order
		
		$orderNumber = $this->GetNextOrderNumber();
		$this->ORDER_NUMBER = $orderNumber;
		$customerPO = '';
		$orderDate = date("m-d-Y");
		$orderShipping = 0;

		$sql = "INSERT INTO ". Constants::TABLE_ORDER . " (order_number, order_status_code, customer_number, order_date, order_total, order_tax, order_shipping, customer_po, order_discount, create_dt, tax_rate) VALUES ('".$orderNumber. "','OPEN','". $custNumber. "','".$orderDate."',0,0,0,'".$customerPO."',0,'". date("m-d-Y")."','".$taxRate."' )";
		
		$cmd = $this->db->query( $sql );
		$retPartID = $cmd->insertID();
		$cnt = $cmd->affected();
		if ($this->debug=='On') { 
			echo $sql ." [".$cnt."]<br>"; 
			echo "Error:" .$cmd->isError()."<br>";
		}
				
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
	
	
	public function SaveNotes($order, $notes) {
		echo __METHOD__, " - ", $order, $notes, "<p />";  
		$sql = sprintf("UPDATE ".Constants::TABLE_ORDER." SET special_instructions='". $notes ."' WHERE order_number='%s'", $order);
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
	

	
	
	function UpdateOrderItem($formData) {
		
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
		$cr = $formData['carrier'];

		$description = addslashes($formData['description']);
		$application = addslashes($formData['application']);
		// two chains kit and chain itself
		if($category == 'KT') {
			$chainLength = $formData['chainLength'];
			if($chainLength=='') $chainLength=0;
		} else if ($category=='CH'){
			$chainLength = $formData['chainLengthEntry'];
			$chain_orig_msrp = $formData['originalMSRP'];
			if($chainLength=='') $chainLength=0;
		}
		$chain = $formData['h_chain'];
		$msrp = $formData['msrp'];
		$qty = $formData['qty'];
		$boQty = $formData['bo-qty'];
		$discountPrice = $formData['discount-price'];
		$unitPrice = $formData['unit-price'];
		$total = $formData['total'];
		$id = $formData['h_order_item_id'];
		$pitch = $formData['h_pitch'];
		if($pitch=='') $pitch = -999;
		
		if($formData['h_status']=="E") {
			$recMode = 'e';
		} else {
			$recMode = 'a';
		}
				
		if( strtolower($recMode) == "e") {
			$sql = "UPDATE ". Constants::TABLE_ORDER_ITEMS ." SET chain_orig_msrp=". $chain_orig_msrp. ",bo_qty=". $boQty. ",pitch_id=".$pitch.",order_number='".$orderNumber."', discount=". $discount.",category_id='".$category."', part_number='".$partNumber."', frontSprocket_part_number='". $fs. "', rearSprocket_part_number='". $rs. "', chain_part_number='".$chain."', carrier_part_number='". $cr. "',description='".$description."',application='".$application."',chain_length=". $chainLength.",msrp=".$msrp.",qty=".$qty.",discount_price=".$discountPrice.",unit_price=".$unitPrice.",total=".$total." where order_item_id=".$id;
		}
		
		if( strtolower($recMode) == "a") {
			$sql = "INSERT INTO ". Constants::TABLE_ORDER_ITEMS . " (chain_orig_msrp, pitch_id, order_number, discount, category_id, part_number, frontSprocket_part_number, rearSprocket_part_number, carrier_part_number, chain_part_number, description, application, chain_length, msrp, qty, discount_price, bo_qty, unit_price, total) VALUES (".$chain_orig_msrp.",".$pitch.",'".$orderNumber. "',".$discount.",'". $category. "','".$partNumber."','".$fs."','". $rs. "','". $cr ."','". $chain ."','". $description."','".$application."',". $chainLength.",". $msrp. ",". $qty. ",". $discountPrice . ",". $boQty. ",". $unitPrice. ",". $total. ")";
		}
		$this->Log(__METHOD__);
		$this->Log($sql);
		echo $sql;
		
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