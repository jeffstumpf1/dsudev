<?php
/**
 Simple Example of accessing the database
*/

class MyDB extends SQLite3
{
	function __construct()
	{
		$this->open('dsu.db');
	}
}

$db = new MyDB();
$result = $db->query('select bar from customer');
var_dump($result->fetchArray());
echo (var_dump);
?>