<?php
 /* clsUtiltiy.php **/


class Utility {
	
	/**
    * MySQL server hostname
    * @access public
    * @retuns string
    */
	function GetStatesList($db, $state_abbr){
		// fetch data
		$sql = "SELECT * FROM StateList WHERE rec_status = 0 ORDER BY state_name";
	    $rs = $db->query( $sql);
	    
		while ($row = $rs->fetch()) {
			$html = "";
			if( $state_abbr == strtoupper( $row['state_abbr'])) {
				echo "<option value='". $row['state_abbr'] ."' SELECTED>". $row['state_name'] ."</option>";
			} else {
				echo "<option value='". $row['state_abbr'] ."'>". $row['state_name'] ."</option>";
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
	


	function GetCategoryList($db, $category){
		// fetch data
		$sql = "SELECT * FROM CategoryList WHERE rec_status = '0' ORDER BY description";
	    $rs = $db->query( $sql);
	    
		while ($row = $rs->fetch()) {
			$html = "";
			
			if( $category == $row['short_code']) {
				echo "<option value='". $row['short_code'] ."' SELECTED>". $row['description'] ."</option>";
			} else {
				echo "<option value='". $row['short_code'] ."'>". $row['description'] ."</option>";
			} 
			//mysql_free_result($rs);
		}
	}

	

	function GetBrandList($db, $pitch){
		// fetch data
		$sql = "SELECT * FROM ProductBrandList WHERE rec_status = 0 ORDER BY state_name";
	    $rs = $db->query( $sql);
	    
		while ($row = $rs->fetch()) {
			$html = "";
			if( $pitch == strtoupper( $row['short_code'])) {
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
	    $rs = $db->query( $sql);
	    
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




	function GetRecStatus($status) {
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
	function NumberFormat( $val, $out ) {
		$retVal = 0;
		switch ($out) {
			case '$':
				$retVal = money_format('$%i', $val);
				break;
			
		}		
		
		return $retVal;
	}


	// Number Format
	function CalculateChainCost( $val, $chainLength, $out ) {
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

}
?>