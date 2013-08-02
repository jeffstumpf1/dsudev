<?php
// Validate Forms
require_once("clsCreditcard.php");
class Validator 
{

	var $error_msg;
	var $error_count;
	var $arr_errors;
	

	/*public function validateDate($str_fieldValue, $str_fieldDesc)
	{
		// replace dashes with slashes (dashes are seen as minuses)
		$str_fieldValue = str_replace('-', '/', str_fieldValue);
		if(strtotime(str_fieldValue) == -1 || strtotime(str_fieldValue) == false)
		{
			$this->build_error("Invalid date was entered ". $str_fieldDesc);
		}
	}
	*/

	function isValidEmailAddress($str_fieldValue, $str_fieldDesc)
	{
		$this->isRequiredField($str_fieldValue,$str_fieldDesc);
		if(strlen($str_fieldValue) != 0)
		{
			if (!eregi('^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$', $str_fieldValue))
			{
				$this->build_error("Invalid email address was entered ". $str_fieldDesc);
			}
		}
	}
	
/*	
	function validateIdenticalValues($str_previousValue, $str_currentValue, $str_fieldDesc)
	{
		
		// check if the current value does not match the previous
		if($str_currentValue != $str_previousValue)
		{
			$this->build_error("Values do not match for ". $str_fieldDesc);			
		}
	}
*/	

	// Security Code
	function isValidSecurityCode($str_fieldValue, $str_fieldDesc)
	{
		if($this->isValidNumeric($str_fieldValue, $str_fieldDesc))
		{
			if(strlen($str_fieldValue) != 3)
			{
				$this->build_error("Security Code Must be 3 Digits");
			}
		} else {
			$this->build_error("Only numeric values can be entered (0,1,2..) ". $str_fieldDesc);
		}
	}
	
		
	// Check for numeric values
	function isValidNumeric($str_fieldValue, $str_fieldDesc)
	{
		if(ereg('[^0-9]', $str_fieldValue)){
			return false;		
		}else {
			return true;
		}
	}
	
	
	// Process Credit Card
	function isValidCreditCard($ccName, $str_fieldValue,  $rbcc, $str_ExpireMonth, $str_ExpireYear, $str_fieldDesc)
	{
		$this->isRequiredField($str_fieldValue,$str_fieldDesc); 
		$ccType = $rbcc;
		$ccNum = $str_fieldValue;
		$ccExpM = $str_ExpireMonth;
		$ccExpY = $str_ExpireYear;
		
		$cc = new CCreditCard($ccName, $ccType, $ccNum, $ccExpM, $ccExpY);
		if(!$cc->isValid())
		{
			$this->build_error("Credit Card Number is Invalid.");
		}
	}

	// Validate proper phone formats
	function isValidPhone($bool_allowLetters = false, $str_fieldValue, $str_fieldDesc)
	{
		$this->isRequiredField($str_fieldValue,$str_fieldDesc);
		$str_phone = '';
		
		if($bool_allowLetters == false)
		{
			$str_pattern = '/[0-9]/';
		}
		else
		{
			$str_pattern = '/[[:alnum:]]/';
		}
		
		preg_match_all($str_pattern, $str_fieldValue, $arr_matches);
		
		// reform the phone number with only integers
		foreach($arr_matches[0] as $int_value)
		{
			$str_phone.=$int_value;
		}
		
		// make sure the phone length is not less than 10 integers
		// make sure the phone length is exactly 10 integers if it allows an extension
		if(strlen($str_fieldValue) != 0 && strlen($str_phone) < 10)
		{
			$this->build_error("Only numeric values for the phone, plus any extention ". $str_fieldDesc);	
		}
	}
	

	
	// Validates for a valid ziip code
	function isValidZipcode($str_fieldValue, $str_fieldDesc)
	{
		$this->isRequiredField($str_fieldValue,$str_fieldDesc);

		$str_zip = '';
		$str_pattern = '/[0-9]/';
		
		preg_match_all($str_pattern, $str_fieldValue, $arr_matches);
		
		// reform the zip code with only integers
		foreach($arr_matches[0] as $int_value)
		{
			$str_zip.=$int_value;
		}
		
		if(strlen($str_fieldValue) != 0 && strlen($str_zip) != 5 && strlen($str_zip) != 9)
		{
			$this->build_error("Invalid Zip code entered, ". $str_fieldDesc);	
		}
	}


	// Displays and Unordered list displaying the errors
	function getErrors(){
		$count = count($this->arr_errors);
		$msg='';
		
		// if no errors return 
		if($count > 0)
		{
		$msg = "";
		$msg = "<ul>";
		foreach($this->arr_errors as $item){
			//echo $item;
			$msg = $msg.'<li><span class="required">'.$item.'</span></li>';
		}
		$msg = $msg.'</ul>';
		}
		return $msg;
	}


	// Returns the number of errors if any.
	function isErrors(){
		return count($this->arr_errors);		
	}


	// Validates for a value has to be entered
	function isRequiredField($str_fieldValue, $str_fieldDesc)
	{
		if(strlen($str_fieldValue) == 0)
		{
			$this->build_error($str_fieldDesc);	
		}
	}
	
	/******** UTILTIY ****************/
	function build_error($error_msg)
	{	
		//echo $error_msg.'<br>';
		$this->error_msg = $error_msg;
		$this->arr_errors[] = $error_msg;
	}
}

?>