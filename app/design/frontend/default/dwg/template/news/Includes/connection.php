<?php
require("config.php");

ini_set('display_errors',1);
error_reporting(E_ALL & ~ E_NOTICE);

// 1. Create a database connection
$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
if (!$connection) {
	die("Database connection failed: " . mysql_error());
}

// 2. Select a database to use 
$db_select = mysql_select_db(DB_NAME,$connection);
if (!$db_select) {
	die("Database selection failed: " . mysql_error());
}
?>
