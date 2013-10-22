<?php
/* Customer **/

class Customer {
	
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
	
	public function ListCustomers($search) {
		$sql = "SELECT * FROM ". Constants::TABLE_CUSTOMER . " WHERE rec_status = 0 ORDER BY dba";
		if( $search ) {
			$sql = sprintf("select * from ". Constants::TABLE_CUSTOMER . " where rec_status=0 and dba like '%s%s'", $search,'%'); 
		}
		
		// fetch data
		$rs = $this->db->query( $sql);  
		if($this->debug=='On') {
			echo "sql: " . $sql . "<br>";
			print_r($rs);
		}
		
		return $rs;

	}
	

	public function ListCustomersByType($search) {
		if( $search ) {
			$sql = sprintf("select * from ". Constants::TABLE_CUSTOMER . " where rec_status=0 and customer_type='%s'", $search,'%'); 
		}
		
		// fetch data
		$rs = $this->db->query( $sql);  
		if($this->debug=='On') {
			echo "sql: " . $sql . "<br>";
			print_r($rs);
		}
		
		return $rs;

	}


	
	public function GetCustomer($customer_number) {

		$sql = sprintf("select * from ". Constants::TABLE_CUSTOMER . " where rec_status='0' and customer_number='%s'", $customer_number); 
		
		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			//print_r($rs). "<p/>";
			print_r($row). "<p/>";
		}
		
		return $row;
	}
	
	/** Used for the JQuery Autocomplete box **/
	public function CustomerAutoComplete($search) {
			
		$sql = sprintf("select dba, customer_number from %s where rec_status='0' and dba like '%s%s' limit 25",Constants::TABLE_CUSTOMER, $search,'%');
		$rs = $this->db->query( $sql); 
		
		// work var
		$t='';
		$b0='{"id":';
		$b1='","label":"';
		$b3= '","value":"';
		
		// Build JSOn
		while ($row = $rs->fetch() ) {
			$t= $t . $b0 .'"'. $row['dba'] . $b1. $row['dba'].$b3. $row['customer_number']. '"},'; 
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
	
	
	function UpdateCustomer($formData, $recMode) {
		$dba = $formData['dbaName'];
		$custnum = $formData['customerNumber'];	
		$disc = $formData['discountPct'];
		$addr = $formData['address'];	
		$city = $formData['city'];	
		$st = $formData['state']; 	
		$zip = $formData['zip']; 
		$billAddr = $formData['billingAddress'];
		$billCity = $formData['billingCity'];
		$billState = $formData['billingState'];
		$billZip = $formData['billingZip'];
		$ph1 = $formData['phone1'];    
		$ph2 = $formData['phone2'];   				
		$fax = $formData['fax'];	
		$email = $formData['email']; 
		$cc1 = $formData['cc1']; 		
		$exp1 = $formData['exp1']; 				
		$cvv1 = $formData['cvv1']; 
		$cc2 = $formData['cc2'];		
		$exp2 = $formData['exp2'];  				
		$cvv2 = $formData['cvv2']; 
		$notes = $formData['notes']; 
		$customer_id = $formData['customerID'];
		$rec_mode = $formData['rec_mode'];
		$taxable = $formData['taxable'];
		$custType = $formData['customer_type'];
		
		$cnt =0;
		
		if( strtolower($recMode) == "e") {
			$sql = "UPDATE ". Constants::TABLE_CUSTOMER . " SET dba='". $dba ."', customer_number='". $custnum ."', address='". $addr ."',";
			$sql = $sql . "city='". $city ."', state='". $st ."', zip='". $zip ."', phone1='". $ph1 ."', phone2='". $ph2 ."', fax='". $fax ."',";
			$sql = $sql . "discount='". $disc ."', email='". $email ."', notes='". $notes ."',";
			$sql = $sql . "cc_num1='". $cc1 ."', cc_exp1='". $exp1 ."', cc_cvv1='". $cvv1 ."',";
			$sql = $sql . "cc_num2='". $cc2 ."', cc_exp2='". $exp2 ."', cc_cvv2='". $cvv2 ."',taxable='" .$taxable."',";
			$sql = $sql . "customer_type='". $custType."',";
			$sql = $sql . "billing_address='" . $billAddr . "', billing_city='". $billCity ."', billing_state='". $billState . "', billing_zip='".$billZip."'";
			$sql = $sql . " WHERE customer_id=". $customer_id;
		}
		if( strtolower($recMode) == "a") {
			$sql = "INSERT INTO ". Constants::TABLE_CUSTOMER . "(dba, customer_number, address, city, state, zip, phone1, phone2, fax , discount, taxable, email, notes, cc_num1, cc_exp1, cc_cvv1, cc_num2, cc_exp2, cc_cvv2, rec_status, create_dt, billing_address, billing_city, billing_state, billing_zip, customer_type) VALUES('". $dba ."','". $custnum ."','". $addr ."','". $city ."','". $st ."','". $zip ."','". $ph1 ."','". $ph2 ."','". $fax ."','". $disc ."','". $taxable. "','". $email ."','". $notes ."','". $cc1 ."','". $exp1 ."','". $cvv1 ."','". $cc2 ."','". $exp2 ."','". $cvv2 ."','0','','". $billAddr."','".$billCity."','". $billState."','".$billZip."','".$custType."')";
		}
		$cmd = $this->db->query( $sql );
		$cnt = $cmd->affected();
		
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<br />";  
			print_r($rs);
			if($cmd->isError()) {
				echo "Error: ". $cmd->isError()."<br/>";
				echo "[".$cnt."]<br/>";
			}
		}
		
	return $cnt;
		
	}
	
	
	function DeleteCustomer($id) {
			
		$sql = "DELETE FROM ". Constants::TABLE_CUSTOMER . " WHERE customer_id=". $id;
		$cmd = $this->db->query( $sql );
		
		return $cmd->affected();
		
	}


}
?>