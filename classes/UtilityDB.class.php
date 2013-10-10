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
		$sql = "SELECT short_code, description FROM ". $table ." WHERE rec_status = 0 ORDER BY sequence";
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
	
	function GetStateList($db, $state){
		// fetch data
		$sql = "SELECT * FROM StateList WHERE rec_status = 0";
	    $rs = $this->db->query( $sql);
	    
		while ($row = $rs->fetch()) {
			$html = "";
			if( $state == strtoupper( $row['short_code'])) {
				echo "<option value='". $row['short_code'] ."' SELECTED>". $row['description'] ."</option>";
			} else {
				echo "<option value='". $row['short_code'] ."'>". $row['description'] ."</option>";
			} 
			//mysql_free_result($rs);
		}
	}	
	
		function GetPitchList($db, $pitch){
		// fetch data
		$sql = "SELECT * FROM PitchList WHERE rec_status = 0 ORDER BY short_code";
	    $rs = $this->db->query( $sql);
	    
		while ($row = $rs->fetch()) {
			$html = "";
			
			if( $pitch == $row['short_code']) {
				echo "<option value='". $row['short_code'] ."' SELECTED>". $row['description'] ."</option>";
			} else {
				echo "<option value='". $row['short_code'] ."'>". $row['description'] ."</option>";
			} 
			//mysql_free_result($rs);
		}
	}
	
	
		function GetBrandList($db, $brand){
		// fetch data
		$sql = "SELECT * FROM ProductBrandList WHERE rec_status = 0 ORDER BY short_code";
	    $rs = $this->db->query( $sql);
	    
		while ($row = $rs->fetch()) {
			$html = "";
			if( $brand == strtoupper( $row['short_code'])) {
				echo "<option value='". $row['short_code'] ."' SELECTED>". $row['description'] ."</option>";
			} else {
				echo "<option value='". $row['short_code'] ."'>". $row['description'] ."</option>";
			} 
			//mysql_free_result($rs);
		}
	}



	function GetClipList($db, $clip){
		// fetch data
		$sql = "SELECT * FROM ClipList WHERE rec_status = 0";
	    $rs = $this->db->query( $sql);
	    
		while ($row = $rs->fetch()) {
			$html = "";
			if( $clip == strtoupper( $row['short_code'])) {
				echo "<option value='". $row['short_code'] ."' SELECTED>". $row['description'] ."</option>";
			} else {
				echo "<option value='". $row['short_code'] ."'>". $row['description'] ."</option>";
			} 
			//mysql_free_result($rs);
		}
	}


	
	
	public function BuildJSONKeyValue($row, $var) {
	
		$field = '"' . $var . '":' . json_encode($row[$var]) . ', ';
		
		return $field;
	}
	
}
?>