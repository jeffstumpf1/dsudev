<?php

define("CARD_TYPE_MC", 0);
define("CARD_TYPE_VS", 1);
define("CARD_TYPE_AX", 2);
define("CARD_TYPE_DC", 3);
define("CARD_TYPE_DS", 4);
define("CARD_TYPE_JC", 5);

class CCreditCard {

	// Class Members
	var $_ccName = '';
	var $_ccType = '';
	var $_ccNum = '';
	var $_ccExpM = 0;
	var $_ccExpY = 0;
	var $_errMsg = '';
	
	
	// Consructor
	function CCreditCard($name, $type, $num, $expm, $expy) {
		// Set member variables
		if(!empty($name)) {
			$this->_ccName = $name;
		} else {
			die('Must pass name to the constructor');
		}
		
		// Make sure card type is valid
		switch(strtolower($type))
		{
			case 'mc':
			case 'mastercard':
			case 'm':
			case '1':
			{
			$this->_ccType = CARD_TYPE_MC;
			break;
			}
			case 'vs':
			case 'visa':
			case 'v':
			case '2':
			{
			$this->_ccType = CARD_TYPE_VS;
			break;
			}
			case 'ax':
			case 'american express':
			case 'a':
			case '3':
			{
			$this->_ccType = CARD_TYPE_AX;
			break;
			}
			case 'dc':
			case 'diners club':
			case '4':
			{
			$this->_ccType = CARD_TYPE_DC;
			break;
			}
			case 'ds':
			case 'discover':
			case '5':
			{
			$this->_ccType = CARD_TYPE_DS;
			break;
			}
			case 'jc':
			case 'jcb':
			case '6':
			{
			$this->_ccType = CARD_TYPE_JC;
			break;
			}
			default:
			{
			$this->_errMsg ='Invalid type ' . $type . ' passed to constructor';
			}
		}
		
		// Don't check the number yet,
		if(!empty($num))
		{
			$cardNumber = ereg_replace("[^0-9]", "", $num);
			// Make sure the card number isnt empty
			if(!empty($cardNumber)) {
				$this->_ccNum = $cardNumber;
			} else {
				$this->_errMsg ='Credit Card Number';
			}	
		} else {
			$this->_errMsg ='Credit Card Number';
		}

		
		if(!is_numeric($expm) || $expm < 0 || $expm > 12)
		{
			$this->_errMsg = 'Invalid expiry month of ' . $expm ;
		} else {
			$this->_ccExpM = $expm;
		}
		
		// Get the current year
		$currentYear = date('Y');
		settype($currentYear, 'integer');
		if(!is_numeric($expy) || $expy < $currentYear || $expy > $currentYear + 10)
		{
			$this->_errMsg = 'Invalid expiry year of ' . $expy;
		} else {
			$this->_ccExpY = $expy;
		}
	}
		
		
	// Getters
	// Get Card Holder Name
	function Name()
	{
		return $this->_ccName;
	}
	
	
	// Get Credit Card Type
	function Type()
	{
		switch($this->_ccType)
		{
			case CARD_TYPE_MC:
			{
				return 'mastercard [1]';
				break;
			}
			case CARD_TYPE_VS:
			{
				return 'Visa [2]';
				break;
			}
			case CARD_TYPE_AX:
			{
				return 'Amex [3]';
				break;
			}
			case CARD_TYPE_DC:
			{
				return 'Diners Club [4]';
				break;
			}
			case CARD_TYPE_DS:
			{
				return 'Discover [5]';
				break;
			}
			case CARD_TYPE_JC:
			{
				return 'JCB [6]';
				break;
			}
			default:
			{
				return 'Unknown [-1]';
			}
		}
	}
	
		
	// Get Credit Card Number
	function Number()
	{
		return $this->_ccNum;
	}
	
	
	// Get Epiration Month
	function ExpiryMonth()
	{
		return $this->_ccExpM;
	}
	
	
	// Get Expiry Year
	function ExpiryYear()
	{
		return $this->_ccExpY;
	}	
		
		
	
	// Mask the Credit Card Numbers
	function SafeNumber($char = 'x', $numToHide = 4)
	{
		// Return only part of the number
		if($numToHide < 4)
		{
			$numToHide = 4;
		}
		if($numToHide > 10)
		{
			$numToHide = 10;
		}
		$cardNumber = $this->_ccNum;
		$cardNumber = substr($cardNumber, 0, strlen($cardNumber) - $numToHide);
		for($i=0; $i<$numToHide; $i++)
		{
			$cardNumber .= $char;
		}
		return $cardNumber;
	}
	
	
	function IsValid()
	{
		// Not valid by default
		$validFormat = false;
		$passCheck = false;
		
		// Is the number in the correct format?
		switch($this->_ccType)
		{
			case CARD_TYPE_MC:
			{
				$validFormat = ereg("^5[1-5][0-9]{14}$", $this->_ccNum);
				break;
			}
			case CARD_TYPE_VS:
			{
				$validFormat = ereg("^4[0-9]{12}$|^4[0-9]{15}$", $this->_ccNum);
				break;
			}
			case CARD_TYPE_AX:
			{
				$validFormat = ereg("^3[4|7][0-9]{13}$", $this->_ccNum);
				break;
			}
			case CARD_TYPE_DC:
			{
				$validFormat = ereg("^30[0-5][0-9]{11}$|^3[6|8][0-9]{12}$", $this->_ccNum);
				break;
			}
			case CARD_TYPE_DS:
			{
				$validFormat = ereg("^6011[0-9]{12}$", $this->_ccNum);
				break;
			}
			case CARD_TYPE_JC:
			{
				$validFormat = ereg("^3[0-9]{15}$|^[2131|1800][0-9]{11}$", $this->_ccNum);
				break;
			}
			default:
			{
				// Should never be executed
				$validFormat = false;
			}
		}
		
		// Is the number valid against luhn?
		$cardNumber = strrev($this->_ccNum);
		$numSum = 0;
		for($i = 0; $i < strlen($cardNumber); $i++)
		{
			$currentNum = substr($cardNumber, $i, 1);
			if(floor($currentNum / 2) != $currentNum / 2)
			{
				$currentNum *= 2;
			}
			if(strlen($currentNum) == 2)
			{
				$firstNum = substr($currentNum, 0, 1);
				$secondNum = substr($currentNum, 1, 1);
				$currentNum = $firstNum + $secondNum;
			}
			$numSum += $currentNum;
		}	
		// If the total has no remained its OK
		$passCheck = ($numSum % 10 == 0 ? true : false);
		if($validFormat && $passCheck)
		{
			return true;
		} else {
			return false;
		}
	}

}

?>