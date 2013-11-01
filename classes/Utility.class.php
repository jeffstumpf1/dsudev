<?php
 /* utiltiy.class.php **/

class Utility {

	private $debug='Off';
	
	public function __construct($debug)  
    {  
    	$this->debug = $debug;
    	if($this->debug=='On') {
        	echo 'The class "', __CLASS__, '" was initiated!<br />';  
        }
    }  

	public function GetDate() {
		$currentDate = date("m-d-Y");
		
		return $currentDate;
	}

	public function GetRecStatus($status) {
		$str='';
		switch ($status) {
			case '0':
				$str = 'Active';
				break;
			case '1':
				$str = 'Inactive';
				break;
		}
		return $str;	
	}


	// Number Format
	public function NumberFormat( $val, $out ) {
		$retVal = 0;
		switch ($out) {
			case '$':
				if($val==0 || val=='') {
					$retVal = '';
				} else
					$retVal = money_format('$%i', $val);
				break;
			case '':
				$retVal = money_format('%i', $val);
				break;
		}		
		
		return $retVal;
	}


	// Number Format
	public function CalculateChainCost( $val, $chainLength, $out ) {
		$retVal = 0;

		$val = $val * $chainLength;
		switch ($out) {
			case '$':
				$retVal = money_format('$%i', $val);
				break;
			case '0':
				$retVal = money_format('%i', $val);
				break;
		}		
		
		return $retVal;
	}
	
	
	public function unescape($string){

		$search = array("\\x00", "\\n", "\\r", "\\\x1a");

		$replace = array("\x00","\n", "\r", "\x1a");

		$retString = str_replace($search, $replace, $string);

		$search = array("\'", '\\'.'"');

		$replace = array(  "'", '"',);

		$retString = str_replace($search, $replace, $retString);

		$search = array("\\\\");

		$replace = array( "\\");

		$retString = str_replace($search, $replace, $retString);

		return $retString;

}

}
?>