<?php
// Report.class.php
	
class Report {
	
	private $debug='Off';
	private $db;
	private $log;
	
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
	

	public function GetSalesByCustomer($customer_number) {
		$sql = sprintf("SELECT a.dba, a.customer_number, count(b.order_number) as 'Count', 
				Round(sum(b.order_total),2) as 'Total', 
				sum(b.order_shipping) as 'Shipping', 
				sum(b.order_tax) as 'Tax', b.order_date
				from Customer a 
				inner join Orders b on a.customer_number = b.customer_number
				and a.customer_number='%s'
				group by a.customer_number, b.order_date
				order by b.order_date Desc", $customer_number );
		$this->Log(__METHOD__);
		$this->Log($sql);
				
		// fetch data
		$rs = $this->db->query( $sql); 
		
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $rs;

	}
	public function GetSalesByCustomerDate($customer_number, $from, $to) {
		$sql = sprintf("SELECT a.dba, a.customer_number, count(b.order_number) as 'Count', 
				Round(sum(b.order_total),2) as 'Total', 
				sum(b.order_shipping) as 'Shipping', 
				sum(b.order_tax) as 'Tax', b.order_date
				from Customer a 
				inner join Orders b on a.customer_number = b.customer_number
				and a.customer_number='%s'
				and  (b.order_date >= '%s' AND b.order_date <= '%s')
				group by a.customer_number, b.order_date
				order by b.order_date Desc", $customer_number, $from, $to );
		$this->Log(__METHOD__);
		$this->Log($sql);
				
		// fetch data
		$rs = $this->db->query( $sql); 
		
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $rs;

	}

	
	public function GetSalesByCustomerTotals($customer_number) {
		$sql = sprintf("SELECT a.dba, a.customer_number, count(b.order_number) as 'Orders', 
				Round(sum(b.order_total),2) as 'Total', 
				sum(b.order_shipping) as 'Shipping', 
				sum(b.order_tax) as 'Tax'   
				from Customer a 
				inner join Orders b on a.customer_number = b.customer_number
				and a.customer_number='%s'
				group by a.customer_number
				order by b.order_date Desc", $customer_number);
				
		//$sql = sprintf("call GetCustomerSalesbyCustomerTotals('%s');", $customer_number );
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
	public function GetSalesByCustomerTotalsDate($customer_number, $from, $to) {
		$sql = sprintf("SELECT a.dba, a.customer_number, count(b.order_number) as 'Orders', 
				Round(sum(b.order_total),2) as 'Total', 
				sum(b.order_shipping) as 'Shipping', 
				sum(b.order_tax) as 'Tax'   
				from Customer a 
				inner join Orders b on a.customer_number = b.customer_number
				and a.customer_number='%s'
				and  (b.order_date >= '%s' AND b.order_date <= '%s')
				group by a.customer_number
				order by b.order_date Desc", $customer_number, $from, $to);
				
		//$sql = sprintf("call GetCustomerSalesbyCustomerTotals('%s');", $customer_number );
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

	
	function GetAllSales($from, $to) {
		$sql = sprintf("	SELECT a.dba , a.customer_number, count(b.order_number) as 'Count', 
			Round(sum(b.order_total),2) as 'Total'
			, sum(b.order_shipping) as 'Shipping', sum(b.order_tax) as 'Tax', b.order_date 
			from Customer a 
			inner join Orders b on a.customer_number = b.customer_number
			group by a.customer_number, b.order_date
			having  (b.order_date >= '%s' AND b.order_date <= '%s')
			order by  b.order_date Desc;", $from, $to);

		//$sql = sprintf("call GetCustomerSalesbyCustomerTotals('%s');", $customer_number );
		$this->Log(__METHOD__);
		$this->Log($sql);
		
		// fetch data
		$rs = $this->db->query( $sql); 
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		//echo $sql;
		return $rs;
	}
		
	function GetAllSalesTotalDate($from, $to) {
		$sql = sprintf("SELECT count(b.order_number) as 'Count', 
			Round(sum(b.order_total),2) as 'Total' , 
			sum(b.order_shipping) as 'Shipping', 
			sum(b.order_tax) as 'Tax'
			 from Customer a inner join Orders b on a.customer_number = b.customer_number 
			and (b.order_date >= '%s' AND b.order_date <= '%s') ", $from, $to);

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
		
			
}
?>