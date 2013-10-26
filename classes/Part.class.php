<?php
/* Part **/

class Part {
	
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
    	$this->log = Logger::getLogger(__CLASS__);
		$this->msg('The class "'. __CLASS__. '" was initiated!');
		
    }  
	
	/** Logger can be used from any member method. */
    public function msg($msg, $level=null) {
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
	
	/** Used for the JQuery Autocomplete box **/
	public function MasterPartAutoComplete($search) {
		$sql = sprintf("select part_number from %s where rec_status='0' and part_number like '%s%s' limit 25", Constants::TABLE_PART, $search,'%');
		$rs = $this->db->query( $sql); 
		
		// work var
		$t='';
		$b0='{"id":';
		$b1='","label":"';
		$b3= '","value":"';
		
		// Build JSOn
		while ($row = $rs->fetch() ) {
			$t= $t . '{"id":"'. $row['part_number'] .'", "label":"'. $row['part_number'] .'", "value":"'. $row['part_number'] .'"},';   
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
	


	public function GetMasterPartByPartNumber($part_number) {
		$sql = sprintf( "select * from %s where part_number='%s'", Constants::TABLE_PART, $part_number);
		// fetch data
		$rs = $this->db->query( $sql);  
		$row = $rs->fetch();
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($row). "<p/>";
		}
		
		return $row;
	}





	
	public function ListParts($search) {
		if($search=='KT' || $search=='CH' || $search=='FS' || $search=='RS' || $search=='CR' || $search=='RI' ||$search=='OT') {
			$sql = "select * from ". Constants::TABLE_PART ." where rec_status='0' and category_id='". $search ."' Order by part_number";
		} else if($search) {
			$sql = sprintf("select * from %s where rec_status=0 and part_number like '%s%s' limit %s", Constants::TABLE_PART, $search,'%',Constants::LIMIT_ROWS); 
		} else {
			$sql = "select * from ". Constants::TABLE_PART ." where rec_status='0' LIMIT ". Constants::LIMIT_ROWS ;
		}
		
		// fetch data
		$rs = $this->db->query( $sql);  
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($rs). "<p/>";
		}
		
		return $rs;

	}
	

	public function GetKit($part_number) {
		$sql = sprintf( "select a.*, b.* from %s a, %s b where a.part_number = b.part_number and a.category_id='KT' and a.rec_status=0 and a.part_number = '%s'", Constants::TABLE_PART, Constants::TABLE_CHAIN_KIT, $part_number,'%' );

		$this->msg(__METHOD__);
		$this->msg($sql);
		
		// fetch data
		$rs = $this->db->query( $sql);
		$row = $rs->fetch();
		  
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($rs). "<p/>";
		}
		
		return $row;

	}

	
	public function ListKits($search) {
		$sql = "select a.*, b.* from ". Constants::TABLE_PART ." a, ". Constants::TABLE_CHAIN_KIT ." b where a.part_number = b.part_number and a.rec_status=0 and a.category_id='KT'";
		if( $pitch ) {
			$sql = sprintf( "select a.*, b.* from %s a, %s b where a.part_number = b.part_number and a.category_id='KT' and a.rec_status=0 and a.part_id = %s", Constants::TABLE_PART, Constants::TABLE_CHAIN_KIT, $search,'%' );
		}
		$this->msg(__METHOD__);
		$this->msg($sql);
		
		// fetch data
		$rs = $this->db->query( $sql);  
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<p />";  
			print_r($rs). "<p/>";
		}
		
		return $rs;

	}

	public function DeletePart($category, $partNumber) {
		echo __METHOD__, " - ", $part, $cat, "<p />";  
		$sql = sprintf("DELETE FROM %s WHERE part_number ='%s'", Constants::TABLE_PART, $partNumber);
		//$sql = "DELETE FROM ". Constants::TABLE_PART ." WHERE part_number ='". $part ."'";
		$cmd = $this->db->query( $sql );
		$cnt = $cmd->affected();
		
		if($this->debug=='On') {
			echo __METHOD__, " - ", $sql, "<br />";  
			if($cmd->isError()) {
				echo "Error: ". $cmd->isError()."<br/>";
				echo "[".$cnt."]<br/>";
			}
		}

		// Delete the right category table
		switch ( $category ) {
			case 'KT':
				$sql = sprintf("DELETE FROM ". Constants::TABLE_CHAIN_KIT ." WHERE part_number='%s'", $partNumber);	
				break;
			case 'CH':
				$sql = sprintf("DELETE FROM ". Constants::TABLE_CHAIN ." WHERE part_number='%s'", $partNumber);	
				break;
			case 'FS':
				$sql = sprintf("DELETE FROM ". Constants::TABLE_SPROCKET ." WHERE part_number='%s'", $partNumber);	
				break;
			case 'RS':
				$sql = sprintf("DELETE FROM ". Constants::TABLE_SPROCKET ." WHERE part_number='%s'", $partNumber);	
				break;
			case 'OT':
				//$sql = "DELETE FROM Other WHERE part_number=". $part;	
				break;
		}
	
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
	
	
	public function test($part){
		echo __METHOD__, " - ", $part, "<p />";  
		$sql = "DELETE FROM ". Constants::TABLE_PART ." WHERE part_number ='". $part ."'";
		echo $sql;
	}
	
}
?>