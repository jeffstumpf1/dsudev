<?php
 /* utilityDBLookup.php **/

class UtilityDBLookup {

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
			if( $state_abbr == strtoupper( $row['short_code'])) {
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
	    $rs = $db->query( $sql);
	    
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
	
}
?>