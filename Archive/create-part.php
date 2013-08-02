<?php
/* Controller to direct which part php page */
    $url = '';
    $category='';
	$category = $_POST['category'];
	
	switch ( strtolower($category) ) {
		case 'fs':
			$url = "sprocket.php?status=A&cat=FS";
			break;
		case 'rs':
			$url = "sprocket.php?status=A&cat=RS";
			break;
		case 'ch':
			$url = "chain.php?status=A&cat=CH";
			break;
		case 'kt':
			$url = "kit.php?status=A&cat=KT";
			break;
		case 'ot':
			$url = "part.php?status=A&cat=OT";
			break;			
			
	}
	
	header ("location:".$url);

?>