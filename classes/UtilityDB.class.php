<?php
 /* utiltiyDB.class.php **/

class UtilityDB {

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

	
	/*
    * MySQL server hostname
    * @access public
    * @retuns string
    */
	function LookupList($compValue, $table){
		// fetch data
		$sql = "SELECT short_code, description FROM ". $table ." WHERE rec_status = 0 ORDER BY description";
	    $rs = $this->db->query( $sql);
	    
		while ($row = $rs->fetch()) {
			$html = "";
			if( $compValue == strtoupper( $row['short_code'])) {
				echo "<option value='". $row['short_code'] ."' SELECTED>". $row['description'] ."</option>";
			} else {
				echo "<option value='". $row['short_code'] ."'>". $row['description'] ."</option>";
			} 
			//mysql_free_result($rs);
		}
		    	
    	if($this->debug=='On') {
        	echo 'The class "', __CLASS__, '" was initiated!<br />'; 
        	echo 'compValue: ', $compValue, "<br>"; 
        }

	}
	
	public function BuildJSONKeyValue($row, $var) {
	
		$field = '"' . $var . '":"' . $row[$var] . '", ';
		
		return $field;
	}
	
}
?>