<?php
	// Refer back to calling page
	if( isset($_POST['formAction']) ) {
		session_start();
    	header("Location:". $_SESSION['back']); 
    }
    session_start();
    $_SESSION['back']= $_SERVER['HTTP_REFERER'];
?>