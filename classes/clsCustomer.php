<?php
/* Customer **/

class Customer {
	
	function UpdateCustomer($db, $formData, $recMode) {
		$dba = $formData['dbaName'];
		$custnum = $formData['customerNumber'];	
		$disc = $formData['discountPct'];
		$addr = $formData['address'];	
		$city = $formData['city'];	
		$st = $formData['state']; 	
		$zip = $formData['zip']; 
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
		//echo $rec_mode. "->";
		
		if( strtolower($recMode) == "e") {
			$sql = "UPDATE Customer SET dba='". $dba ."', customer_number='". $custnum ."', address='". $addr ."',";
			$sql = $sql . "city='". $city ."', state='". $st ."', zip='". $zip ."', phone1='". $ph1 ."', phone2='". $ph2 ."', fax='". $fax ."',";
			$sql = $sql . "discount='". $disc ."', email='". $email ."', notes='". $notes ."',";
			$sql = $sql . "cc_num1='". $cc1 ."', cc_exp1='". $exp1 ."', cc_cvv1='". $cvv1 ."',";
			$sql = $sql . "cc_num2='". $cc2 ."', cc_exp2='". $exp2 ."', cc_cvv2='". $cvv2 ."' ";
			$sql = $sql . " WHERE customer_id=". $customer_id;
		}
		if( strtolower($recMode) == "a") {
			$sql = "INSERT INTO Customer(dba, customer_number, address, city, state, zip, phone1, phone2, fax , discount, email, notes, cc_num1, cc_exp1, cc_cvv1, cc_num2, cc_exp2, cc_cvv2, rec_status, create_dt) VALUES('". $dba ."','". $custnum ."','". $addr ."','". $city ."','". $st ."','". $zip ."','". $ph1 ."','". $ph2 ."','". $fax ."','". $disc ."','". $email ."','". $notes ."','". $cc1 ."','". $exp1 ."','". $cvv1 ."','". $cc2 ."','". $exp2 ."','". $cvv2 ."','0','')";
		}
		$cmd = $db->query( $sql );
		return $cmd->affected();
		
	}
	
	
	function UpdateCustomerStatus($db, $formData) {
		$customer_id = $formData['customerID'];
		$rec_status = $formData['recStatus'];
		$flag='0';
		if (isset($rec_status)) {
			
			if ($rec_status == '0') {
				$flag='1';
			} else {
				$flag ='0';
			}
			
			//echo "customer_id[".$customer_id."]";
			
			$sql = "UPDATE Customer SET rec_status='". $flag ."' WHERE customer_id=". $customer_id;
			$cmd = $db->query( $sql );
			
			return $cmd->affected();
		}
		
	}
	
	
	function GetCustomerList() {
		$sql = "SELECT * FROM Customer WHERE rec_status = 0 ORDER BY dba";
	    $rs = $db->query( $sql);
	    
		return $rs->fetch();
	}
}
?>