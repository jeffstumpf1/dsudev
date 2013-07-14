<?php 
$filename = $_SERVER['DOCUMENT_ROOT'] . 'classes/mysql.class.php';

if(file_exists( $filename )) {
	require_once $filename;
} else {
	$filename = 'common/error-404.inc';
	require_once $filename;
}
$host = 'localhost';
$user = 'dsuAdmin';
$pass = 'drive$ystem';
$name = 'dsu';
$db = new MySQL($host,$user,$pass,$name) or trigger_error(mysql_error(),E_USER_ERROR);;
?>



